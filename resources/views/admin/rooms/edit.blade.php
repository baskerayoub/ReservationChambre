@extends('layouts.app')
@section('title', 'Edit Room')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold mb-6">Edit: {{ $room->name }}</h1>
    <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-6">
            <div class="col-span-2"><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" value="{{ old('name', $room->name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Type</label><select name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500">@foreach(['single','double','deluxe','suite','family'] as $t)<option value="{{ $t }}" {{ $room->type==$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium mb-1">Price/Night ($)</label><input type="number" name="price_per_night" step="0.01" value="{{ old('price_per_night', $room->price_per_night) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Capacity</label><input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Beds</label><input type="number" name="beds" value="{{ old('beds', $room->beds) }}" min="1" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Bathrooms</label><input type="number" name="bathrooms" value="{{ old('bathrooms', $room->bathrooms) }}" min="1" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Area (m²)</label><input type="number" name="area" value="{{ old('area', $room->area) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Floor</label><input type="number" name="floor" value="{{ old('floor', $room->floor) }}" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
            <div><label class="block text-sm font-medium mb-1">Status</label><select name="status" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500">@foreach(['available','maintenance','occupied'] as $s)<option value="{{ $s }}" {{ $room->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
        </div>
        <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="4" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500">{{ old('description', $room->description) }}</textarea></div>
        <div><label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500" {{ $room->is_featured ? 'checked' : '' }}><span class="text-sm font-medium">Featured</span></label></div>
        @if($amenities->count())
        <div><label class="block text-sm font-medium mb-2">Amenities</label><div class="grid grid-cols-2 sm:grid-cols-3 gap-2">@foreach($amenities as $a)<label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg"><input type="checkbox" name="amenities[]" value="{{ $a->id }}" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500" {{ $room->amenities->contains($a->id) ? 'checked' : '' }}><span class="text-sm">{{ $a->name }}</span></label>@endforeach</div></div>
        @endif
        <div><label class="block text-sm font-medium mb-1">Add More Images</label><input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-amber-50 file:text-amber-600 file:font-medium hover:file:bg-amber-100"/></div>
        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl"><i class="fas fa-save mr-2"></i>Update Room</button>
    </form>
</div>
@endsection
