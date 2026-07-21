@extends('layouts.admin')
@section('title', isset($laboratory) ? 'Edit Laboratorium' : 'Tambah Laboratorium')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.laboratories.index') }}" class="text-gray-500 hover:text-gray-700">
        &larr; Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">{{ isset($laboratory) ? 'Edit Laboratorium' : 'Tambah Laboratorium' }}</h1>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <form action="{{ isset($laboratory) ? route('admin.laboratories.update', $laboratory->id) : route('admin.laboratories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($laboratory))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Laboratorium</label>
                <input type="text" name="name" value="{{ old('name', $laboratory->name ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $laboratory->location ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Orang)</label>
                <input type="number" name="capacity" value="{{ old('capacity', $laboratory->capacity ?? '') }}" required min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center mt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $laboratory->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif (Dapat dipinjam)</label>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
            <input type="text" name="facilities" value="{{ old('facilities', $laboratory->facilities ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" placeholder="Misal: 20 PC, AC, Proyektor">
            @error('facilities') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $laboratory->description ?? '') }}</textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto Tambahan</label>
            <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-xs text-gray-500 mt-1">Anda dapat memilih lebih dari 1 foto.</p>
            @error('images.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('admin.laboratories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>

    @if(isset($laboratory) && $laboratory->images->count() > 0)
    <div class="mt-10 pt-6 border-t border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Saat Ini</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($laboratory->images as $image)
            <div class="relative group border rounded-md overflow-hidden">
                <img src="{{ Storage::url($image->image_path) }}" class="w-full h-32 object-cover">
                <form action="{{ route('admin.laboratories.images.destroy', $image->id) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition" onsubmit="return confirm('Hapus foto ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white p-1 rounded-full hover:bg-red-700 shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
