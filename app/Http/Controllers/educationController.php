<?php

namespace App\Http\Controllers;

use App\Models\riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class educationController extends Controller
{
    function __construct() // Konstruktor untuk mengatur tipe riwayat
    {
        $this->_tipe = 'education';
    }
    private $_tipe;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil data riwayat pendidikan berdasarkan tipe "education"
        $data = riwayat::where('tipe', $this->_tipe)->orderBy('tgl_akhir', 'desc')->get();
        return view('dashboard.education.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.education.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('judul', $request->judul);
        Session::flash('info1', $request->info1);
        Session::flash('info2', $request->info2);
        Session::flash('info3', $request->info3);
        Session::flash('tgl_mulai', $request->tgl_mulai);
        Session::flash('tgl_akhir', $request->tgl_akhir);
        // Validasi input data
        $request->validate(
            [
                'judul' => 'required',
                'info1' => 'required',
                'tgl_mulai' => 'required',
            ],
            [
                'judul.required' => 'judul wajib diisi',
                'info1.required' => 'Nama perusahaan wajib diisi',
                'tgl_mulai.required' => 'Tanggal mulai wajib diisi',
            ]
        );
        // Menyiapkan data untuk disimpan
        $data = [
            'judul' => $request->judul,
            'info1' => $request->info1,
            'info2' => $request->info2,
            'info3' => $request->info3,
            'tipe' => $this->_tipe,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
        ];
        riwayat::create($data); // Menyimpan data ke dalam database

        // Redirect ke index education dengan pesan sukses
        return redirect()->route('education.index')->with('success', 'berhasil menambahakan data education');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Mengambil data pendidikan berdasarkan ID dan tipe "education"
        $data = riwayat::where('id', $id)->where('tipe', $this->_tipe)->first();
        return view('dashboard.education.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input data
        $request->validate(
            [
                'judul' => 'required',
                'info1' => 'required',
                'tgl_mulai' => 'required',
            ],
            [
                'judul.required' => 'judul wajib diisi',
                'info1.required' => 'Nama perusahaan wajib diisi',
                'tgl_mulai.required' => 'Tanggal mulai wajib diisi',
            ]
        );
        // Menyiapkan data untuk diperbarui
        $data = [
            'judul' => $request->judul,
            'info1' => $request->info1,
            'info2' => $request->info2,
            'info3' => $request->info3,
            'tipe' => $this->_tipe,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
        ];
         // Memperbarui data ke dalam database berdasarkan ID dan tipe "education"
        riwayat::where('id', $id)->where('tipe', $this->_tipe)->update($data);

        // Redirect ke index education dengan pesan sukses
        return redirect()->route('education.index')->with('success', 'berhasil mengupdate data education');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Menghapus data dari database berdasarkan ID dan tipe "education"
        riwayat::where('id', $id)->where('tipe', $this->_tipe)->delete();

        // Redirect ke index education dengan pesan sukses
        return redirect()->route('education.index')->with('success', 'berhasil menghapus data education');
    }
}
