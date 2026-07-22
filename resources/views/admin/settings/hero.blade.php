@extends('layouts.admin')

@section('title', 'Pengaturan Beranda')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Pengaturan Gambar Hero Beranda</h1>
    <p class="text-gray-600">Atur 3 gambar utama yang muncul di halaman beranda. Gambar yang diunggah akan otomatis memotong dan menyesuaikan ukuran (rekomendasi rasio portrait/vertikal, atau minimal 800x1200 px).</p>
</div>

<div class="bg-white rounded-lg shadow-sm border p-6">
    <form action="{{ route('admin.settings.hero.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @for ($i = 1; $i <= 3; $i++)
            <div class="border rounded-xl p-4 bg-gray-50 flex flex-col items-center">
                <h3 class="font-bold text-gray-800 mb-4 text-center">Gambar Blok {{ $i }}</h3>
                
                @php
                    $heroFiles = collect(Storage::disk('public')->files('hero'))->filter(fn($file) => str_starts_with(basename($file), $i . '.'));
                    $currentImage = $heroFiles->first() ? Storage::url($heroFiles->first()) : null;
                @endphp

                <div class="w-full aspect-[2/3] bg-gray-200 rounded-lg overflow-hidden border border-gray-300 mb-4 flex items-center justify-center relative group">
                    @if($currentImage)
                        <img src="{{ $currentImage }}" alt="Hero {{ $i }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-gray-400 text-sm flex flex-col items-center">
                            <svg class="w-10 h-10 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Belum Ada
                        </div>
                    @endif
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (opsional)</label>
                    <input type="file" name="hero_{{ $i }}" accept="image/jpeg,image/png,image/webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('hero_' . $i)
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endfor
        </div>

        <div class="flex justify-end pt-4 border-t">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
