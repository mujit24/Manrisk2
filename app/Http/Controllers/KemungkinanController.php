<?php

namespace App\Http\Controllers;

use App\Models\Kemungkinan;
use Illuminate\Http\Request;

class KemungkinanController extends Controller
{
    public function index()
    {
        $title = 'Input Kemungkinan';
        $kemungkinan = Kemungkinan::all();
        $groupedData = $kemungkinan->groupBy('tahun');

        return view('pages.input-kemungkinan', [
            'title' => $title,
            'listkemungkinan' => $kemungkinan,
            'groupedData' => $groupedData,

        ]);
    }

    //simpan ke database
    public function store(Request $request)
    {

        // Membuat objek kemungkinan baru
        $kemungkinan = new Kemungkinan();
        $kemungkinan->tahun = $request->tahun;
        $kemungkinan->kmn_level = $request->kmn_level;
        $kemungkinan->kmn_nama = $request->kmn_nama;
        $kemungkinan->kmn_keterangan = $request->kmn_keterangan;
        $kemungkinan->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit($id)
    {

        $kemungkinan = Kemungkinan::findOrFail($id);
        return view('kemungkinan.edit', compact('kemungkinan'));
    }

    //update save ke database
    public function update(Request $request, $id)
    {

        $kemungkinan = Kemungkinan::findOrFail($id);
        $kemungkinan->tahun = $request->tahun;
        $kemungkinan->kmn_level = $request->kmn_level;
        $kemungkinan->kmn_nama = $request->kmn_nama;
        $kemungkinan->kmn_keterangan = $request->kmn_keterangan;
        $kemungkinan->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('input-kemungkinan')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {

        $kemungkinan = Kemungkinan::findOrFail($id);
        $kemungkinan->delete();

        return redirect()->route('input-kemungkinan')->with('success', 'Data berhasil dihapus');
    }
}
