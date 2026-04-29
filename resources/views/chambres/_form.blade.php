@php
    $equipementsValue = old('equipements', implode(', ', $chambre->equipements_list));
@endphp

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="numero" value="Room Number" />
        <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" :value="old('numero', $chambre->numero)" required />
        <x-input-error class="mt-2" :messages="$errors->get('numero')" />
    </div>

    <div>
        <x-input-label for="prix" value="Price per Night (MAD)" />
        <x-text-input id="prix" name="prix" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('prix', $chambre->prix)" required />
        <x-input-error class="mt-2" :messages="$errors->get('prix')" />
    </div>

    <div>
        <x-input-label for="type" value="Room Type" />
        <select id="type" name="type" class="form-input-blue mt-1" required>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(old('type', $chambre->type) === $type)>{{ $type }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('type')" />
    </div>

    <div>
        <x-input-label for="confort" value="Comfort Level" />
        <select id="confort" name="confort" class="form-input-blue mt-1" required>
            @foreach ($conforts as $confort)
                <option value="{{ $confort }}" @selected(old('confort', $chambre->confort) === $confort)>{{ $confort }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('confort')" />
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="form-input-blue mt-1" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $chambre->status) === $status)>{{ \App\Models\Chambre::STATUS_LABELS[$status] ?? $status }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>

    <div>
        <x-input-label for="image" value="Image URL" />
        <x-text-input id="image" name="image" type="text" class="mt-1 block w-full" :value="old('image', $chambre->image)" placeholder="https://..." />
        <x-input-error class="mt-2" :messages="$errors->get('image')" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="equipements" value="Amenities (comma-separated)" />
        <x-text-input id="equipements" name="equipements" type="text" class="mt-1 block w-full" :value="$equipementsValue" placeholder="WiFi, TV, AC, Parking, Breakfast" />
        <x-input-error class="mt-2" :messages="$errors->get('equipements')" />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="4" class="form-input-blue mt-1">{{ old('description', $chambre->description) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>
</div>
