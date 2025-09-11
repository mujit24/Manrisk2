<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $title = 'Input Kategori';
        $kategori = Kategori::all();
        $groupedData = $kategori->groupBy('tahun');

        return view('pages.input-kategori', [
            'title' => $title,
            'listkategori' => $kategori,
            'groupedData' => $groupedData,

        ]);
    }

    //simpan ke database
    public function store(Request $request)
    {

        // Membuat objek jenis baru
        $kategori = new Kategori();
        $kategori->tahun = $request->tahun;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit($id)
    {
        // Temukan jenis berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Kirim jenis ke view untuk ditampilkan dalam form edit
        return view('kategori.edit', compact('kategori'));
    }

    //update save ke database
    public function update(Request $request, $id)
    {

        // Temukan jenis berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Update data jenis
        $kategori->tahun = $request->tahun;
        $kategori->kategori_nama = $request->kategori_nama;

        $kategori->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('input-kategori')->with('success');
    }

    public function destroy($id)
    {

        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('input-kategori')->with('success');
    }
}
