<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $title = 'Input Divisi';
        $divisi = Divisi::all();

        return view('pages.input-divisi', [
            'title' => $title,
            'listdivisi' => $divisi,

        ]);
    }

    //simpan ke database
    public function store(Request $request)
    {

        // Membuat objek jenis baru
        $divisi = new Divisi();
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit($id)
    {
        // Temukan jenis berdasarkan ID
        $divisi = Divisi::findOrFail($id);

        // Kirim jenis ke view untuk ditampilkan dalam form edit
        return view('divisi.edit', compact('divisi'));
    }

    //update save ke database
    public function update(Request $request, $id)
    {

        // Temukan jenis berdasarkan ID
        $divisi = Divisi::findOrFail($id);

        // Update data jenis
        $divisi->nama_divisi = $request->nama_divisi;

        $divisi->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('input-divisi')->with('success');
    }

    public function destroy($id)
    {

        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()->route('input-divisi')->with('success');
    }
}
