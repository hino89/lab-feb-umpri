@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Daftar Laboratorium</h1>
    <p class="mt-2 text-gray-600">Pilih laboratorium untuk melihat detail, jadwal, dan melakukan booking.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($laboratories as $lab)
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden hover:shadow-md transition">
        @if($lab->images->where('is_primary', true)->first())
            <img src="{{ Storage::url($lab->images->where('is_primary', true)->first()->image_path) }}" alt="{{ $lab->name }}" class="w-full h-48 object-cover">
        @elseif($lab->images->first())
            <img src="{{ Storage::url($lab->images->first()->image_path) }}" alt="{{ $lab->name }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        
        <div class="p-5">
            <div class="flex justify-between items-start">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $lab->name }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Kapasitas: {{ $lab->capacity }}
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $lab->description ?? 'Belum ada deskripsi.' }}</p>
            
            <a href="{{ route('lab.show', $lab->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                Lihat Detail & Booking
            </a>
        </div>
    </div>
    @endforeach
</div>

@if($laboratories->isEmpty())
<div class="text-center py-12 bg-white rounded-lg border border-dashed">
    <p class="text-gray-500">Belum ada data laboratorium yang aktif.</p>
</div>
@endif
@endsection
