<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Dampak;
use App\Models\Bobot;
use App\Models\Divisi;
use App\Models\Identifikasi;
use App\Models\Sasaran;
use App\Models\Tujuan;
use App\Models\Event;
use App\Models\Resiko;
use App\Models\Kemungkinan;
use App\Models\Pengukuran;
use App\Models\Pengendalian;
use App\Models\Monitoring;

use App\Models\Approval;
use App\Models\Approval_Divisi;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResikoController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Input Resiko';

        if (Auth::check()) {
            $title = 'Input Resiko';

            $organization_id = DB::connection('mysql_erp')
                ->table('employment')
                ->where('user_id', Auth::user()->user_id)
                ->value('organization_id');

            $organization_name = DB::connection('mysql_erp')
                ->table('employment')
                ->where('organization_id', $organization_id)
                ->value('organization_name');

            $kepalaDivisiUserId = DB::connection('mysql_erp')
                ->table('employment')
                ->where('organization_id', $organization_id)
                ->where('job_level', 'Kepala Divisi')
                ->value('user_id');

            $kepalaDivisiName = null;
            if ($kepalaDivisiUserId) {
                $employee = DB::connection('mysql_erp')
                    ->table('employee')
                    ->where('user_id', $kepalaDivisiUserId)
                    ->select('first_name', 'last_name')
                    ->first();

                if ($employee) {
                    $kepalaDivisiName = trim($employee->first_name . ' ' . $employee->last_name);
                }
            }
        } else {
            // Redirect ke halaman login atau tampilkan pesan error
            return redirect()->route('login');
        }

        $tahun_identifikasi = $request->input('tahun', date('Y'));
        // 1. Identifikasi
        // 1.1 Sasaran
        $sasaran = Sasaran::where('divisi_id',  $organization_id)->where('tahun', $tahun_identifikasi)->get();
        $listsasaranedit = Sasaran::where('divisi_id',  $organization_id)->where('tahun', $tahun_identifikasi)->get();
        $groupedDataSasaran = $sasaran->groupBy('tahun');

        // 1.2 Tujuan
        $tujuan = Tujuan::with('namaSasaran')
            ->whereHas('namaSasaran', function ($query) use ($organization_id, $tahun_identifikasi) {
                $query->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun_identifikasi);
            })
            ->get();

        $listtujuanedit = Tujuan::whereHas('namaSasaran', function ($query) use ($organization_id) {
            $query->where('divisi_id', $organization_id);
        })->get();

        $groupedDataTujuan = $tujuan->groupBy('tahun')->map(function ($items) {
            // Di dalam tahun, grouping kedua: Berdasarkan Kategori
            return $items->groupBy(function ($item) {
                return $item->namaSasaran->sasaran_nama ?? 'Tanpa Sasaran';
            });
        });

        // 1.3 Event
        $event = Event::with('namaTujuan.namaSasaran')
            ->whereHas('namaTujuan.namaSasaran', function ($query) use ($organization_id, $tahun_identifikasi) {
                $query->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun_identifikasi);
            })
            ->get();

        $tahun_events = [];
        foreach ($event as $item) {
            $tahun_event = optional($item->namaTujuan->namaSasaran)->tahun;

            if ($tahun_event !== null) {
                $tahun_events[] = $tahun_event;
            }
        }
        $listeventedit = Event::whereHas('namaTujuan.namaSasaran', function ($query) use ($organization_id, $tahun_events) {
            $query->where('divisi_id', $organization_id)
                ->where('tahun', $tahun_events);
        })
            ->get();

        $groupedDataEvent = $event->groupBy('tahun')->map(function ($items) {
            return $items->groupBy(function ($item) {
                return $item->namaSasaran->sasaran_nama ?? 'Tanpa Sasaran';
            })->map(function ($itemsBySasaran) {
                return $itemsBySasaran->groupBy(function ($item) {
                    return $item->namaTujuan->tujuan_nama ?? 'Tanpa Tujuan';
                });
            });
        });

        // 1.4 Resiko
        $resiko = Resiko::with('namaSasaran', 'namaTujuan', 'namaEvent', 'namaKategori')->where('divisi_id',  $organization_id)->where('tahun', $tahun_identifikasi)->get();
        $groupedDataResiko = $resiko
            ->groupBy('tahun')                                   // Level 1: Tahun
            ->map(function ($risksPerYear) {

                return $risksPerYear->groupBy(function ($r) {    // Level 2: Sasaran
                    return optional(
                        optional(
                            optional($r->namaEvent)->namaTujuan
                        )->namaSasaran
                    )->sasaran_nama ?? 'Tanpa Sasaran';
                })->map(function ($risksPerSasaran) {

                    return $risksPerSasaran->groupBy(function ($r) {  // Level 3: Tujuan
                        return optional(
                            optional($r->namaEvent)->namaTujuan
                        )->tujuan_nama ?? 'Tanpa Tujuan';
                    })->map(function ($risksPerTujuan) {

                        return $risksPerTujuan->groupBy(function ($r) { // Level 4: Event
                            return optional($r->namaEvent)->event_nama ?? 'Tanpa Event';
                        });
                    });
                });
            });


        // 2. Pengukuran
        $tahun_pengukuran = $request->input('tahun', date('Y'));

        $pengukuran = Pengukuran::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotInhern')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun_pengukuran) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun_pengukuran);
            })
            ->get()
            ->keyBy('resiko_id');

        $groupedDataPengukuran = $pengukuran->groupBy('tahun');

        $resiko_pengukuran = Resiko::with('namaKategori')
            ->where('divisi_id', $organization_id)
            ->where('tahun', $tahun_pengukuran)
            ->orderBy('id')
            ->get();
        $groupedDataResiko_pengukuran = $resiko_pengukuran->groupBy('tahun');


        // 3. Pengendalian
        $tahun_pengendalian = $request->input('tahun', date('Y'));

        $pengendalian = Pengendalian::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotExp')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun_pengendalian) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun_pengendalian);
            })
            ->get()
            ->keyBy('resiko_id');

        $groupedDataPengendalian = $pengendalian->groupBy('tahun');

        $resiko_pengendalian = Resiko::with('namaKategori')
            ->where('divisi_id', $organization_id)
            ->where('tahun', $tahun_pengukuran)
            ->orderBy('id')
            ->get();
        $groupedDataResiko_pengendalian = $resiko_pengendalian->groupBy('tahun');

        $kategoriIds = $pengendalian
            ->pluck('namaResiko.kategori_id')
            ->unique()
            ->filter()
            ->all();

        $listdampak_exp = Dampak::whereIn('kategori_id', $kategoriIds)->get();


        // 4/ Monitoring
        $monitoring = Monitoring::with('namaResiko', 'namaPengendalian', 'namaPengukuran')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun_pengendalian) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun_pengendalian);
            })
            ->get()
            ->keyBy('resiko_id');

        $groupedDataMonitoring = $monitoring->groupBy('tahun');

        $resiko_monitoring = Resiko::with('namaKategori')
            ->where('divisi_id', $organization_id)
            ->where('tahun', $tahun_pengukuran)
            ->orderBy('id')
            ->get();

        $groupedDataResiko_monitoring = $resiko_monitoring->groupBy('tahun');

        // 5. Dashboard Divisi
        $tahun_dash = $request->input('tahun', date('Y'));
        $resiko_dash = Resiko::where('tahun', $tahun_dash)
            ->where('divisi_id', $organization_id)
            ->get();

        $jumlahResiko = $resiko_dash->count();
        $resikoIds = $resiko_dash->pluck('id');

        $totalInhern = Pengukuran::whereIn('resiko_id', $resikoIds)
            ->sum('inhern_nilai');

        $totalExp = Pengendalian::whereIn('resiko_id', $resikoIds)
            ->sum('exp_nilai');

        // Hitung rata-rata
        $avg_inhern = $jumlahResiko > 0 ? round($totalInhern / $jumlahResiko, 2) : 0;
        $avg_exp = $jumlahResiko > 0 ? round($totalExp / $jumlahResiko, 2) : 0;

        $dataMonitoring = Monitoring::with(['namaResiko'])
            ->whereHas('namaResiko', function ($query) use ($tahun_dash, $organization_id) {
                $query->where('tahun', $tahun_dash);
                if ($organization_id) {
                    $query->where('divisi_id', $organization_id);
                }
            })
            ->get();

        $jumlahSelesai = $dataMonitoring->where('status_mitigasi', 'Selesai Dilaksanakan')->count();
        $persentaseSelesai = $jumlahResiko > 0 ? round(($jumlahSelesai / $jumlahResiko) * 100, 2) : 0;

        $getKategoriRisk_inhern = Bobot::where('tahun', $tahun_dash)
            ->where('bobot_nilai', '<=', $avg_inhern)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $getKategoriRisk_exp = Bobot::where('tahun', $tahun_dash)
            ->where('bobot_nilai', '<=', $avg_exp)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $get_monitoring = Monitoring::with('namaResiko', 'namaPengendalian', 'namaPengukuran')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');

        $get_pengendalian = Pengendalian::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotExp')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');


        $get_pengukuran = Pengukuran::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotInhern')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');

        $get_resiko = Resiko::with([
            'namaKategori',
            'namaDivisi',
            'namaPengukuran.namaDampak',
            'namaPengukuran.namaKemungkinan',
            'namaPengukuran.namaBobotInhern',
            'namaPengendalian.namaDampak',
            'namaPengendalian.namaKemungkinan',
            'namaPengendalian.namaBobotExp',
            'namaMonitoring'
        ])
            ->where('tahun', $tahun_dash)
            ->orderByDesc('id') // Anda bisa ganti dengan orderByDesc('namaPengukuran.inhern_nilai')
            ->get();

        $groupedResiko = $get_resiko->groupBy('event_id');

        $approval = Approval_Divisi::with(['namaDivisi', 'namaPekerja'])
            ->where('divisi_id', $organization_id)
            ->get();

        $approval_detail = Approval::whereIn('app_divisi_id', $approval->pluck('id'))->get();


        $listdivisi = Divisi::all();
        $listkategori = Kategori::all();
        $listdampak = Dampak::all();
        $listkemungkinan = Kemungkinan::all();
        $listbobot = Bobot::all();



        return view('pages.input-risk', [
            'title' => $title,
            'tahun_pengukuran' => $tahun_pengukuran,
            'tahun_pengendalian' => $tahun_pengendalian,

            'listsasaran' => $sasaran,
            'groupedDataSasaran' => $groupedDataSasaran,
            'listsasaranedit' => $listsasaranedit,

            'listtujuan' => $tujuan,
            'groupedDataTujuan' => $groupedDataTujuan,
            'listtujuanedit' => $listtujuanedit,

            'listevent' => $event,
            'groupedDataEvent' => $groupedDataEvent,
            'listeventedit' => $listeventedit,

            'listresiko' => $resiko,
            'groupedDataResiko' => $groupedDataResiko,

            'listpengukuran' => $pengukuran,
            'groupedDataPengukuran' => $groupedDataPengukuran,
            'groupedDataResiko_pengukuran' => $groupedDataResiko_pengukuran,

            'listpengendalian' => $pengendalian,
            'groupedDataPengendalian' => $groupedDataPengendalian,
            'groupedDataResiko_pengendalian' => $groupedDataResiko_pengendalian,
            'listdampak_exp' => $listdampak_exp,

            'listmonitoring' => $monitoring,
            'groupedDataMonitoring' => $groupedDataMonitoring,
            'groupedDataResiko_monitoring' => $groupedDataResiko_monitoring,

            'listdivisi' => $listdivisi,
            'listkategori' => $listkategori,
            'listdampak' => $listdampak,
            'listkemungkinan' => $listkemungkinan,
            'listbobot' => $listbobot,

            'jumlahResiko' => $jumlahResiko,
            'avg_inhern' => $avg_inhern,
            'avg_exp' => $avg_exp,
            'persentaseSelesai' => $persentaseSelesai,
            'getKategoriRisk_inhern' => $getKategoriRisk_inhern,
            'getKategoriRisk_exp' => $getKategoriRisk_exp,

            'organization_id' => $organization_id,
            'organization_name' => $organization_name,
            'kepalaDivisiUserId' => $kepalaDivisiUserId,
            'kepalaDivisiName' => $kepalaDivisiName,

            'get_pengukuran' =>   $get_pengukuran,
            'get_pengendalian' =>   $get_pengendalian,
            'get_monitoring' =>   $get_monitoring,

            'get_resiko' => $get_resiko,
            'groupedResiko' => $groupedResiko,

            'listapproval' => $approval,
            'list_approval_detail' => $approval_detail,



        ]);
    }

    // Filter Sasaran di Tahun
    public function getSasaranByTahun(Request $request)
    {
        $tahun = $request->tahun;
        $divisiId = $request->divisi_id;

        $sasaran = Sasaran::where('tahun', $tahun)
            ->where('divisi_id', $divisiId)
            ->pluck('sasaran_nama', 'id');

        return response()->json($sasaran);
    }

    // Filter Tujuan di Event
    public function getTujuanByTahun(Request $request)
    {
        $tahun    = $request->tahun;
        $divisiId = $request->divisi_id;

        $tujuan = Tujuan::whereHas('namaSasaran', function ($q) use ($tahun, $divisiId) {
            $q->where('tahun', $tahun)
                ->where('divisi_id', $divisiId);
        })
            ->pluck('tujuan_nama', 'id');

        return response()->json($tujuan);
    }

    public function getEventByTahun(Request $request)
    {
        $tahun = $request->tahun;
        $divisiId = $request->divisi_id;

        $event = Event::whereHas('namaTujuan.namaSasaran', function ($q) use ($tahun, $divisiId) {
            $q->where('tahun', $tahun)
                ->where('divisi_id', $divisiId);
        })
            ->pluck('event_nama', 'id');

        return response()->json($event);
    }


    // 1. -> Identifikasi 
    // 1.1 -> Iden Sasaran
    public function store_sasaran(Request $request)
    {

        // Membuat objek baru
        $sasaran = new Sasaran();
        $sasaran->tahun = $request->tahun;
        $sasaran->divisi_id = $request->divisi_id;
        $sasaran->sasaran_nama = $request->sasaran_nama;
        $sasaran->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_sasaran($id)
    {

        $sasaran = Sasaran::findOrFail($id);
        return view('sasaran.edit', compact('sasaran'));
    }

    //update save ke database
    public function update_sasaran(Request $request, $id)
    {

        $sasaran = Sasaran::findOrFail($id);
        $sasaran->tahun = $request->tahun;
        $sasaran->divisi_id = $request->divisi_id;
        $sasaran->sasaran_nama = $request->sasaran_nama;
        $sasaran->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy_sasaran($id)
    {

        $tujuan = Sasaran::findOrFail($id);
        $tujuan->delete();

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    // 1.2 -> Iden Tujuan
    public function store_tujuan(Request $request)
    {

        // Membuat objek baru
        $tujuan = new Tujuan();
        $tujuan->tahun = $request->tahun;
        $tujuan->sasaran_id = $request->sasaran_id;
        $tujuan->tujuan_nama = $request->tujuan_nama;
        $tujuan->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_tujuan($id)
    {

        $tujuan = Tujuan::findOrFail($id);
        return view('tujuan.edit', compact('tujuan'));
    }

    //update save ke database
    public function update_tujuan(Request $request, $id)
    {

        $tujuan = Tujuan::findOrFail($id);
        $tujuan->tahun = $request->tahun;
        $tujuan->sasaran_id = $request->sasaran_id;
        $tujuan->tujuan_nama = $request->tujuan_nama;
        $tujuan->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy_tujuan($id)
    {

        $tujuan = Tujuan::findOrFail($id);
        $tujuan->delete();

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    // 1.3 -> Iden Event
    public function store_event(Request $request)
    {

        // Membuat objek baru
        $event = new Event();
        $event->tahun = $request->tahun;
        $event->tujuan_id = $request->tujuan_id;
        $event->event_nama = $request->event_nama;
        $event->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_event($id)
    {

        $event = Event::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    //update save ke database
    public function update_event(Request $request, $id)
    {

        $event = Event::findOrFail($id);
        $event->tahun = $request->tahun;
        $event->tujuan_id = $request->tujuan_id;
        $event->event_nama = $request->event_nama;
        $event->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy_event($id)
    {

        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    // 1.4 -> Iden Resiko
    public function store_resiko(Request $request)
    {

        // Membuat objek baru
        $resiko = new Resiko();
        $resiko->tahun = $request->tahun;
        $resiko->event_id = $request->event_id;
        $resiko->divisi_id = $request->divisi_id;
        $resiko->kategori_id = $request->kategori_id;
        $resiko->resiko_nama = $request->resiko_nama;
        $resiko->resiko_penyebab = $request->resiko_penyebab;
        $resiko->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_resiko($id)
    {

        $resiko = Resiko::findOrFail($id);
        return view('resiko.edit', compact('resiko'));
    }

    //update save ke database
    public function update_resiko(Request $request, $id)
    {

        $resiko = Resiko::findOrFail($id);
        $resiko->tahun = $request->tahun;
        $resiko->event_id = $request->event_id;
        $resiko->divisi_id = $request->divisi_id;
        $resiko->kategori_id = $request->kategori_id;
        $resiko->resiko_nama = $request->resiko_nama;
        $resiko->resiko_penyebab = $request->resiko_penyebab;
        $resiko->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy_resiko($id)
    {

        $resiko = Resiko::findOrFail($id);
        $resiko->delete();

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    // 2. -> Pengukuran
    public function store_pengukuran(Request $request)
    {

        // Membuat objek baru
        $pengukuran = new Pengukuran();
        $pengukuran->resiko_id = $request->resiko_id;
        $pengukuran->dampak = $request->dampak;
        $pengukuran->strategi = $request->strategi;
        $pengukuran->prosedur = $request->prosedur;
        $pengukuran->inhern_kemungkinan_id = $request->inhern_kemungkinan_id;
        $pengukuran->inhern_dampak_id = $request->inhern_dampak_id;
        $pengukuran->inhern_nilai = $request->inhern_nilai;
        $pengukuran->inhern_bobot_id = $request->inhern_bobot_id;
        $pengukuran->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_pengukuran($id)
    {

        $pengukuran = Pengukuran::findOrFail($id);
        return view('pengukuran.edit', compact('pengukuran'));
    }

    //update save ke database
    public function update_pengukuran(Request $request, $id)
    {

        $pengukuran = Pengukuran::findOrFail($id);
        $pengukuran->resiko_id = $request->resiko_id;
        $pengukuran->dampak = $request->dampak;
        $pengukuran->strategi = $request->strategi;
        $pengukuran->prosedur = $request->prosedur;
        $pengukuran->inhern_kemungkinan_id = $request->inhern_kemungkinan_id;
        $pengukuran->inhern_dampak_id = $request->inhern_dampak_id;
        $pengukuran->inhern_nilai = $request->inhern_nilai;
        $pengukuran->inhern_bobot_id = $request->inhern_bobot_id;
        $pengukuran->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function destroy_pengukuran($id)
    {

        $pengukuran = Pengukuran::findOrFail($id);
        $pengukuran->delete();

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    // 3. -> Pengendalian
    public function store_pengendalian(Request $request)
    {

        // Membuat objek baru
        $pengendalian = new Pengendalian();
        $pengendalian->resiko_id = $request->resiko_id;
        $pengendalian->kategori_id = $request->kategori_id;
        $pengendalian->pengukuran_id = $request->pengukuran_id;
        $pengendalian->rencana = $request->rencana;
        $pengendalian->exp_kemungkinan_id = $request->exp_kemungkinan_id;
        $pengendalian->exp_dampak_id = $request->exp_dampak_id;
        $pengendalian->exp_nilai = $request->exp_nilai;
        $pengendalian->exp_bobot_id = $request->exp_bobot_id;
        $pengendalian->pic = $request->pic;
        $pengendalian->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_pengendalian($id)
    {

        $pengendalian = Pengendalian::findOrFail($id);
        return view('pengendalian.edit', compact('pengendalian'));
    }

    //update save ke database
    public function update_pengendalian(Request $request, $id)
    {

        $pengendalian = Pengendalian::findOrFail($id);
        $pengendalian->resiko_id = $request->resiko_id;
        $pengendalian->kategori_id = $request->kategori_id;
        $pengendalian->pengukuran_id = $request->pengukuran_id;
        $pengendalian->rencana = $request->rencana;
        $pengendalian->exp_kemungkinan_id = $request->exp_kemungkinan_id;
        $pengendalian->exp_dampak_id = $request->exp_dampak_id;
        $pengendalian->exp_nilai = $request->exp_nilai;
        $pengendalian->exp_bobot_id = $request->exp_bobot_id;
        $pengendalian->pic = $request->pic;
        $pengendalian->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success');
    }

    public function destroy_pengendalian($id)
    {

        $pengendalian = Pengendalian::findOrFail($id);
        $pengendalian->delete();

        return redirect()->back()->with('success');
    }

    // 4. -> Monitoring
    public function store_monitoring(Request $request)
    {

        // Membuat objek baru
        $monitoring = new Monitoring();
        $monitoring->resiko_id = $request->resiko_id;
        $monitoring->pengukuran_id = $request->pengukuran_id;
        $monitoring->pengendalian_id = $request->pengendalian_id;
        $monitoring->jangka_waktu = $request->jangka_waktu;
        $monitoring->peluang_perbaikan = $request->peluang_perbaikan;
        $monitoring->status_mitigasi = $request->status_mitigasi;
        $monitoring->keterangan = $request->keterangan;
        $monitoring->evidence = $request->evidence;
        $monitoring->save();

        return redirect()->back()->with('success');
    }

    //edit file dari database
    public function edit_monitoring($id)
    {

        $monitoring = Monitoring::findOrFail($id);
        return view('monitoring.edit', compact('monitoring'));
    }

    //update save ke database
    public function update_monitoring(Request $request, $id)
    {

        $monitoring = Monitoring::findOrFail($id);
        $monitoring->resiko_id = $request->resiko_id;
        $monitoring->pengukuran_id = $request->pengukuran_id;
        $monitoring->pengendalian_id = $request->pengendalian_id;
        $monitoring->jangka_waktu = $request->jangka_waktu;
        $monitoring->peluang_perbaikan = $request->peluang_perbaikan;
        $monitoring->status_mitigasi = $request->status_mitigasi;
        $monitoring->keterangan = $request->keterangan;
        $monitoring->evidence = $request->evidence;
        $monitoring->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success');
    }

    public function destroy_monitoring($id)
    {

        $monitoring = Monitoring::findOrFail($id);
        $monitoring->delete();

        return redirect()->back()->with('success');
    }

    //Dashboard Man Risk All
    public function index_dash(Request $request)
    {
        $tahun_dash = $request->input('tahun', date('Y'));
        $title = 'Dashboard Man Risk';


        $resiko_monitoring = Resiko::with('namaKategori', 'namaDivisi')
            ->join('pengukuran', 'indf_resiko.id', '=', 'pengukuran.resiko_id')
            ->where('indf_resiko.tahun', $tahun_dash)
            ->orderByDesc('pengukuran.inhern_nilai')
            ->select('indf_resiko.*') // Pastikan hanya kolom dari tabel resiko yang dipilih
            ->get();

        $groupedDataResiko_monitoring = $resiko_monitoring->groupBy(function ($item) {
            $divisi = $item->namaDivisi->organization_name ?? 'Lainnya';
            return $item->tahun . '|' . $divisi;
        });

        $resiko_dash = Resiko::where('tahun', $tahun_dash)->get();

        $jumlahResiko = $resiko_dash->count();

        $resikoIds = $resiko_dash->pluck('id');

        $totalInhern = Pengukuran::whereIn('resiko_id', $resikoIds)->sum('inhern_nilai');

        $totalExp = Pengendalian::whereIn('resiko_id', $resikoIds)->sum('exp_nilai');

        // Hitung rata-rata
        $avg_inhern = $jumlahResiko > 0 ? round($totalInhern / $jumlahResiko, 2) : 0;
        $avg_exp = $jumlahResiko > 0 ? round($totalExp / $jumlahResiko, 2) : 0;

        $dataMonitoring = Monitoring::with(['namaResiko'])
            ->whereHas('namaResiko', function ($query) use ($tahun_dash) {
                $query->where('tahun', $tahun_dash);
            })->get();

        $jumlahSelesai = $dataMonitoring->where('status_mitigasi', 'Selesai Dilaksanakan')->count();
        $persentaseSelesai = $jumlahResiko > 0 ? round(($jumlahSelesai / $jumlahResiko) * 100, 2) : 0;

        $getKategoriRisk_inhern = Bobot::where('tahun', $tahun_dash)
            ->where('bobot_nilai', '<=', $avg_inhern)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $getKategoriRisk_exp = Bobot::where('tahun', $tahun_dash)
            ->where('bobot_nilai', '<=', $avg_exp)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $monitoring = Monitoring::with('namaResiko', 'namaPengendalian', 'namaPengukuran')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');

        $pengendalian = Pengendalian::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotExp')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');

        $pengukuran = Pengukuran::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotInhern')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->orderByDesc('inhern_nilai')
            ->get()
            ->keyBy('resiko_id');

        // Gabungkan per divisi
        $dataDivisi = [];

        foreach ($pengukuran as $p) {
            $divisiId = $p->namaResiko->divisi_id ?? null;
            if ($divisiId) {
                $divisiNama = $p->namaResiko->namaDivisi->organization_name ?? 'Unknown';

                if (!isset($dataDivisi[$divisiId])) {
                    $dataDivisi[$divisiId] = [
                        'divisi' => $divisiNama,
                        'inhern_total' => 0,
                        'inhern_count' => 0,
                        'exp_total' => 0,
                        'exp_count' => 0,
                    ];
                }

                $dataDivisi[$divisiId]['inhern_total'] += $p->inhern_nilai ?? 0;
                $dataDivisi[$divisiId]['inhern_count']++;
            }
        }

        foreach ($pengendalian as $p) {
            $divisiId = $p->namaResiko->divisi_id ?? null;
            if ($divisiId && isset($dataDivisi[$divisiId])) {
                $dataDivisi[$divisiId]['exp_total'] += $p->exp_nilai ?? 0;
                $dataDivisi[$divisiId]['exp_count']++;
            }
        }

        // Hitung rata-rata
        $labels = [];
        $inhern = [];
        $exp = [];

        foreach ($dataDivisi as $d) {
            $labels[] = $d['divisi'];
            $inhern[] = $d['inhern_count'] > 0 ? round($d['inhern_total'] / $d['inhern_count'], 2) : 0;
            $exp[] = $d['exp_count'] > 0 ? round($d['exp_total'] / $d['exp_count'], 2) : 0;
        }

        $data_inhern = DB::table('pengukuran as p')
            ->join('indf_resiko as r', 'p.resiko_id', '=', 'r.id')
            ->join('kategori as k', 'r.kategori_id', '=', 'k.id') // kategori risiko
            ->join('dampak as kd', 'p.inhern_dampak_id', '=', 'kd.id') // lookup dampak
            ->join('kemungkinan as kk', 'p.inhern_kemungkinan_id', '=', 'kk.id') // lookup kemungkinan
            ->where('r.tahun', $tahun_dash)
            ->select(
                'k.kategori_nama as kategori',
                DB::raw('COUNT(p.id) as jumlah_data'),
                // total & rata-rata inhern untuk ditampilkan (contoh Hukum = (10+20)/2=15)
                DB::raw('SUM(p.inhern_nilai) as total_inhern'),
                DB::raw('ROUND(SUM(p.inhern_nilai) / COUNT(p.id)) as rata_inhern'),

                // rata-rata D & K (informasi pendukung)
                DB::raw('ROUND(AVG(kd.dampak_level), 2) as rata_dampak_inhern'),
                DB::raw('ROUND(AVG(kk.kmn_level), 2) as rata_kemungkinan_inhern'),
                DB::raw('LEAST(5, GREATEST(1, ROUND(AVG(kd.dampak_level)))) as dampak_avg_rounded'),
                DB::raw('LEAST(5, GREATEST(1, ROUND(AVG(kk.kmn_level)))) as kemungkinan_avg_rounded')
            )
            ->groupBy('k.kategori_nama')
            ->orderBy('k.kategori_nama')
            ->get();

        $data_expected = DB::table('pengendalian as p')
            ->join('indf_resiko as r', 'p.resiko_id', '=', 'r.id')
            ->join('kategori as k', 'r.kategori_id', '=', 'k.id') // kategori risiko
            ->leftJoin('dampak as kd', 'p.exp_dampak_id', '=', 'kd.id')  // lookup dampak expected
            ->leftJoin('kemungkinan as kk', 'p.exp_kemungkinan_id', '=', 'kk.id') // lookup kemungkinan expected
            ->when($tahun_dash, fn($q) => $q->where('r.tahun', $tahun_dash))
            ->select(
                'k.kategori_nama as kategori',
                DB::raw('COUNT(p.id) as jumlah_data'),

                // total & rata-rata expected (aman untuk NULL & pembagian 0)
                DB::raw('COALESCE(SUM(p.exp_nilai), 0) as total_exp'),
                DB::raw('ROUND(COALESCE(SUM(p.exp_nilai), 0) / NULLIF(COUNT(p.id), 0)) as rata_exp'),

                // rata-rata level dampak & kemungkinan expected
                DB::raw('ROUND(AVG(kd.dampak_level), 2) as rata_dampak_exp'),
                DB::raw('ROUND(AVG(kk.kmn_level), 2) as rata_kemungkinan_exp'),

                // versi bulat 1..5 untuk plotting (pakai alias khusus expected)
                DB::raw('LEAST(5, GREATEST(1, ROUND(AVG(kd.dampak_level)))) as dampak_exp_rounded'),
                DB::raw('LEAST(5, GREATEST(1, ROUND(AVG(kk.kmn_level)))) as kemungkinan_exp_rounded')
            )
            ->groupBy('k.kategori_nama')
            ->orderBy('k.kategori_nama')
            ->get();

        // dd($data_expected);

        return view('pages.dashboard', [
            'title' => $title,
            'tahun_dash' => $tahun_dash,

            'resiko_monitoring' => $resiko_monitoring,
            'groupedDataResiko_monitoring' => $groupedDataResiko_monitoring,

            'persentaseSelesai' => $persentaseSelesai,
            'getKategoriRisk_inhern' => $getKategoriRisk_inhern,
            'getKategoriRisk_exp' => $getKategoriRisk_exp,

            'jumlahResiko' => $jumlahResiko,
            'avg_inhern' => $avg_inhern,
            'avg_exp' => $avg_exp,

            'listmonitoring' => $monitoring,
            'listpengukuran' => $pengukuran,
            'listpengendalian' => $pengendalian,

            'labels' => $labels,
            'inhern' => $inhern,
            'exp' => $exp,

            'data_inhern' => $data_inhern,
            'data_expected' => $data_expected,

        ]);
    }

    public function chartDivisi($tahun = null)
    {
        $tahun = $tahun ?? date('Y');

        // Ambil data pengukuran
        $pengukuran = Pengukuran::with('namaResiko.namaDivisi')
            ->whereHas('namaResiko', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            })
            ->get();

        // Ambil data pengendalian
        $pengendalian = Pengendalian::with('namaResiko.namaDivisi')
            ->whereHas('namaResiko', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            })
            ->get();

        // Gabungkan per divisi
        $dataDivisi = [];

        foreach ($pengukuran as $p) {
            $divisiId = $p->namaResiko->divisi_id ?? null;
            if ($divisiId) {
                $divisiNama = $p->namaResiko->namaDivisi->organization_name ?? 'Unknown';

                if (!isset($dataDivisi[$divisiId])) {
                    $dataDivisi[$divisiId] = [
                        'divisi' => $divisiNama,
                        'inhern_total' => 0,
                        'inhern_count' => 0,
                        'exp_total' => 0,
                        'exp_count' => 0,
                    ];
                }

                $dataDivisi[$divisiId]['inhern_total'] += $p->inhern_nilai ?? 0;
                $dataDivisi[$divisiId]['inhern_count']++;
            }
        }

        foreach ($pengendalian as $p) {
            $divisiId = $p->namaResiko->divisi_id ?? null;
            if ($divisiId && isset($dataDivisi[$divisiId])) {
                $dataDivisi[$divisiId]['exp_total'] += $p->exp_nilai ?? 0;
                $dataDivisi[$divisiId]['exp_count']++;
            }
        }

        // Hitung rata-rata + kategori bobot
        $labels = [];
        $inhern = [];
        $exp = [];
        $kategoriInhern = [];
        $kategoriExp = [];

        foreach ($dataDivisi as $d) {
            $labels[] = $d['divisi'];

            $avgInhern = $d['inhern_count'] > 0 ? round($d['inhern_total'] / $d['inhern_count'], 2) : 0;
            $avgExp = $d['exp_count'] > 0 ? round($d['exp_total'] / $d['exp_count'], 2) : 0;

            $inhern[] = $avgInhern;
            $exp[] = $avgExp;

            $kategoriInhern[] = Bobot::where('tahun', $tahun)
                ->where('bobot_nilai', '<=', $avgInhern)
                ->orderByDesc('bobot_nilai')
                ->value('bobot_kategori') ?? 'Unknown';

            $kategoriExp[] = Bobot::where('tahun', $tahun)
                ->where('bobot_nilai', '<=', $avgExp)
                ->orderByDesc('bobot_nilai')
                ->value('bobot_kategori') ?? 'Unknown';
        }

        return response()->json([
            'labels' => $labels,
            'inhern' => $inhern,
            'exp' => $exp,
            'kategoriInhern' => $kategoriInhern,
            'kategoriExp' => $kategoriExp,
        ]);
    }

    public function index_dash_divisi(Request $request)
    {
        $tahun_dash = $request->input('tahun', date('Y'));
        $title = 'Dashboard Man Risk';

        $resiko_monitoring = Resiko::with('namaKategori', 'namaDivisi')
            ->join('pengukuran', 'indf_resiko.id', '=', 'pengukuran.resiko_id')
            ->where('indf_resiko.tahun', $tahun_dash)
            ->orderByDesc('pengukuran.inhern_nilai')
            ->select('indf_resiko.*') // Pastikan hanya kolom dari tabel resiko yang dipilih
            ->get();


        $groupedDataResiko_monitoring = $resiko_monitoring->groupBy(function ($item) {
            return $item->tahun . '|' . ($item->namaDivisi->organization_name ?? 'Tanpa Divisi') . '|' . $item->divisi_id;
        });

        $resiko_dash = Resiko::where('tahun', $tahun_dash)->get();

        $jumlahResiko = $resiko_dash->count();

        $resikoIds = $resiko_dash->pluck('id');

        $totalInhern = Pengukuran::whereIn('resiko_id', $resikoIds)->sum('inhern_nilai');

        $totalExp = Pengendalian::whereIn('resiko_id', $resikoIds)->sum('exp_nilai');

        // Hitung rata-rata
        $avg_inhern = $jumlahResiko > 0 ? round($totalInhern / $jumlahResiko, 2) : 0;
        $avg_exp = $jumlahResiko > 0 ? round($totalExp / $jumlahResiko, 2) : 0;

        $dataMonitoring = Monitoring::with(['namaResiko'])
            ->whereHas('namaResiko', function ($query) use ($tahun_dash) {
                $query->where('tahun', $tahun_dash);
            })->get();

        $jumlahSelesai = $dataMonitoring->where('status_mitigasi', 'Selesai Dilaksanakan')->count();
        $persentaseSelesai = $jumlahResiko > 0 ? round(($jumlahSelesai / $jumlahResiko) * 100, 2) : 0;

        $getKategoriRisk_inhern = Bobot::where('tahun', $tahun_dash)
            ->where('bobot_nilai', '<=', $avg_inhern)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $getKategoriRisk_exp = Bobot::where('tahun', $tahun_dash)
            ->where('bobot_nilai', '<=', $avg_exp)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $monitoring = Monitoring::with('namaResiko', 'namaPengendalian', 'namaPengukuran')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');

        $pengendalian = Pengendalian::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotExp')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');

        $pengukuran = Pengukuran::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotInhern')
            ->whereHas('namaResiko', function ($q) use ($tahun_dash) {
                $q->where('tahun', $tahun_dash);
            })
            ->get()
            ->keyBy('resiko_id');


        return view('pages.dashboard-list-divisi', [
            'title' => $title,
            'tahun_dash' => $tahun_dash,

            'resiko_monitoring' => $resiko_monitoring,
            'groupedDataResiko_monitoring' => $groupedDataResiko_monitoring,

            'persentaseSelesai' => $persentaseSelesai,
            'getKategoriRisk_inhern' => $getKategoriRisk_inhern,
            'getKategoriRisk_exp' => $getKategoriRisk_exp,

            'jumlahResiko' => $jumlahResiko,
            'avg_inhern' => $avg_inhern,
            'avg_exp' => $avg_exp,

            'listmonitoring' => $monitoring,
            'listpengukuran' => $pengukuran,
            'listpengendalian' => $pengendalian,


        ]);
    }
}
