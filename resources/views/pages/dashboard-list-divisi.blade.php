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
    /* Sticky Columns */
    .sticky-col {
        position: sticky;
        background-color: white;
        z-index: 2;
    }

    .left-col-0 {
        left: 0;
        z-index: 3;
    }

    .left-col-1 {
        left: 180px;
    }

    .left-col-2 {
        left: 360px;
    }

    .left-col-3 {
        left: 540px;
    }

    /* Sticky TH fix */
    thead .sticky-col {
        background-color: rgb(87, 91, 96) !important;
        color: white !important;
        z-index: 4;
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
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h6 class="mb-0"><b>LIST RESIKO DIVISI</b></h6>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form method="GET" action="{{ route('dashboard-list-divisi') }}" class="d-flex justify-content-end align-items-center">
                                    <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                    <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                        @foreach(range(date('Y'), 2020) as $year)
                                        <option value="{{ $year }}" {{ $year == $tahun_dash ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
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
                                        <tr>
                                            <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                            <th class="align-middle text-center" style="width: 15%;">Divisi</th>
                                            <th class="align-middle text-center" style="width: 75%;">Daftar Monitoring Resiko</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedDataResiko_monitoring as $key => $listResiko)

                                        @php
                                        [$tahun, $divisi_nama, $divisi_id] = explode('|', $key);
                                        @endphp

                                        <tr>
                                            <td class="align-middle text-center">{{ $tahun }}</td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('input-risk-divisi', ['id' => $divisi_id]) }}">{{ $divisi_nama }}</a>
                                            </td>
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
                                                            <th class="text-center">Penngendalian Resiko</th>
                                                            <th class="text-center">D Expected</th>
                                                            <th class="text-center">P Expected</th>
                                                            <th class="text-center">Nilai Expected</th>
                                                            <th class="text-center">Kategori Expected</th>
                                                            <th class="text-center">Status</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($listResiko as $resiko)

                                                        @php
                                                        $item = $listmonitoring->get($resiko->id);
                                                        $item_pengendalian = $listpengendalian->get($resiko->id);
                                                        $item_pengukuran = $listpengukuran->get($resiko->id);
                                                        @endphp

                                                        <tr>
                                                            <td>{{ $resiko->resiko_nama }}</td>
                                                            <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengukuran->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengukuran->namaDampak->dampak_level ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengukuran->inhern_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $item_pengukuran->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                            <td class="text-left">{{ $item_pengendalian->rencana ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengendalian->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengendalian->namaDampak->dampak_level ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengendalian->exp_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $item_pengendalian->namaBobotExp->bobot_kategori ?? '-' }}</td>
                                                            <td class="text-center">{{ $item->status_mitigasi ?? '-' }}</td>

                                                        </tr>
                                                        @endforeach
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