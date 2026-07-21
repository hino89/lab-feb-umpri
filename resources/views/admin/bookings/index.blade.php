@extends('layouts.admin')
@section('title', 'Manajemen Peminjaman')

@section('content')
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
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Disetujui</span>
                        @elseif($booking->status === 'rejected')
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Ditolak</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-right flex justify-end gap-2">
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Detail/Proses</a>
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
@endsection
