<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <x-input-label for="chambre_id" value="Room" />
        <select id="chambre_id" name="chambre_id" class="form-input-blue mt-1" required>
            @foreach ($chambres as $chambre)
                <option value="{{ $chambre->id }}" @selected((int) old('chambre_id', $reservation->chambre_id) === $chambre->id)>
                    Room {{ $chambre->numero }} — {{ $chambre->type }} — {{ number_format($chambre->prix, 2) }} MAD/night
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('chambre_id')" />
    </div>

    <div>
        <x-input-label for="date_debut" value="Check-in Date" />
        <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full" :value="old('date_debut', optional($reservation->date_debut)?->format('Y-m-d'))" required />
        <x-input-error class="mt-2" :messages="$errors->get('date_debut')" />
    </div>

    <div>
        <x-input-label for="date_fin" value="Check-out Date" />
        <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full" :value="old('date_fin', optional($reservation->date_fin)?->format('Y-m-d'))" required />
        <x-input-error class="mt-2" :messages="$errors->get('date_fin')" />
    </div>

    <div>
        <x-input-label for="nombre_personnes" value="Number of Guests" />
        <x-text-input id="nombre_personnes" name="nombre_personnes" type="number" min="1" max="8" class="mt-1 block w-full" :value="old('nombre_personnes', $reservation->nombre_personnes ?? 1)" required />
        <x-input-error class="mt-2" :messages="$errors->get('nombre_personnes')" />
    </div>

    @if ($isAdminView ?? false)
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="form-input-blue mt-1" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $reservation->status) === $status)>{{ \App\Models\Reservation::STATUS_LABELS[$status] ?? $status }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>
    @endif
</div>
