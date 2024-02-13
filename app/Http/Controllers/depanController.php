<?php

namespace App\Http\Controllers;

use App\Models\halaman;
use App\Models\riwayat;
use Illuminate\Http\Request;

class depanController extends Controller
{
    public function index()
    {
        // Fungsi untuk menampilkan halaman utama
        $about_id = get_meta_value('_halaman_about'); // Mendapatkan ID halaman "About" dari metadata
        $about_data = halaman::where('id', $about_id)->first();  // Mengambil data halaman "About" berdasarkan ID

        $interest_id = get_meta_value('_halaman_interest');
        $interest_data = halaman::where('id', $interest_id)->first();

        $award_id = get_meta_value('_halaman_award');
        $award_data = halaman::where('id', $award_id)->first();

        $experience_data = riwayat::where('tipe', 'experience')->get(); // Mengambil data pengalaman kerja (riwayat) berdasarkan tipe "experience"
        $education_data = riwayat::where('tipe', 'education')->get(); // Mengambil data pendidikan (riwayat) berdasarkan tipe "education"

        // Menampilkan view 'depan.index' dengan data yang diambil
        return view('depan.index')->with([
            'about' => $about_data,
            'interest' => $interest_data,
            'award' => $award_data,
            'experience' => $experience_data,
            'education' => $education_data
        ]);
    }
}
