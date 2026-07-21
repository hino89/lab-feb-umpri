<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laboratory;
use App\Models\LaboratoryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaboratoryController extends Controller
{
    public function index()
    {
        $laboratories = Laboratory::latest()->paginate(10);
        return view('admin.laboratories.index', compact('laboratories'));
    }

    public function create()
    {
        return view('admin.laboratories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $laboratory = Laboratory::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('laboratories', 'public');
                $laboratory->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.laboratories.index')->with('success', 'Laboratorium berhasil ditambahkan.');
    }

    public function edit(Laboratory $laboratory)
    {
        $laboratory->load('images');
        return view('admin.laboratories.form', compact('laboratory'));
    }

    public function update(Request $request, Laboratory $laboratory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $laboratory->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('laboratories', 'public');
                $laboratory->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.laboratories.index')->with('success', 'Laboratorium berhasil diperbarui.');
    }

    public function destroy(Laboratory $laboratory)
    {
        foreach ($laboratory->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        $laboratory->delete();
        return redirect()->route('admin.laboratories.index')->with('success', 'Laboratorium berhasil dihapus.');
    }

    public function destroyImage(LaboratoryImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Foto laboratorium dihapus.');
    }
}
