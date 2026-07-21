<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratory;
use App\Models\Booking;

class PublicController extends Controller
{
    public function index()
    {
        $laboratories = Laboratory::where('is_active', true)->with('images')->get();
        return view('welcome', compact('laboratories'));
    }

    public function show($id)
    {
        $laboratory = Laboratory::with(['images', 'bookings' => function($q) {
            $q->where('status', 'approved')->orderBy('start_time');
        }])->findOrFail($id);

        return view('show', compact('laboratory'));
    }

    public function storeBooking(Request $request, $id)
    {
        $request->validate([
            'booker_name' => 'required|string|max:255',
            'booker_id' => 'required|string|max:255',
            'booker_type' => 'required|in:mahasiswa,dosen',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string',
        ]);

        $laboratory = Laboratory::findOrFail($id);

        $start_datetime = $request->booking_date . ' ' . $request->start_time . ':00';
        $end_datetime = $request->booking_date . ' ' . $request->end_time . ':00';

        // Check double booking
        $overlapping = Booking::where('laboratory_id', $id)
            ->where('status', 'approved')
            ->where('start_time', '<', $end_datetime)
            ->where('end_time', '>', $start_datetime)
            ->exists();

        if ($overlapping) {
            return back()->with('error', 'Jadwal tidak tersedia di waktu tersebut (sudah ada yang booking).')->withInput();
        }

        Booking::create([
            'laboratory_id' => $id,
            'booker_name' => $request->booker_name,
            'booker_id' => $request->booker_id,
            'booker_type' => $request->booker_type,
            'start_time' => $start_datetime,
            'end_time' => $end_datetime,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan booking berhasil, menunggu persetujuan pengelola.');
    }
}
