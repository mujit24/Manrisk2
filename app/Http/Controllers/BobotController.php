<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function index()
    {
        $title   = 'Input Bobot';
        $bobot = Bobot::all();
        $groupedData = $bobot->groupBy('tahun');
        $bobotKategoriMap = Bobot::all()
            ->pluck('bobot_kategori', 'bobot_nilai')
            ->toArray();

        return view('pages.input-bobot', [
            'title' => $title,
            'listbobot' => $bobot,
            'groupedData' => $groupedData,
            'bobotKategoriMap' => $bobotKategoriMap,

        ]);
    }

    //simpan ke database
    public function store(Request $request)
    {

        // Membuat objek bobot baru
        $bobot = new Bobot();
        $bobot->tahun = $request->tahun;
        $bobot->bobot_nilai = $request->bobot_nilai;
        $bobot->bobot_kategori = $request->bobot_kategori;
        $bobot->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit($id)
    {
        // Temukan bobot berdasarkan ID
        $bobot = Bobot::findOrFail($id);

        // Kirim bobot ke view untuk ditampilkan dalam form edit
        return view('bobot.edit', compact('bobot'));
    }

    //update save ke database
    public function update(Request $request, $id)
    {

        // Temukan bobot berdasarkan ID
        $bobot = Bobot::findOrFail($id);

        // Update data bobot    
        $bobot->tahun = $request->tahun;
        $bobot->bobot_nilai = $request->bobot_nilai;
        $bobot->bobot_kategori = $request->bobot_kategori;
        $bobot->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('input-bobot')->with('success');
    }

    public function destroy($id)
    {

        $bobot = Bobot::findOrFail($id);
        $bobot->delete();

        return redirect()->route('input-bobot')->with('success');
    }
}
