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
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string',
        ]);

        $laboratory = Laboratory::findOrFail($id);

        // Check double booking
        $overlapping = Booking::where('laboratory_id', $id)
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })->exists();

        if ($overlapping) {
            return back()->with('error', 'Jadwal tidak tersedia di waktu tersebut (sudah ada yang booking).')->withInput();
        }

        Booking::create([
            'laboratory_id' => $id,
            'booker_name' => $request->booker_name,
            'booker_id' => $request->booker_id,
            'booker_type' => $request->booker_type,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan booking berhasil, menunggu persetujuan pengelola.');
    }
}
