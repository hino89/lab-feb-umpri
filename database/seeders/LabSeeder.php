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
            'location' => 'Gedung FEB UMPRI',
            'capacity' => 25,
            'description' => "Konsep: Accessible & Professional (Co-Working & Living Space)\n\nRuangan ini memiliki sirkulasi udara dan ruang gerak yang luas (ramah kursi roda) untuk Unit Layanan Disabilitas, namun tetap memiliki sudut profesional untuk konsultasi pajak.\n\nPembagian Area:\n- Zona Formal: Menggunakan kursi dan papan tulis yang sudah ada untuk materi, rapat, atau kerja fokus.\n- Zona Kolaborasi (Lesehan): Area santai menggunakan karpet dan bean bags untuk diskusi dan bedah kasus keuangan.",
            'facilities' => "Fasilitas & Penunjang:\n- Area Tax Center & Area Layanan Disabilitas\n- Kursi, Papan Tulis, & AC (Existing)\n- 2 pcs Bean Bag ukuran L\n- 1 pc Karpet tebal anti-slip (2x3 meter)\n- 2 pcs Meja lipat lesehan kayu\n- Papan akrilik penanda (Signage)",
            'is_active' => true,
        ]);

        Laboratory::create([
            'name' => 'Laboratorium Pemasaran',
            'location' => 'Gedung FEB UMPRI',
            'capacity' => 25,
            'description' => "Konsep: Creative Hub & Mini Studio (Co-Working & Living Space)\n\nRuangan yang dinamis dirancang untuk merangsang ide, membuat konten (content creation), dan memamerkan prototype produk mahasiswa.\n\nPembagian Area:\n- Zona Formal: Menggunakan kursi dan papan tulis yang sudah ada untuk materi, rapat, atau kerja fokus.\n- Zona Kolaborasi (Lesehan): Content Creation Corner (sudut studio mini untuk foto/video atau live streaming) dan Idea Space (area bean bags untuk mencari inspirasi dan brainstorming kampanye pemasaran).",
            'facilities' => "Fasilitas & Penunjang:\n- Content Creation Corner & Idea Space\n- Kursi, Papan Tulis, & AC (Existing)\n- 2 pcs Bean Bag ukuran L\n- 1 pc Karpet estetis/bulu rasfur (2x3 meter)\n- 1 set Background Stand + Kain Green Screen\n- 1 pc Ring Light + Tripod\n- Hiasan dinding / Poster motivasi marketing",
            'is_active' => true,
        ]);

        Laboratory::create([
            'name' => 'Laboratorium Sumber Daya Manusia (SDM)',
            'location' => 'Gedung FEB UMPRI',
            'capacity' => 25,
            'description' => "Konsep: FGD & Roleplay Room (Co-Working & Living Space)\n\nRuangan hangat yang dirancang khusus untuk simulasi wawancara kerja, pelatihan (training), dan diskusi kelompok.\n\nPembagian Area:\n- Zona Formal: Menggunakan kursi dan papan tulis yang sudah ada untuk materi, rapat, atau kerja fokus.\n- Zona Kolaborasi (Lesehan): Interview Corner (sudut simulasi wawancara kerja menggunakan kursi existing) dan FGD Circle (area melingkar di atas karpet untuk diskusi pemecahan masalah SDM).",
            'facilities' => "Fasilitas & Penunjang:\n- Interview Corner & FGD Circle\n- Kursi, Papan Tulis, & AC (Existing)\n- 3 pcs Bean Bag ukuran M/L\n- 1 pc Karpet busa tebal (2x3 meter)\n- 1 pc Corkboard / Papan Mading\n- 2 pcs Meja bundar lesehan",
            'is_active' => true,
        ]);
    }
}
