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
use App\Models\Approval_Divisi;
use App\Models\Approval;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {

        if (Auth::check()) {
            $title = 'Approval Divisi';

            $organization_id = DB::connection('mysql_erp')
                ->table('employment')
                ->where('user_id', Auth::user()->user_id)
                ->value('organization_id');

            $organization_name = DB::connection('mysql_erp')
                ->table('employment')
                ->where('organization_id', $organization_id)
                ->value('organization_name');

            $user_name = DB::connection('mysql_erp')
                ->table('employee')
                ->where('user_id', Auth::user()->user_id)
                ->value('first_name', 'last_name');

            // ... kode sisanya

        } else {
            // Redirect ke halaman login atau tampilkan pesan error
            return redirect()->route('login');
        }

        $tahun = $request->input('tahun', date('Y'));

        $approval = Approval_Divisi::with(['namaDivisi', 'namaPekerja'])
            ->where('divisi_id', $organization_id)
            ->get();

        $approval_detail = Approval::whereIn('app_divisi_id', $approval->pluck('id'))->get();


        $pengukuran = Pengukuran::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotInhern')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun);
            })
            ->get()
            ->keyBy('resiko_id');

        $pengendalian = Pengendalian::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotExp')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun);
            })
            ->get()
            ->keyBy('resiko_id');

        $resiko_monitoring = Resiko::with('namaKategori')
            ->where('divisi_id', $organization_id)
            ->where('tahun', $tahun)
            ->orderBy('id')
            ->get();

        $groupedDataResiko_monitoring = $resiko_monitoring->groupBy('tahun');

        $resiko = Resiko::with([
            'namaKategori',
            'namaDivisi',
            'namaPengukuran.namaDampak',
            'namaPengukuran.namaKemungkinan',
            'namaPengukuran.namaBobotInhern',
            'namaPengendalian.namaDampak',
            'namaPengendalian.namaKemungkinan',
            'namaPengendalian.namaBobotExp'
        ])
            ->where('tahun', $tahun)
            ->where('divisi_id', $organization_id)
            ->orderByDesc('id') // Anda bisa ganti dengan orderByDesc('namaPengukuran.inhern_nilai')
            ->get();

        $jumlahResiko = $resiko->count();
        $resikoIds = $resiko->pluck('id');

        $totalInhern = Pengukuran::whereIn('resiko_id', $resikoIds)
            ->sum('inhern_nilai');

        $totalExp = Pengendalian::whereIn('resiko_id', $resikoIds)
            ->sum('exp_nilai');

        // Hitung rata-rata
        $avg_inhern = $jumlahResiko > 0 ? round($totalInhern / $jumlahResiko, 2) : 0;
        $avg_exp = $jumlahResiko > 0 ? round($totalExp / $jumlahResiko, 2) : 0;

        $jumlahSelesai = Pengendalian::whereNotNull('evidence')
            ->where('evidence', '<>', '')
            ->count();
        $persentaseSelesai = $jumlahResiko > 0 ? round(($jumlahSelesai / $jumlahResiko) * 100, 2) : 0;

        $getKategoriRisk_inhern = Bobot::where('tahun', $tahun)
            ->where('bobot_nilai', '<=', $avg_inhern)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $getKategoriRisk_exp = Bobot::where('tahun', $tahun)
            ->where('bobot_nilai', '<=', $avg_exp)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        return view('pages.input-approval', [
            'title' => $title,

            'tahun' => $tahun,
            'listapproval' => $approval,
            'list_approval_detail' => $approval_detail,

            'listresiko' => $resiko,

            'listpengukuran' => $pengukuran,
            'listpengendalian' => $pengendalian,

            'groupedDataResiko_monitoring' => $groupedDataResiko_monitoring,

            'organization_name' => $organization_name,

            'user_name' => $user_name,

            'tahun' => $tahun,

            'persentaseSelesai' => $persentaseSelesai,

            'avg_inhern' => $avg_inhern,
            'avg_exp' => $avg_exp,

            'getKategoriRisk_inhern' => $getKategoriRisk_inhern,
            'getKategoriRisk_exp' => $getKategoriRisk_exp,
        ]);
    }

    //simpan ke database
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // === Cek apakah sudah ada data di app_divisi ===
            $appDivisi = Approval_Divisi::where('tahun', $request->tahun)
                ->where('divisi_id', $request->divisi_id)
                ->where('app_name', $request->app_name)
                ->first();

            if ($appDivisi) {
                // === Update data jika sudah ada ===
                $appDivisi->app_status = $request->app_status;
                $appDivisi->app_kadiv = $request->app_kadiv;
                $appDivisi->keterangan = $request->keterangan;
                $appDivisi->save();

                // === Hapus detail lama supaya tidak duplikat ===
                Approval::where('app_divisi_id', $appDivisi->id)->delete();

                $appDivisiId = $appDivisi->id;
            } else {
                // === Insert baru jika belum ada ===
                $appDivisi = new Approval_Divisi();
                $appDivisi->tahun = $request->tahun;
                $appDivisi->divisi_id = $request->divisi_id;
                $appDivisi->user_id = $request->user_id;
                $appDivisi->app_name = $request->app_name;
                $appDivisi->app_status = $request->app_status;
                $appDivisi->app_kadiv = $request->app_kadiv;
                $appDivisi->keterangan = $request->keterangan;
                $appDivisi->save();

                $appDivisiId = $appDivisi->id;
            }

            // === Simpan ulang ke tabel app_detail ===
            foreach ($request->resiko as $resikoId => $data) {
                $detail = new Approval();
                $detail->app_divisi_id = $appDivisiId; // foreign key
                $detail->sasaran_nama = $data['sasaran_nama'] ?? null;
                $detail->tujuan_nama = $data['tujuan_nama'] ?? null;
                $detail->event_nama = $data['event_nama'] ?? null;
                $detail->kategori_nama = $data['kategori_nama'] ?? null;
                $detail->resiko_nama = $data['resiko_nama'] ?? null;
                $detail->resiko_penyebab = $data['resiko_penyebab'] ?? null;
                $detail->dampak = $data['dampak'] ?? null;
                $detail->pengendalian = $data['pengendalian'] ?? null;
                $detail->pic = $data['pic'] ?? null;
                $detail->jangka_waktu = $data['jangka_waktu'] ?? null;
                $detail->inhern_dampak = $data['inhern_dampak'] ?? null;
                $detail->inhern_kemungkinan = $data['inhern_kemungkinan'] ?? null;
                $detail->inhern_nilai = $data['inhern_nilai'] ?? null;
                $detail->inhern_bobot = $data['inhern_bobot'] ?? null;
                $detail->realisasi = $data['realisasi'] ?? null;
                $detail->exp_kemungkinan = $data['exp_kemungkinan'] ?? null;
                $detail->exp_dampak = $data['exp_dampak'] ?? null;
                $detail->exp_nilai = $data['exp_nilai'] ?? null;
                $detail->exp_bobot = $data['exp_bobot'] ?? null;
                $detail->keterangan = $data['keterangan'] ?? null;
                $detail->evidence = $data['evidence'] ?? null;
                $detail->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    //edit file dari database
    public function edit($id)
    {

        $appDivisi = Approval_Divisi::findOrFail($id);
        return view('approval.edit', compact('approval'));
    }

    //update save ke database
    public function update(Request $request, $id)
    {

        $appDivisi = Approval_Divisi::findOrFail($id);
        $appDivisi->tahun = $request->tahun;
        $appDivisi->divisi_id = $request->divisi_id;
        $appDivisi->app_name = $request->app_name;
        $appDivisi->app_status = $request->app_status;
        $appDivisi->app_kadiv = $request->app_kadiv;
        $appDivisi->keterangan = $request->keterangan;
        $appDivisi->save();


        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function index_mr(Request $request)
    {

        if (Auth::check()) {
            $title = 'Approval Man Risk';

            $organization_id = DB::connection('mysql_erp')
                ->table('employment')
                ->where('user_id', Auth::user()->user_id)
                ->value('organization_id');

            $organization_name = DB::connection('mysql_erp')
                ->table('employment')
                ->where('organization_id', $organization_id)
                ->value('organization_name');

            $user_name = DB::connection('mysql_erp')
                ->table('employee')
                ->where('user_id', Auth::user()->user_id)
                ->value('first_name', 'last_name');
        } else {
            // Redirect ke halaman login atau tampilkan pesan error
            return redirect()->route('login');
        }

        $tahun = $request->input('tahun', date('Y'));

        $resiko = Resiko::with([
            'namaKategori',
            'namaDivisi',
            'namaPengukuran.namaDampak',
            'namaPengukuran.namaKemungkinan',
            'namaPengukuran.namaBobotInhern',
            'namaPengendalian.namaDampak',
            'namaPengendalian.namaKemungkinan',
            'namaPengendalian.namaBobotExp'

        ])
            ->where('tahun', $tahun)
            ->where('divisi_id', $organization_id)
            ->orderByDesc('id') // Anda bisa ganti dengan orderByDesc('namaPengukuran.inhern_nilai')
            ->get();

        // Ambil approval yang SUDAH diverifikasi MR saja
        $approval = Approval_Divisi::with(['namaDivisi'])
            ->where('tahun', $tahun)
            ->whereIn('app_status', [
                'Approve - Review MR',
                'Verified by MR',
                'Hold by MR'
            ])
            ->orderBy('divisi_id')
            ->orderBy('app_name')
            ->get();

        // --- Jika list resiko sudah kamu punya (mis. $listResikoAll) ---
        // pastikan ada koleksi resiko per divisi: $risikoPerDivisi[divisi_id] => Collection<Resiko>
        $risikoPerDivisi = $resiko->groupBy('divisi_id');

        // Bentuk struktur untuk blade: key = "tahun|divisi_nama|divisi_id|app_name" => list resiko
        $groupedDataResiko_monitoring = $approval->mapWithKeys(function ($ap) use ($risikoPerDivisi) {
            $key = "{$ap->tahun}|{$ap->namaDivisi->organization_name}|{$ap->divisi_id}|{$ap->app_name}";
            return [$key => $risikoPerDivisi->get($ap->divisi_id, collect())];
        });


        $kepala_mr = DB::connection('mysql_erp')
            ->table('employee')
            ->join('employment', 'employee.user_id', '=', 'employment.user_id')
            ->select('employee.first_name', 'employee.last_name')
            ->where('employment.job_position', 'Kepala Divisi Manajemen Risiko MUJ')
            ->first();

        // Cek apakah data ditemukan
        if ($kepala_mr) {
            $nama_kepala_mr = $kepala_mr->first_name . ' ' . $kepala_mr->last_name;
        } else {
            $nama_kepala_mr = 'Nama Pejabat MR Tidak Ditemukan'; // Placeholder jika tidak ada
        }

        $approval_detail = Approval::whereIn('app_divisi_id', $approval->pluck('id'))->get();


        $pengukuran = Pengukuran::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotInhern')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun);
            })
            ->get()
            ->keyBy('resiko_id');

        $pengendalian = Pengendalian::with('namaResiko.namaKategori', 'namaDampak', 'namaKemungkinan', 'namaBobotExp')
            ->whereHas('namaResiko', function ($q) use ($organization_id, $tahun) {
                $q->where('divisi_id', $organization_id)
                    ->where('tahun', $tahun);
            })
            ->get()
            ->keyBy('resiko_id');

        $resiko_monitoring = Resiko::with('namaKategori')
            ->where('divisi_id', $organization_id)
            ->where('tahun', $tahun)
            ->orderBy('id')
            ->get();

        $groupedDataResiko_monitoring = $resiko_monitoring->groupBy('tahun');

        $jumlahResiko = $resiko->count();
        $resikoIds = $resiko->pluck('id');

        $totalInhern = Pengukuran::whereIn('resiko_id', $resikoIds)
            ->sum('inhern_nilai');

        $totalExp = Pengendalian::whereIn('resiko_id', $resikoIds)
            ->sum('exp_nilai');

        // Hitung rata-rata
        $avg_inhern = $jumlahResiko > 0 ? round($totalInhern / $jumlahResiko, 2) : 0;
        $avg_exp = $jumlahResiko > 0 ? round($totalExp / $jumlahResiko, 2) : 0;

        $jumlahSelesai = Pengendalian::whereNotNull('evidence')
            ->where('evidence', '<>', '')
            ->count();
        $persentaseSelesai = $jumlahResiko > 0 ? round(($jumlahSelesai / $jumlahResiko) * 100, 2) : 0;

        $getKategoriRisk_inhern = Bobot::where('tahun', $tahun)
            ->where('bobot_nilai', '<=', $avg_inhern)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        $getKategoriRisk_exp = Bobot::where('tahun', $tahun)
            ->where('bobot_nilai', '<=', $avg_exp)
            ->orderByDesc('bobot_nilai')
            ->value('bobot_kategori') ?? 'Unknown';

        return view('pages.input-approval-mr', [
            'title' => $title,

            'tahun' => $tahun,
            'listapproval' => $approval,
            'list_approval_detail' => $approval_detail,

            'listresiko' => $resiko,

            'listpengukuran' => $pengukuran,
            'listpengendalian' => $pengendalian,

            'groupedDataResiko_monitoring' => $groupedDataResiko_monitoring,

            'organization_name' => $organization_name,

            'user_name' => $user_name,

            'tahun' => $tahun,

            'persentaseSelesai' => $persentaseSelesai,

            'avg_inhern' => $avg_inhern,
            'avg_exp' => $avg_exp,

            'getKategoriRisk_inhern' => $getKategoriRisk_inhern,
            'getKategoriRisk_exp' => $getKategoriRisk_exp,

            'nama_kepala_mr' => $nama_kepala_mr,
        ]);
    }
}
