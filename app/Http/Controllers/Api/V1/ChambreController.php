<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChambreController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'type' => ['nullable', Rule::in(Chambre::TYPES)],
            'confort' => ['nullable', Rule::in(Chambre::CONFORTS)],
            'prix_min' => ['nullable', 'numeric', 'min:0'],
            'prix_max' => ['nullable', 'numeric', 'min:0', 'gte:prix_min'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after:date_debut'],
        ]);

        $query = Chambre::query()
            ->filter($filters)
            ->when(
                empty($filters['date_debut']) || empty($filters['date_fin']),
                fn ($query) => $query->where('status', 'disponible')
            )
            ->orderBy('numero');

        return response()->json($query->paginate(10)->withQueryString());
    }

    public function show(Chambre $chambre): JsonResponse
    {
        return response()->json([
            'data' => $chambre,
        ]);
    }

    public function availability(Request $request): JsonResponse
    {
        $data = $request->validate([
            'chambre_id' => ['required', 'exists:chambres,id'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
        ]);

        $chambre = Chambre::findOrFail($data['chambre_id']);
        $available = $chambre->status === 'disponible'
            && ! Reservation::conflictsForRoom($chambre->id, $data['date_debut'], $data['date_fin']);

        return response()->json([
            'available' => $available,
            'chambre_id' => $chambre->id,
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
        ]);
    }
}
