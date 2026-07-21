@extends('layouts.admin')
@section('title', 'Manajemen Laboratorium')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Laboratorium</h1>
    <a href="{{ route('admin.laboratories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Tambah Laboratorium
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                    <th class="px-6 py-3 font-medium">Nama Lab</th>
                    <th class="px-6 py-3 font-medium">Lokasi</th>
                    <th class="px-6 py-3 font-medium">Kapasitas</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($laboratories as $lab)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $lab->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $lab->location }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $lab->capacity }} Orang</td>
                    <td class="px-6 py-4 text-sm">
                        @if($lab->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-right flex justify-end gap-2">
                        <a href="{{ route('admin.laboratories.edit', $lab->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                        <form action="{{ route('admin.laboratories.destroy', $lab->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laboratorium ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Tidak ada data laboratorium.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($laboratories->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $laboratories->links() }}
    </div>
    @endif
</div>
@endsection
