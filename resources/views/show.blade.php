@extends('layouts.app')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('home') }}" class="text-primary hover:underline flex items-center gap-1">
        &larr; Kembali ke Daftar Lab
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Lab Info (Left side, takes 2 cols) -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6 gap-4">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">{{ $laboratory->name }}</h1>
                
                <div class="shrink-0 mt-1">
                    @if($laboratory->is_currently_in_use)
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-red-50 text-red-700 border border-red-200 shadow-sm">
                            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Lab sedang dipakai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tersedia saat ini
                        </span>
                    @endif
                </div>
            </div>
            
            <div x-data="{
                lightboxOpen: false,
                activeImageIndex: 0,
                images: [
                    @foreach($laboratory->images as $img)
                        '{{ Storage::url($img->image_path) }}',
                    @endforeach
                ],
                next() {
                    this.activeImageIndex = (this.activeImageIndex + 1) % this.images.length;
                },
                prev() {
                    this.activeImageIndex = (this.activeImageIndex - 1 + this.images.length) % this.images.length;
                }
            }">
                @if($laboratory->images->count() > 0)
                    <div class="flex overflow-x-auto custom-scrollbar gap-4 mb-8 pb-4 snap-x">
                        @foreach($laboratory->images as $index => $img)
                            <img @click="activeImageIndex = {{ $index }}; lightboxOpen = true" src="{{ Storage::url($img->image_path) }}" alt="Foto Lab" class="cursor-pointer h-[400px] w-full md:w-auto object-cover rounded-xl snap-center shrink-0 shadow-sm hover:opacity-90 transition">
                        @endforeach
                    </div>
                @endif

                <!-- Lightbox Modal -->
                <div x-show="lightboxOpen" style="display: none" class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-sm" @keydown.escape.window="lightboxOpen = false" @keydown.right.window="if(lightboxOpen) next()" @keydown.left.window="if(lightboxOpen) prev()">
                    
                    <!-- Close btn -->
                    <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white transition">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- Prev btn -->
                    <button @click.stop="prev()" class="absolute left-4 md:left-10 text-white/50 hover:text-white transition p-3 bg-black/50 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>

                    <!-- Image -->
                    <img :src="images[activeImageIndex]" class="max-h-[90vh] max-w-[90vw] object-contain rounded-lg shadow-2xl" @click.stop="">

                    <!-- Next btn -->
                    <button @click.stop="next()" class="absolute right-4 md:right-10 text-white/50 hover:text-white transition p-3 bg-black/50 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    
                    <!-- Image Counter -->
                    <div class="absolute bottom-6 text-white/70 font-medium tracking-widest text-sm">
                        <span x-text="activeImageIndex + 1"></span> / <span x-text="images.length"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-600">
                <!-- Kiri: Deskripsi -->
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Deskripsi</h3>
                    <p class="leading-relaxed text-gray-700 text-sm whitespace-pre-line text-justify">{{ $laboratory->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>

                <!-- Kanan: Fasilitas & Detail -->
                <div class="flex flex-col justify-between space-y-6">
                    <div class="space-y-3">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Fasilitas</h3>
                        <p class="leading-relaxed text-gray-700 text-sm whitespace-pre-line text-justify">{{ $laboratory->facilities ?? 'Tidak ada fasilitas.' }}</p>
                    </div>

                    <!-- Kapasitas dan Lokasi -->
                    <div class="grid grid-cols-2 gap-6 mt-auto pt-4">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Kapasitas</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $laboratory->capacity }} Orang</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Lokasi</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $laboratory->location ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-6" x-data="{
            selectedDate: '{{ $dateFilter }}',
            isLoading: false,
            async updateBookings() {
                this.isLoading = true;
                try {
                    const response = await fetch('{{ route('lab.show', $laboratory->id) }}?date=' + this.selectedDate);
                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const newTable = doc.getElementById('booking-table-wrapper');
                    document.getElementById('booking-table-wrapper').innerHTML = newTable.innerHTML;
                } catch (e) {
                    console.error('Gagal mengambil data jadwal', e);
                } finally {
                    this.isLoading = false;
                }
            }
        }">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-4">
                <h3 class="text-xl font-bold text-gray-900">Jadwal Penggunaan (Approved)</h3>
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600 font-medium">Filter Tanggal:</label>
                    <input type="date" x-model="selectedDate" @change="updateBookings()" class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-primary focus:border-primary px-3 py-1.5 border transition">
                </div>
            </div>
            
            <div id="booking-table-wrapper" class="relative min-h-[100px]">
                <!-- Loading overlay -->
                <div x-show="isLoading" style="display: none;" class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10 rounded">
                    <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>

                @if($laboratory->bookings->isEmpty())
                    <p class="text-gray-500 italic">Belum ada jadwal penggunaan yang disetujui pada tanggal tersebut.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($laboratory->bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->booker_name }} <span class="text-gray-500 text-xs">({{ ucfirst($booking->booker_type) }})</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $booking->purpose }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Booking Form (Right side, takes 1 col) -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border p-6 sticky top-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Ajukan Booking</h3>
            <form action="{{ route('lab.book', $laboratory->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="booker_name" value="{{ old('booker_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIM / NIDN</label>
                    <input type="text" name="booker_id" value="{{ old('booker_id') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="booker_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2 bg-white">
                        <option value="mahasiswa" {{ old('booker_type') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('booker_type') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Penggunaan</label>
                    <input type="date" name="booking_date" value="{{ old('booking_date') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Mulai (24H)</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Selesai (24H)</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Keperluan (Mata Kuliah / Acara)</label>
                    <textarea name="purpose" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm border px-3 py-2">{{ old('purpose') }}</textarea>
                </div>

                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    Submit Booking
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
