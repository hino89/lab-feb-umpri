@extends('layouts.app')

@section('hero')
<style>
@keyframes small-bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(6px); }
}
.animate-small-bounce {
    animation: small-bounce 2s infinite ease-in-out;
}
</style>
<div class="relative w-full h-[calc(100vh-4rem)] bg-gray-900 overflow-hidden flex items-center justify-center">
    <!-- Diagonal 3-split background with placeholders and thin white lines -->
    <div class="absolute inset-0 overflow-hidden bg-black">
        <!-- Block 1 (Left) -->
        <div class="absolute top-0 bottom-0 -left-[20%] w-[53.33%] transform -skew-x-[12deg] border-r-[1.5px] border-white/80 overflow-hidden z-10">
            <img src="https://placehold.co/800x1200/1e3a8a/ffffff?text=Lab+1" alt="Lab 1" class="absolute inset-0 w-full h-full object-cover transform skew-x-[12deg] scale-[1.35] ml-[10%]">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <!-- Block 2 (Center) -->
        <div class="absolute top-0 bottom-0 left-[33.33%] w-[33.34%] transform -skew-x-[12deg] border-r-[1.5px] border-white/80 overflow-hidden z-10">
            <img src="https://placehold.co/800x1200/1d4ed8/ffffff?text=Lab+2" alt="Lab 2" class="absolute inset-0 w-full h-full object-cover transform skew-x-[12deg] scale-125">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <!-- Block 3 (Right) -->
        <div class="absolute top-0 bottom-0 left-[66.67%] w-[53.33%] transform -skew-x-[12deg] overflow-hidden z-10">
            <img src="https://placehold.co/800x1200/312e81/ffffff?text=Lab+3" alt="Lab 3" class="absolute inset-0 w-full h-full object-cover transform skew-x-[12deg] scale-[1.35] -ml-[10%]">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
    </div>

    <!-- Content overlay -->
    <div class="relative z-20 max-w-4xl mx-auto text-center px-4">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 tracking-tight drop-shadow-xl leading-tight">
            Laboratorium Fakultas Ekonomi dan Bisnis<br>
            <span class="text-blue-200">Universitas Muhammadiyah Pringsewu</span>
        </h1>
        <p class="text-base md:text-lg text-gray-200 font-light leading-relaxed drop-shadow max-w-2xl mx-auto">
            Mendukung penuh kegiatan praktikum, riset, dan pengembangan keahlian mahasiswa dengan fasilitas yang modern.
        </p>
    </div>

    <!-- Small bounce chevron scroll animation -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20">
        <a href="#lab-list" class="flex items-center justify-center text-white opacity-70 hover:opacity-100 transition duration-300 animate-small-bounce">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Lab Listing -->
<div id="lab-list" class="space-y-24 py-12">
    @forelse($laboratories as $index => $lab)
        <div class="flex flex-col {{ $index % 2 == 1 ? 'lg:flex-row-reverse' : 'lg:flex-row' }} gap-12 items-center group">
            
            <!-- Image Section -->
            <div class="w-full lg:w-[60%]">
                <div class="relative aspect-[16/10] rounded-2xl overflow-hidden shadow-lg group-hover:shadow-xl transition duration-500">
                    @if($lab->images->where('is_primary', true)->first())
                        <img src="{{ Storage::url($lab->images->where('is_primary', true)->first()->image_path) }}" alt="{{ $lab->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">
                    @elseif($lab->images->first())
                        <img src="{{ Storage::url($lab->images->first()->image_path) }}" alt="{{ $lab->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">
                    @else
                        <div class="w-full h-full bg-gray-100 flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="text-sm font-medium">Belum ada foto</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="w-full lg:w-[40%] space-y-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3 group-hover:text-primary transition duration-300">{{ $lab->name }}</h2>
                    <div class="flex flex-wrap gap-3">
                        @if($lab->is_currently_in_use)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-red-50 text-red-700 border border-red-100">
                                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Lab sedang dipakai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Tersedia saat ini
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Kapasitas: {{ $lab->capacity }} Orang
                        </span>
                        @if($lab->location)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-gray-50 text-gray-700 border border-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $lab->location }}
                        </span>
                        @endif
                    </div>
                </div>
                
                <p class="text-gray-600 text-lg leading-relaxed line-clamp-3">
                    {{ $lab->description ?? 'Deskripsi laboratorium belum ditambahkan oleh admin.' }}
                </p>

                <div class="pt-4">
                    <a href="{{ route('lab.show', $lab->id) }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary text-white rounded-full font-medium hover:bg-blue-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300 group/btn">
                        Lihat Detail & Ajukan Booking
                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Laboratorium</h3>
            <p class="mt-2 text-gray-500">Sistem belum memiliki data laboratorium yang aktif saat ini.</p>
        </div>
    @endforelse
</div>
@endsection
