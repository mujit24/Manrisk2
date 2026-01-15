<?php

namespace App\Http\Controllers;

use App\Models\Dampak;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DampakController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Input Dampak';
        $dampak = Dampak::with('namaKategori')->get();
        $groupedData = $dampak->groupBy('tahun')->map(function ($items) {
            // Di dalam tahun, grouping kedua: Berdasarkan Kategori
            return $items->groupBy(function ($item) {
                return $item->namaKategori->kategori_nama ?? 'Tanpa Kategori';
            });
        });
        $tahun = $request->input('tahun', date('Y'));
        $listkategori = Kategori::where('tahun', $tahun)->get();

        return view('pages.input-dampak', [
            'title' => $title,
            'listdampak' => $dampak,
            'groupedData' => $groupedData,
            'listkategori' => $listkategori,
        ]);
    }

    //simpan ke database
    public function store(Request $request)
    {

        // Membuat objek dampak baru
        $dampak = new Dampak();
        $dampak->tahun = $request->tahun;
        $dampak->dampak_level = $request->dampak_level;
        $dampak->dampak_nama = $request->dampak_nama;
        $dampak->kategori_id = $request->kategori_id;
        $dampak->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit($id)
    {

        $dampak = Dampak::findOrFail($id);
        return view('dampak.edit', compact('dampak'));
    }

    //update save ke database
    public function update(Request $request, $id)
    {

        $dampak = Dampak::findOrFail($id);
        $dampak->tahun = $request->tahun;
        $dampak->dampak_level = $request->dampak_level;
        $dampak->dampak_nama = $request->dampak_nama;
        $dampak->kategori_id = $request->kategori_id;
        $dampak->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('input-dampak')->with('success');
    }

    public function destroy($id)
    {

        $dampak = Dampak::findOrFail($id);
        $dampak->delete();

        return redirect()->route('input-dampak')->with('success');
    }
}
