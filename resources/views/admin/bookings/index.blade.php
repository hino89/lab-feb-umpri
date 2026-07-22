@extends('layouts.admin')
@section('title', 'Manajemen Peminjaman')

@section('content')
<div id="bookings-wrapper" x-data x-init="setInterval(() => { fetch(window.location.href).then(r => r.text()).then(h => { const doc = new DOMParser().parseFromString(h, 'text/html'); $el.innerHTML = doc.querySelector('#bookings-wrapper').innerHTML; }) }, 10000)">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Peminjaman Laboratorium</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">Peminjam</th>
                        <th class="px-6 py-3 font-medium">Laboratorium</th>
                        <th class="px-6 py-3 font-medium">Waktu</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-800">
                            <div class="font-medium">{{ $booking->booker_name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->booker_type }} - {{ $booking->booker_id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $booking->laboratory->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div>{{ $booking->start_time->format('d M Y, H:i') }}</div>
                            <div class="text-xs">s/d {{ $booking->end_time->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($booking->status === 'approved')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium border border-green-200">Disetujui</span>
                            @elseif($booking->status === 'rejected')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium border border-red-200">Ditolak</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium border border-yellow-200 animate-pulse">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right flex justify-end gap-3">
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-blue-600 hover:text-blue-900 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Detail/Proses
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
