@extends('layout.admin')
@section('content')

<style>
    .profile-image {
        width: 150px;
        /* Sesuaikan ukuran sesuai kebutuhan Anda */
        height: 150px;
        /* Pastikan tinggi dan lebar sama untuk bentuk bulat */
        object-fit: cover;
        /* Memast
        ikan gambar menutupi seluruh kotak tanpa mengubah rasio aspek */
    }

    .custom-width {
        max-width: 80%;
        /* atau 100%, atau 1200px sesuai kebutuhan */
    }

    .btn-group .btn {
        min-width: 200px;
        /* agar lebar sama */
        height: 40px;
        /* agar tinggi seragam */
        font-weight: bold;
    }

    #riskTabButtons .btn {
        background-color: white;
        color: #333;
        border: 1px solid #ccc;
        transition: 0.2s;
    }

    #riskTabButtons .btn.active {
        background-color: #ccc;
        /* abu-abu */
        color: black;
    }
</style>
<style>
    .form-inline .form-group {
        display: flex;
        align-items: center;
    }

    .form-inline label {
        margin-bottom: 0;
        font-size: 13px;
        color: #2b6777;
    }

    .form-inline select,
    .form-inline button {
        font-size: 13px;
    }

    @media (max-width: 991px) {
        .form-inline {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-inline .form-group {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>



<div class="block-header">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- Nama Divisi mengikuti dari divisi user saat login -->
            <h2><b>DASHBOARD MANAJEMEN RESIKO MUJ</b></h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                <li class="breadcrumb-item">Dashboard</li>

            </ul>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="d-flex flex-row-reverse">
                <div class="page_action">

                </div>

                <div class="p-2 d-flex">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="card">
        <div class="col-md-12 col-sm-12 ">

            <body data-theme="light" class="font-nunito">
                <div id="wrapper" class="theme-cyan">
                    <div class="block-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-2 mb-lg-0">
                                <h6 class="mb-0 font-weight-bold text-uppercase text-success">LIST RESIKO DIVISI</h6>
                            </div>

                            <div class="col-lg-9 col-md-12 col-sm-12">
                                {{-- FORM FILTER --}}
                                <form method="GET" action="{{ route('dashboard-list-divisi') }}"
                                    class="form-inline justify-content-end flex-wrap">

                                    @php
                                    $twNow = request('tw', 'all');
                                    $katNow = request('kategori', 'all');
                                    $thNow = request('tahun', $tahun_dash ?? date('Y'));
                                    $twLabel = [1=>'Triwulan 1',2=>'Triwulan 2',3=>'Triwulan 3',4=>'Triwulan 4'];
                                    @endphp

                                    {{-- Filter Triwulan --}}
                                    <div class="form-group mr-2 mb-2">
                                        <label for="tw" class="mr-2 font-weight-bold">Triwulan</label>
                                        <select name="tw" id="tw" class="form-control form-control-sm" style="width:130px;">
                                            <option value="all" {{ $twNow==='all' ? 'selected' : '' }}>All</option>
                                            @foreach([1,2,3,4] as $tw)
                                            <option value="{{ $tw }}" {{ (string)$tw === (string)$twNow ? 'selected' : '' }}>
                                                {{ $twLabel[$tw] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Filter Kategori --}}

                                    @php
                                    $katNow = request('kategori', 'all');
                                    @endphp

                                    <div class="form-group mr-2 mb-2">
                                        <label for="kategori" class="mr-2 font-weight-bold">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control form-control-sm" style="min-width:180px;">
                                            <option value="all" {{ $katNow==='all' ? 'selected' : '' }}>All</option>
                                            @forelse($kategoriOptions ?? [] as $opt)
                                            <option value="{{ $opt->kategori_nama }}"
                                                {{ (string)$opt->kategori_nama === (string)$katNow ? 'selected' : '' }}>
                                                {{ $opt->kategori_nama }}
                                            </option>
                                            @empty
                                            <option value="" disabled>— Tidak ada kategori —</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    {{-- Filter Tahun --}}
                                    <div class="form-group mr-2 mb-2">
                                        <label for="tahun" class="mr-2 font-weight-bold">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control form-control-sm" style="width:110px;">
                                            @foreach(range(date('Y'), 2020) as $year)
                                            <option value="{{ $year }}" {{ (string)$year === (string)$thNow ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Tombol Filter --}}
                                    <div class="form-group mb-2">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </body>

            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="align-middle text-center" style="width:10%;">Tahun</th>
                                            <th class="align-middle text-center" style="width:15%;">Divisi</th>
                                            <th class="align-middle text-center" style="width:15%;">Approval</th>
                                            <th class="align-middle text-center" style="width:75%;">Detail Resiko</th>
                                        </tr>
                                    </thead>

                                    @php $twMap = [1=>'Triwulan 1',2=>'Triwulan 2',3=>'Triwulan 3',4=>'Triwulan 4']; @endphp

                                    <tbody>
                                        @foreach ($groupedDataResiko_monitoring as $key => $listResiko)
                                        @php
                                        $parts = explode('|', $key);
                                        [$tahunRow, $divisi_nama, $divisi_id, $app_name] = array_pad($parts, 4, null);
                                        @endphp
                                        <tr>
                                            <td class="align-middle text-center">{{ $tahunRow }}</td>
                                            <td class="align-middle text-center">{{ $divisi_nama }}</td>
                                            <td class="align-middle text-center">{{ $twMap[(int)$app_name] ?? '-' }}</td>
                                            <td>
                                                <table class="table table-bordered m-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                            <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                            <th class="text-center">D Inhern</th>
                                                            <th class="text-center">P Inhern</th>
                                                            <th class="text-center">Nilai Inhern</th>
                                                            <th class="text-center">Kategori Inhern</th>
                                                            <th class="text-center">Pengendalian Risiko</th>
                                                            <th class="text-center">D Expected</th>
                                                            <th class="text-center">P Expected</th>
                                                            <th class="text-center">Nilai Expected</th>
                                                            <th class="text-center">Kategori Expected</th>
                                                            <th class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($listResiko as $d)
                                                        <tr>
                                                            <td>{{ $d->resiko_nama }}</td>
                                                            <td>{{ $d->kategori_nama ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->inhern_dampak ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->inhern_kemungkinan ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->inhern_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $d->inhern_bobot ?? '-' }}</td>
                                                            <td class="text-left">{{ $d->rencana ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->exp_dampak ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->exp_kemungkinan ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->exp_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $d->exp_bobot ?? '-' }}</td>
                                                            <td class="text-center">

                                                                @if(empty($d->status_mitigasi) || $d->status_mitigasi === 'Selesai Dilaksanakan')
                                                                <span class="badge badge-success"><b>{{ $d->status_mitigasi }}</b></span>
                                                                @elseif($d->status_mitigasi === 'Sedang Dilaksanakan')
                                                                <span class="badge badge-info"><b>{{ $d->status_mitigasi }}</b></span>
                                                                @elseif($d->status_mitigasi === 'Belum Dilaksanakan')
                                                                <span class="badge badge-warning"><b>{{ $d->status_mitigasi }}</b></span>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center text-muted">Tidak ada data.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


@push('js')

<script>
    $(document).on('click', '.toggle-row', function() {
        const targetClass = $(this).data('target');
        const $icon = $(this).find('i');
        $('.' + targetClass).toggle(); // show/hide rows
        $icon.toggleClass('fa-plus fa-minus');
    });
</script>

<script>
    document.querySelectorAll('#riskTabButtons .btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('#riskTabButtons .btn').forEach(function(el) {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>

<!-- untuk aktif nav bar tetap dihalaman yang sama -->
<script>
    $(document).ready(function() {
        // Simpan tab yang terakhir di-click ke localStorage
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });

        // Ambil tab terakhir dari localStorage saat halaman reload
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>



@endpush