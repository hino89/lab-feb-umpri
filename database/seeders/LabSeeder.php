<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laboratory;
use App\Models\Booking;
use App\Models\LaboratoryImage;

class LabSeeder extends Seeder
{
    public function run()
    {
        // Hapus data booking & gambar terkait agar tidak error foreign key
        Booking::query()->delete();
        LaboratoryImage::query()->delete();
        Laboratory::query()->delete();

        Laboratory::create([
            'name' => 'Laboratorium Keuangan (Tax Center & Disabilitas)',
            'location' => 'Lantai 3 Gedung FEB UMPRI',
            'capacity' => 25,
            'description' => "Ruang berkonsep Accessible & Professional. Menggabungkan area formal dan lesehan untuk konsultasi pajak (Tax Center) serta ruang gerak lega yang ramah disabilitas.",
            'facilities' => "AC, Papan Tulis, Kursi, Area Tax Center, Area Disabilitas, Bean Bags, Karpet Anti-Slip, Meja Lipat Lesehan.",
            'is_active' => true,
        ]);

        Laboratory::create([
            'name' => 'Laboratorium Pemasaran',
            'location' => 'Lantai 3 Gedung FEB UMPRI',
            'capacity' => 25,
            'description' => "Creative Hub & Mini Studio yang dinamis. Dirancang untuk mencari inspirasi, pembuatan konten kreatif (foto/video), dan presentasi produk pemasaran.",
            'facilities' => "AC, Papan Tulis, Kursi, Content Creation Corner, Idea Space, Bean Bags, Karpet Rasfur, Green Screen, Ring Light.",
            'is_active' => true,
        ]);

        Laboratory::create([
            'name' => 'Laboratorium Sumber Daya Manusia (SDM)',
            'location' => 'Lantai 3 Gedung FEB UMPRI',
            'capacity' => 25,
            'description' => "FGD & Ruang Simulasi bernuansa hangat. Berfokus pada kolaborasi, sangat cocok untuk simulasi wawancara kerja, pelatihan, dan diskusi kelompok (FGD).",
            'facilities' => "AC, Papan Tulis, Kursi, Interview Corner, FGD Circle, Bean Bags, Karpet Busa, Papan Mading, Meja Bundar.",
            'is_active' => true,
        ]);
    }
}
