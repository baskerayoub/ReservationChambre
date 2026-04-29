<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChambreRequest;
use App\Http\Requests\UpdateChambreRequest;
use App\Models\Chambre;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ChambreController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'type' => ['nullable', Rule::in(Chambre::TYPES)],
            'confort' => ['nullable', Rule::in(Chambre::CONFORTS)],
            'prix_min' => ['nullable', 'numeric', 'min:0'],
            'prix_max' => ['nullable', 'numeric', 'min:0', 'gte:prix_min'],
            'equipements' => ['nullable', 'array'],
            'equipements.*' => ['string', Rule::in(Chambre::EQUIPEMENTS)],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after:date_debut'],
        ]);

        $isAdminView = $this->isAdminRoute($request);

        $query = Chambre::query()
            ->withCount('reservations')
            ->filter($filters)
            ->latest('id');

        if (! $isAdminView && (empty($filters['date_debut']) || empty($filters['date_fin']))) {
            $query->where('status', 'disponible');
        }

        return view('chambres.index', [
            'chambres' => $query->paginate(9)->withQueryString(),
            'filters' => $filters,
            'isAdminView' => $isAdminView,
            'types' => Chambre::TYPES,
            'conforts' => Chambre::CONFORTS,
            'equipements' => Chambre::EQUIPEMENTS,
        ]);
    }

    public function create(): View
    {
        return view('chambres.create', [
            'chambre' => new Chambre(['status' => 'disponible']),
            'types' => Chambre::TYPES,
            'conforts' => Chambre::CONFORTS,
            'statuses' => Chambre::STATUSES,
            'equipements' => Chambre::EQUIPEMENTS,
        ]);
    }

    public function store(StoreChambreRequest $request): RedirectResponse
    {
        Chambre::create($this->validatedRoomData($request->validated()));

        return redirect()
            ->route('admin.chambres.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Request $request, Chambre $chambre): View
    {
        $filters = $request->validate([
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after:date_debut'],
        ]);

        $isAvailableForDates = null;

        if (! empty($filters['date_debut']) && ! empty($filters['date_fin'])) {
            $isAvailableForDates = $chambre->status === 'disponible'
                && ! Reservation::conflictsForRoom($chambre->id, $filters['date_debut'], $filters['date_fin']);
        }

        return view('chambres.show', [
            'chambre' => $chambre,
            'filters' => $filters,
            'isAvailableForDates' => $isAvailableForDates,
            'isAdminView' => $this->isAdminRoute($request),
        ]);
    }

    public function edit(Chambre $chambre): View
    {
        return view('chambres.edit', [
            'chambre' => $chambre,
            'types' => Chambre::TYPES,
            'conforts' => Chambre::CONFORTS,
            'statuses' => Chambre::STATUSES,
            'equipements' => Chambre::EQUIPEMENTS,
        ]);
    }

    public function update(UpdateChambreRequest $request, Chambre $chambre): RedirectResponse
    {
        $chambre->update($this->validatedRoomData($request->validated()));

        return redirect()
            ->route('admin.chambres.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Chambre $chambre): RedirectResponse
    {
        $chambre->delete();

        return redirect()
            ->route('admin.chambres.index')
            ->with('success', 'Room deleted successfully.');
    }

    private function validatedRoomData(array $data): array
    {
        $data['equipements'] = collect(explode(',', $data['equipements'] ?? ''))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();

        return $data;
    }

    private function isAdminRoute(Request $request): bool
    {
        return str_starts_with((string) $request->route()?->getName(), 'admin.');
    }
}
