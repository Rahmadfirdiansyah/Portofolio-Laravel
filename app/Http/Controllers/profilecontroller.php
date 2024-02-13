<?php

namespace App\Http\Controllers;

use App\Models\metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class profilecontroller extends Controller
{
    function index()
    {
        return view('dashboard.profile.index');
    }
    function update(Request $request)
    {
        $request->validate([
            '_foto' => 'mimes:jpeg,jpg,png,gif',
            '_email' => 'required|email'
        ],[

            '_foto.mimes' => 'foto yang dimasukkan hanya diperbolehkan berekstensi jpeg, jpg, png,
            dan gif',
            '_email.required' => 'email wajib diiisi',
            '_email.email' => 'format email dimasukkan tidak valid' 
        ]);

        if($request->hasFile('_foto')){
            $foto_file = $request->file('_foto');
            $foto_ekstensi = $foto_file->extension();
            $foto_baru = date('ymdhis') . ".$foto_ekstensi";
            $foto_file->move(public_path('foto'), $foto_baru);
            //kalau ada foto baru

            $foto_lama = get_meta_value('_foto');
            File::delete(public_path('_foto') . "/".$foto_lama);

            metadata::updateOrCreate(['meta_key' => '_foto'], ['meta_value' => $foto_baru]);
        }

            metadata::updateOrCreate(['meta_key' => '_email'], ['meta_value' => $request->_email]);
            metadata::updateOrCreate(['meta_key' => '_kota'], ['meta_value' => $request->_kota]);
            metadata::updateOrCreate(['meta_key' => '_provinsi'], ['meta_value' => $request->_provinsi]);
            metadata::updateOrCreate(['meta_key' => '_nohp'], ['meta_value' => $request->_nohp]);

            metadata::updateOrCreate(['meta_key' => '_facebook'], ['meta_value' => $request->_facebook]);
            metadata::updateOrCreate(['meta_key' => '_twitter'], ['meta_value' => $request->_twitter]);
            metadata::updateOrCreate(['meta_key' => '_linkedin'], ['meta_value' => $request->_linkedin]);
            metadata::updateOrCreate(['meta_key' => '_github'], ['meta_value' => $request->_github]);

            return redirect()->route('profile.index')->with('success', 'berhasil update data profile');
    }
}
