@extends('layouts.admin')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.bookings.index') }}" class="text-gray-500 hover:text-gray-700">
        &larr; Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Detail & Proses Peminjaman</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Peminjam</h3>
        <table class="w-full text-sm text-gray-600">
            <tr>
                <td class="py-2 font-medium w-1/3">Nama Lengkap</td>
                <td class="py-2">: {{ $booking->booker_name }}</td>
            </tr>
            <tr>
                <td class="py-2 font-medium">NPM / NIDN</td>
                <td class="py-2">: {{ $booking->booker_id }}</td>
            </tr>
            <tr>
                <td class="py-2 font-medium">Tipe Peminjam</td>
                <td class="py-2">: {{ ucfirst($booking->booker_type) }}</td>
            </tr>
        </table>

        <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6 border-b pb-2">Informasi Laboratorium</h3>
        <table class="w-full text-sm text-gray-600">
            <tr>
                <td class="py-2 font-medium w-1/3">Nama Lab</td>
                <td class="py-2">: {{ $booking->laboratory->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-2 font-medium">Waktu Mulai</td>
                <td class="py-2">: {{ $booking->start_time->format('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="py-2 font-medium">Waktu Selesai</td>
                <td class="py-2">: {{ $booking->end_time->format('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="py-2 font-medium align-top">Tujuan</td>
                <td class="py-2 align-top">: {{ $booking->purpose }}</td>
            </tr>
        </table>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Proses Pengajuan</h3>
        <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Peminjaman</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                    <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                    <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin (Opsional)</label>
                <textarea name="admin_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" placeholder="Beri alasan jika ditolak, atau instruksi jika disetujui.">{{ old('admin_notes', $booking->admin_notes ?? '') }}</textarea>
            </div>

            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Status
            </button>
        </form>

        <div class="mt-8 border-t pt-4">
            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Hapus data peminjaman ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center justify-center w-full">
                    Hapus Peminjaman
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
