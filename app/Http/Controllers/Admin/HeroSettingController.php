<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.hero');
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        foreach (['hero_1' => '1', 'hero_2' => '2', 'hero_3' => '3'] as $input => $prefix) {
            if ($request->hasFile($input)) {
                // Create directory if not exists
                if (!Storage::disk('public')->exists('hero')) {
                    Storage::disk('public')->makeDirectory('hero');
                }

                // Delete old files starting with this prefix
                $oldFiles = collect(Storage::disk('public')->files('hero'))
                            ->filter(fn($file) => str_starts_with(basename($file), $prefix . '.'));
                
                foreach ($oldFiles as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }

                $ext = $request->file($input)->getClientOriginalExtension();
                $request->file($input)->storeAs('hero', $prefix . '.' . $ext, 'public');
            }
        }

        return back()->with('success', 'Gambar hero beranda berhasil diperbarui.');
    }
}
