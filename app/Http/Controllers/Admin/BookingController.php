<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('laboratory')->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        if ($request->status === 'approved') {
            $overlapping = Booking::where('laboratory_id', $booking->laboratory_id)
                ->where('status', 'approved')
                ->where('id', '!=', $booking->id)
                ->where('start_time', '<', $booking->end_time)
                ->where('end_time', '>', $booking->start_time)
                ->exists();

            if ($overlapping) {
                return back()->with('error', 'Gagal menyetujui: Jadwal bentrok dengan peminjaman lain yang sudah disetujui.');
            }
        }

        $booking->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
