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
            <h2><b>{{ $organization_name }} - {{ $organization_id }}</b></h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                <li class="breadcrumb-item">Risk Register</li>
                <li class="breadcrumb-item">{{ $title }}</li>
            </ul>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="d-flex flex-row-reverse">
                <div class="page_action">
                    <!-- <a href="/muji-input-bisnis" class="btn btn-primary"><i class="fa fa-mail-reply"></i> &nbsp; BACK</a> -->
                </div>

                <div class="p-2 d-flex">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <ul class="nav nav-tabs-new">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabIdentifikasi">1. IDENTIFIKASI</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabPengukuran">2. PENGUKURAN</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabPengendalian">3. PENGENDALIAN</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabMonitoring">4. MONITORING</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabDashboard">5. DASHBOARD</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <!-- 1. Identifikasi -->
            <div class="tab-pane fade show active" id="tabIdentifikasi">

                <!-- table Resiko -->
                <div class="card">
                    <div class="col-md-12 col-sm-12 ">

                        <body data-theme="light" class="font-nunito">
                            <div id="wrapper" class="theme-cyan">
                                <div class="block-header">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h6 class="mb-0"><b>IDENTIFIKASI RESIKO</b></h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form method="GET" action="{{ route('input-risk-divisi', ['id' => $organization_id]) }}" class="d-flex justify-content-end align-items-center">
                                                <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                                <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                                    @foreach(range(date('Y'), 2020) as $year)
                                                    <option value="{{ $year }}" {{ $year == $tahun_pengukuran ? 'selected' : '' }}>
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
                                                        <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                                        <th class="align-middle text-center" style="width: 90%;">Daftar Sasaran, Tujuan, Event & Resiko</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupedDataResiko as $tahun => $dataTahun)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $tahun }}</td>
                                                        <td>
                                                            <table class="table table-bordered m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle text-center" style="width: 20%;">Sasaran</th>
                                                                        <th class="align-middle text-center" style="width: 80%;">List Tujuan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($dataTahun as $namaSasaran => $dataSasaran)
                                                                    <tr>
                                                                        <td class="align-middle text-center">{{ $namaSasaran }}</td>
                                                                        <td>
                                                                            <table class="table table-bordered m-0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="align-middle text-center" style="width: 20%;">Tujuan</th>
                                                                                        <th class="align-middle text-center" style="width: 80%;">List Event</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($dataSasaran as $namaTujuan => $dataTujuan)
                                                                                    <tr>
                                                                                        <td class="align-middle text-center">{{ $namaTujuan }}</td>
                                                                                        <td>
                                                                                            <table class="table table-bordered m-0">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th class="align-middle text-center" style="width: 20%;">Event</th>
                                                                                                        <th class="align-middle text-center" style="width: 80%;">List Resiko</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($dataTujuan as $namaEvent => $itemResiko)
                                                                                                    <tr>
                                                                                                        <td class="align-middle text-center">{{ $namaEvent }}</td>
                                                                                                        <td>
                                                                                                            <table class="table table-bordered m-0">
                                                                                                                <thead>
                                                                                                                    <tr>
                                                                                                                        <th class="align-middle text-center" style="width: 85%;">Kategori Resiko</th>
                                                                                                                        <th class="align-middle text-center" style="width: 85%;">Nama Resiko</th>
                                                                                                                        <th class="align-middle text-center" style="width: 85%;">Penyebab Resiko</th>
                                                                                                                        <th class="align-middle text-center" style="width: 15%;">Action</th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    @foreach ($itemResiko as $item)
                                                                                                                    <tr>
                                                                                                                        <td>{{$item->namaKategori['kategori_nama']??''}}</td>
                                                                                                                        <td>{{ $item->resiko_nama }}</td>
                                                                                                                        <td>{{ $item->resiko_penyebab }}</td>
                                                                                                                        <td class="align-middle text-center">
                                                                                                                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalResiko{{$item->id}}" data-id="{{$item->id}}">
                                                                                                                                <i class="fa fa-edit"></i>
                                                                                                                            </a>
                                                                                                                            <a href="input-resiko-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
                                                                                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                                                                                            </a>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    @endforeach
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
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

                <!-- input Resiko -->
                <div class="modal fade" id="modalinputResiko" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Input Resiko</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="/input-resiko-add" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" id="tahun-event" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi<span class="required"></span></label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" id="bisnis_nama" name="bisnis_nama" required="required" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" id="divisi_id" name="divisi_id" required="required" class="form-control" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Event<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="event-select" name="event_id" class="form-control">
                                                <option value="">-- Pilih Event --</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori Resiko<span class="required"></span></label>
                                        <div class="col-md-4 col-sm-4">
                                            <select id="kategori_id" name="kategori_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Kategori</option>
                                                @foreach ($listkategori as $kategori)
                                                <option value="{{$kategori->id}}">{{$kategori->kategori_nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Nama Resiko<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="resiko_nama" rows="3" required="required" class="form-control" required="required"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Penyebab Resiko<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="resiko_penyebab" rows="3" required="required" class="form-control" required="required"></textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <hr>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>SIMPAN</b></button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- edit Resiko -->
                @foreach ($listresiko as $item)
                <div class="modal fade" id="editModalResiko{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalResikoLabel{{$item->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalResikoLabel{{$item->id}}">Edit Tujuan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('input-resiko-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_method" value="PUT">

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                                        <div class="col-md-2 col-sm-2">
                                            <select class="form-control" id="tahun-sasaran" name="tahun" required>
                                                <option value="" disabled>Pilih Tahun</option>
                                                @foreach(range(date('Y'), 2020) as $tahun)
                                                <option value="{{ $tahun }}" {{ (old('tahun', $item->tahun ?? '') == $tahun) ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi<span class="required"></span></label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" id="bisnis_nama" name="bisnis_nama" required="required" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" id="divisi_id" name="divisi_id" required="required" class="form-control" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Event<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select name="event_id" class="form-control">
                                                @foreach ($listeventedit as $event)
                                                <option value="{{ $event->id }}"
                                                    {{ $item->event_id == $event->id ? 'selected' : '' }}>{{ $event->event_nama }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="kategori_id" name="kategori_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Kategori</option>
                                                @foreach ($listkategori as $kategori)
                                                <option value="{{$kategori->id}}" {{ $item->kategori_id == $kategori->id ? 'selected' : '' }}> {{$kategori->kategori_nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Nama Resiko<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="resiko_nama" rows="3" required="required" class="form-control" required="required">{{ $item->resiko_nama }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Penyebab Resiko<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="resiko_penyebab" rows="3" required="required" class="form-control" required="required">{{ $item->resiko_penyebab }}</textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>UPDATE</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- 2. Pengukuran -->
            <div class="tab-pane fade" id="tabPengukuran">

                <!-- table Pengukuran -->
                <div class="card">
                    <div class="col-md-12 col-sm-12 ">

                        <body data-theme="light" class="font-nunito">
                            <div id="wrapper" class="theme-cyan">
                                <div class="block-header">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h6 class="mb-0"><b>PENGUKURAN RESIKO</b></h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form method="GET" action="{{ route('input-risk-divisi', ['id' => $organization_id]) }}" class="d-flex justify-content-end align-items-center">
                                                <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                                <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                                    @foreach(range(date('Y'), 2020) as $year)
                                                    <option value="{{ $year }}" {{ $year == $tahun_pengukuran ? 'selected' : '' }}>
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
                                                        <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                                        <th class="align-middle text-center" style="width: 90%;">Daftar Pengukuran Resiko</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupedDataResiko_pengukuran as $tahun => $listResiko)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $tahun }}</td>
                                                        <td>
                                                            <table class="table table-bordered m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                                        <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                                        <th class="text-center">Dampak</th>
                                                                        <th class="text-center">Strategi</th>
                                                                        <th class="text-center">Prosedur</th>
                                                                        <th class="text-center">Level P</th>
                                                                        <th class="text-center">Level D</th>
                                                                        <th class="text-center">Bobot Nilai</th>
                                                                        <th class="text-center">Bobot Kategori</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($listResiko as $resiko)
                                                                    @php
                                                                    // $listpengukuran adalah collection keyed by resiko_id
                                                                    $item = $listpengukuran->get($resiko->id);
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $resiko->resiko_nama }}</td>
                                                                        <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                                        <td>{{ $item->dampak ?? '-' }}</td>
                                                                        <td>{{ $item->strategi ?? '-' }}</td>
                                                                        <td>{{ $item->prosedur ?? '-' }}</td>
                                                                        <td>{{ $item->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                                        <td>{{ $item->namaDampak->dampak_level ?? '-' }}</td>
                                                                        <td>{{ $item->inhern_nilai ?? '-' }}</td>
                                                                        <td>{{ $item->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                                        <td class="align-middle text-center">
                                                                            @if($item?->namaBobotInhern?->bobot_kategori === null )
                                                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalinputPengukuran{{$resiko->id}}" data-id="{{$resiko->id}}">
                                                                                <i class="fa fa-plus"></i>
                                                                            </a>
                                                                            @else
                                                                            <a href=" #" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalPengukuran{{$item->id}}" data-id="{{$item->id}}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                            @endif
                                                                        </td>
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

                <!-- input pengukuran -->
                @foreach ($listresiko as $resiko)
                <div class="modal fade" id="modalinputPengukuran{{ $resiko->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Input Pengukuran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('input-pengukuran-add', ['id' => $resiko->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="divisi_nama" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" name="divisi_id" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" class="form-control" disabled>{{ $resiko->resiko_nama }}</textarea>
                                            <input type="hidden" name="resiko_id" value="{{ $resiko->id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" class="form-control" value="{{ $resiko->namaKategori->kategori_nama ?? '-' }}" disabled>
                                            <input type="hidden" name="kategori_id" value="{{ $resiko->namaKategori->id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="dampak" rows="3" required="required" class="form-control" required="required"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Strategi</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="strategi" rows="3" required="required" class="form-control" required="required"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Prosedur</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" name="prosedur" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kemungkinan<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="inhern_kemungkinan_id_{{ $resiko->id }}" name="inhern_kemungkinan_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Kemungkinan</option>
                                                @foreach ($listkemungkinan as $kemungkinan)
                                                <option value="{{ $kemungkinan->id }}" data-level="{{ $kemungkinan->kmn_level }}">
                                                    {{ $kemungkinan->kmn_level }} - {{ $kemungkinan->kmn_nama }} - {{ $kemungkinan->kmn_keterangan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="inhern_dampak_id_{{ $resiko->id }}" name="inhern_dampak_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Dampak</option>
                                                @foreach ($listdampak as $dampak)
                                                @if($dampak->kategori_id == ($resiko->namaKategori->id ?? 0))
                                                <option value="{{ $dampak->id }}" data-level="{{ $dampak->dampak_level }}">
                                                    {{ $dampak->dampak_level }} - {{ $dampak->dampak_nama }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Nilai Inhern</label>
                                        <div class="col-md-5 col-sm-5 d-flex gap-2">
                                            <input type="text" name="inhern_nilai" id="inhern_nilai_{{ $resiko->id }}" class="form-control mr-2" style="max-width: 100px;" readonly>
                                            <input type="text" name="inhern_kategori" id="inhern_kategori_{{ $resiko->id }}" class="form-control" style="max-width: 200px;" readonly>
                                            <input type="hidden" name="inhern_bobot_id" id="inhern_bobot_id_{{ $resiko->id }}">
                                        </div>
                                    </div>

                                    <hr>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>SIMPAN</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- edit pengukuran -->
                @foreach ($listpengukuran as $item)
                <div class="modal fade" id="editModalPengukuran{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalPengukuranLabel{{$item->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalPengukuranLabel{{$item->id}}">Edit Pengukuran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('input-pengukuran-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_method" value="PUT">

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="divisi_nama" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" name="divisi_id" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" class="form-control" disabled>{{ $item->namaResiko->resiko_nama ?? '-' }}</textarea>
                                            <input type="hidden" name="resiko_id" value="{{ $item->namaResiko->id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" class="form-control" value="{{ $item->namaResiko->namaKategori->kategori_nama ?? '-' }}" disabled>
                                            <input type="hidden" name="kategori_id" value="{{ $item->namaResiko->namaKategori->id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="dampak" rows="3" required="required" class="form-control" required="required">{{ $item->dampak }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Strategi</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="strategi" rows="3" required="required" class="form-control" required="required">{{ $item->strategi }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Prosedur</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" name="prosedur" class="form-control" value="{{ $item->prosedur }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kemungkinan<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="inhern_kemungkinan_id_{{ $item->id }}" name="inhern_kemungkinan_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Kemungkinan</option>
                                                @foreach ($listkemungkinan as $kemungkinan)
                                                <option value="{{ $kemungkinan->id }}" data-level="{{ $kemungkinan->kmn_level }}" {{ $item->inhern_kemungkinan_id == $kemungkinan->id ? 'selected' : '' }}>
                                                    {{ $kemungkinan->kmn_level }} - {{ $kemungkinan->kmn_nama }} - {{ $kemungkinan->kmn_keterangan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="inhern_dampak_id_{{ $item->id }}" name="inhern_dampak_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Dampak</option>
                                                @foreach ($listdampak as $dampak)
                                                @if($dampak->kategori_id == ($item->namaResiko->namaKategori->id ?? 0))
                                                <option value="{{ $dampak->id }}" data-level="{{ $dampak->dampak_level }}" {{ $item->inhern_dampak_id == $dampak->id ? 'selected' : '' }}>
                                                    {{ $dampak->dampak_level }} - {{ $dampak->dampak_nama }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Nilai Inhern</label>
                                        <div class="col-md-5 col-sm-5 d-flex gap-2">
                                            <input type="text" name="inhern_nilai" id="inhern_nilai_{{ $item->id }}" class="form-control mr-2" style="max-width: 100px;" value="{{$item->namaBobotInhern->bobot_nilai ?? ''}}" readonly>
                                            <input type="text" name="inhern_kategori" id="inhern_kategori_{{ $item->id }}" class="form-control" style="max-width: 200px;" value="{{$item->namaBobotInhern->bobot_kategori ?? ''}}" readonly>
                                            <input type="hidden" name="inhern_bobot_id" id="inhern_bobot_id_{{ $item->id }}" value="{{ $item->inhern_bobot_id ?? '' }}">
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>UPDATE</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- 3. Pengendalian -->
            <div class="tab-pane fade" id="tabPengendalian">

                <!-- table pengendalian -->
                <div class="card">
                    <div class="col-md-12 col-sm-12 ">

                        <body data-theme="light" class="font-nunito">
                            <div id="wrapper" class="theme-cyan">
                                <div class="block-header">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h6 class="mb-0"><b>PENGENDALIAN RESIKO</b></h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form method="GET" action="{{ route('input-risk-divisi', ['id' => $organization_id]) }}" class="d-flex justify-content-end align-items-center">
                                                <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                                <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                                    @foreach(range(date('Y'), 2020) as $year)
                                                    <option value="{{ $year }}" {{ $year == $tahun_pengukuran ? 'selected' : '' }}>
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
                                                        <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                                        <th class="align-middle text-center" style="width: 90%;">Daftar Pengendalian Resiko</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupedDataResiko_pengendalian as $tahun => $listResiko)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $tahun }}</td>
                                                        <td>
                                                            <table class="table table-bordered m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                                        <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                                        <th class="text-center">Inhern Bobot</th>
                                                                        <th class="text-center">Inhern Kategori</th>
                                                                        <th class="text-center">Rencana Pengendalian</th>
                                                                        <th class="text-center">PIC</th>
                                                                        <th class="text-center">Expc Level P</th>
                                                                        <th class="text-center">Expc Level D</th>
                                                                        <th class="text-center">Expc Bobot Nilai</th>
                                                                        <th class="text-center">Expc Bobot Kategori</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($listResiko as $resiko)

                                                                    @php
                                                                    $item = $listpengendalian->get($resiko->id);
                                                                    $item_pengukuran = $listpengukuran->get($resiko->id);
                                                                    @endphp

                                                                    <tr>
                                                                        <td>{{ $resiko->resiko_nama }}</td>
                                                                        <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                                        {{-- Kolom dari Pengukuran --}}
                                                                        <td class="text-right">{{ $item_pengukuran->inhern_nilai ?? '-' }}</td>
                                                                        <td class="text-center">{{ $item_pengukuran->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                                        {{-- Kolom dari Pengendalian --}}
                                                                        <td>{{ $item->rencana ?? '-' }}</td>
                                                                        <td>{{ $item->pic ?? '-' }}</td>
                                                                        <td class="text-right">{{ $item->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                                        <td class="text-right">{{ $item->namaDampak->dampak_level ?? '-' }}</td>
                                                                        <td class="text-right">{{ $item->exp_nilai ?? '-' }}</td>
                                                                        <td class="text-center">{{ $item->namaBobotExp->bobot_kategori ?? '-' }}</td>
                                                                        <td class="align-middle text-center">
                                                                            @if($item?->exp_nilai === null )
                                                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalinputPengendalian{{$item_pengukuran->id}}" data-id="{{$item_pengukuran->id}}">
                                                                                <i class="fa fa-plus"></i>
                                                                            </a>
                                                                            @else
                                                                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalPengendalian{{$item->id}}" data-id="{{$item->id}}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                            @endif
                                                                        </td>
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

                <!-- input Pengendalian -->
                @foreach ($listpengukuran as $item_pengukuran)
                <div class="modal fade" id="modalinputPengendalian{{ $item_pengukuran->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Input Pengendalian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('input-pengendalian-add', ['id' => $item_pengukuran->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="divisi_nama" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" name="divisi_id" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" class="form-control" disabled>{{ $item_pengukuran->namaResiko->resiko_nama }}</textarea>
                                            <input type="hidden" name="resiko_id" value="{{ $item_pengukuran->namaResiko->id }}">
                                            <input type="hidden" name="pengukuran_id" value="{{ $item_pengukuran->id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori</label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" class="form-control" value="{{ $item_pengukuran->namaResiko->namaKategori->kategori_nama ?? '-' }}" disabled>
                                            <input type="hidden" name="kategori_id" value="{{ $item_pengukuran->namaResiko->namaKategori->id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Inhern Nilai</label>
                                        <div class="col-md-1 col-sm-1">
                                            <input type="text" class="form-control" value="{{ $item_pengukuran->namaBobotInhern->bobot_nilai }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Inhern Kategori</label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" class="form-control" value="{{ $item_pengukuran->namaBobotInhern->bobot_kategori }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Rencana Strategis</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea name="rencana" rows="3" class="form-control" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">PIC</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="pic" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kemungkinan<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="exp_kemungkinan_id_{{ $item_pengukuran->id }}" name="exp_kemungkinan_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Kemungkinan</option>
                                                @foreach ($listkemungkinan as $kemungkinan)
                                                <option value="{{ $kemungkinan->id }}" data-level="{{ $kemungkinan->kmn_level }}">
                                                    {{ $kemungkinan->kmn_level }} - {{ $kemungkinan->kmn_nama }} - {{ $kemungkinan->kmn_keterangan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="exp_dampak_id_{{ $item_pengukuran->id }}" name="exp_dampak_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Dampak</option>
                                                @foreach ($listdampak as $dampak)
                                                @if($dampak->kategori_id == ($item_pengukuran->namaResiko->namaKategori->id ?? 0 ))
                                                <option value="{{ $dampak->id }}" data-level="{{ $dampak->dampak_level }}">
                                                    {{ $dampak->dampak_level }} - {{ $dampak->dampak_nama }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Nilai Expected</label>
                                        <div class="col-md-5 col-sm-5 d-flex gap-2">
                                            <input type="text" name="exp_nilai" id="exp_nilai_{{ $item_pengukuran->id }}" class="form-control mr-2" style="max-width: 100px;" readonly>
                                            <input type="text" name="exp_kategori" id="exp_kategori_{{ $item_pengukuran->id }}" class="form-control" style="max-width: 200px;" readonly>
                                            <input type="hidden" name="exp_bobot_id" id="exp_bobot_id_{{ $item_pengukuran->id }}">
                                        </div>
                                    </div>

                                    <hr>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>SIMPAN</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- edit pengendalian -->
                @foreach ($listpengendalian as $item)
                <div class="modal fade" id="editModalPengendalian{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalPengendalianLabel{{$item->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalPengendalianLabel{{$item->id}}">Edit Pengendalian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('input-pengendalian-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_method" value="PUT">

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="divisi_nama" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" name="divisi_id" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" class="form-control" disabled>{{ $item->namaResiko->resiko_nama ?? '-' }}</textarea>

                                            <input type="hidden" name="resiko_id" value="{{ $item->resiko_id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" class="form-control" value="{{ $item->namaKategori->kategori_nama ?? '-' }}" disabled>
                                            <input type="hidden" name="kategori_id" value="{{ $item->namaKategori->id ?? 0 }}">
                                            <input type="hidden" name="pengukuran_id" value="{{ $item->pengukuran_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Inhern Nilai</label>
                                        <div class="col-md-1 col-sm-1">
                                            <input type="text" class="form-control" value="{{ $item->namaPengukuran->namaBobotInhern->bobot_nilai }}" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Inhern Kategori</label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" class="form-control" value="{{ $item->namaPengukuran->namaBobotInhern->bobot_kategori }}" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Rencana Strategis</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" name="rencana" class="form-control">{{ $item->rencana }}</textarea>

                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">PIC</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" name="pic" class="form-control" value="{{ $item->pic }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kemungkinan<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="exp_kemungkinan_id_{{ $item->id }}" name="exp_kemungkinan_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Kemungkinan</option>
                                                @foreach ($listkemungkinan as $kemungkinan)
                                                <option value="{{ $kemungkinan->id }}" data-level="{{ $kemungkinan->kmn_level }}" {{ $item->exp_kemungkinan_id == $kemungkinan->id ? 'selected' : '' }}>
                                                    {{ $kemungkinan->kmn_level }} - {{ $kemungkinan->kmn_nama }} - {{ $kemungkinan->kmn_keterangan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                                        <div class="col-md-8 col-sm-9">
                                            <select id="exp_dampak_id_{{ $item->id }}" name="exp_dampak_id" class="form-control" required>
                                                <option value="" selected disabled>Pilih Dampak</option>
                                                @foreach ($listdampak as $dampak)
                                                @if($dampak->kategori_id == ($item->namaKategori->id ?? 0))
                                                <option value="{{ $dampak->id }}" data-level="{{ $dampak->dampak_level }}" {{ $item->exp_dampak_id == $dampak->id ? 'selected' : '' }}>
                                                    {{ $dampak->dampak_level }} - {{ $dampak->dampak_nama }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Nilai Expected</label>
                                        <div class="col-md-5 col-sm-5 d-flex gap-2">
                                            <input type="text" name="exp_nilai" id="exp_nilai_{{ $item->id }}" class="form-control mr-2" style="max-width: 100px;" value="{{$item->namaBobotExp->bobot_nilai ?? ''}}" readonly>
                                            <input type="text" name="exp_kategori" id="exp_kategori_{{ $item->id }}" class="form-control" style="max-width: 200px;" value="{{$item->namaBobotExp->bobot_kategori ?? ''}}" readonly>
                                            <input type="hidden" name="exp_bobot_id" id="exp_bobot_id_{{ $item->id }}" value="{{ $item->exp_bobot_id ?? '' }}">
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>UPDATE</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- 4. Monitoring -->
            <div class="tab-pane fade" id="tabMonitoring">
                <!-- table monitoring -->
                <div class="card">
                    <div class="col-md-12 col-sm-12 ">

                        <body data-theme="light" class="font-nunito">
                            <div id="wrapper" class="theme-cyan">
                                <div class="block-header">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h6 class="mb-0"><b>MONITORING RESIKO</b></h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form method="GET" action="{{ route('input-risk-divisi', ['id' => $organization_id]) }}" class="d-flex justify-content-end align-items-center">
                                                <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                                <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                                    @foreach(range(date('Y'), 2020) as $year)
                                                    <option value="{{ $year }}" {{ $year == $tahun_pengendalian ? 'selected' : '' }}>
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
                                                        <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                                        <th class="align-middle text-center" style="width: 90%;">Daftar Monitoring Resiko</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupedDataResiko_monitoring as $tahun => $listResiko)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $tahun }}</td>
                                                        <td>
                                                            <table class="table table-bordered m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                                        <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                                        <th class="text-center">Rencana Pengendalian</th>
                                                                        <th class="text-center">PIC</th>
                                                                        <th class="text-center">Jangka Waktu</th>
                                                                        <th class="text-center">Peluang Perbaikan</th>
                                                                        <th class="text-center">Status</th>
                                                                        <th class="text-center">Keterangan</th>
                                                                        <th class="text-center">Evidence</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($listResiko as $resiko)

                                                                    @php
                                                                    $item = $listmonitoring->get($resiko->id);
                                                                    $item_pengendalian = $listpengendalian->get($resiko->id);
                                                                    @endphp

                                                                    <tr>
                                                                        <td>{{ $resiko->resiko_nama }}</td>
                                                                        <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                                        {{-- Kolom dari Pengendalian --}}
                                                                        <td>{{ $item_pengendalian->rencana ?? '-' }}</td>
                                                                        <td>{{ $item_pengendalian->pic ?? '-' }}</td>
                                                                        {{-- Kolom dari Monitoring --}}
                                                                        <td>{{ $item->jangka_waktu ?? '-' }}</td>
                                                                        <td>{{ $item->peluang_perbaikan ?? '-' }}</td>
                                                                        <td>{{ $item->status_mitigasi ?? '-' }}</td>
                                                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                                                        <td>
                                                                            @if($item?->evidence)
                                                                            <a href="{{asset($item->evidence) }}" target="_blank">View File</a>
                                                                            @else
                                                                            No File Uploaded
                                                                            @endif
                                                                        </td>

                                                                        <td class="align-middle text-center">
                                                                            @if(optional($item)->peluang_perbaikan === null)
                                                                            @if($item_pengendalian)
                                                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalinputMonitoring{{ $item_pengendalian->id }}" data-id="{{ $item_pengendalian->id }}">
                                                                                <i class="fa fa-plus"></i>
                                                                            </a>
                                                                            @else
                                                                            <span class="text-danger">Data belum tersedia</span>
                                                                            @endif
                                                                            @else
                                                                            @if($item)
                                                                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalMonitoring{{ $item->id }}" data-id="{{ $item->id }}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                            @else
                                                                            <span class="text-danger">Data tidak ditemukan</span>
                                                                            @endif
                                                                            @endif
                                                                        </td>
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

                <!-- input Monitoring -->
                @foreach ($listpengendalian as $item_pengendalian)
                <div class="modal fade" id="modalinputMonitoring{{ $item_pengendalian->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Input Monitoring</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('input-monitoring-add', ['id' => $item_pengendalian->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="divisi_nama" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" name="divisi_id" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" class="form-control" disabled>{{ $item_pengendalian->namaResiko->resiko_nama }}</textarea>
                                            <input type="hidden" name="resiko_id" value="{{ $item_pengendalian->namaResiko->id }}">
                                            <input type="hidden" name="pengukuran_id" value="{{ $item_pengendalian->namaPengukuran->id }}">
                                            <input type="hidden" name="pengendalian_id" value="{{ $item_pengendalian->id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori</label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" class="form-control" value="{{ $item_pengendalian->namaResiko->namaKategori->kategori_nama ?? '-' }}" disabled>
                                            <input type="hidden" name="kategori_id" value="{{ $item_pengendalian->namaResiko->namaKategori->id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Jangka Waktu</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="jangka_waktu" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Peluang Perbaikan</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" name="peluang_perbaikan" class="form-control" required></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Status Mitigasi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <select class="form-control" id="status_mitigasi" name="status_mitigasi" required>
                                                <option value="" selected disabled>Pilih Status</option>
                                                <option value="Belum Dilaksanakan">Belum Dilaksanakan</option>
                                                <option value="Sedang Dilaksanakan">Sedang Dilaksanakan</option>
                                                <option value="Selesai Dilaksanakan">Selesai Dilaksanakan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" name="keterangan" class="form-control" required></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Link Evidence</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" name="evidence" class="form-control">
                                        </div>
                                    </div>


                                    <hr>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>SIMPAN</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- edit pengendalian -->
                @foreach ($listmonitoring as $item)
                <div class="modal fade" id="editModalMonitoring{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalMonitoringLabel{{$item->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalMonitoringLabel{{$item->id}}">Edit Monitoring</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('input-monitoring-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_method" value="PUT">

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                        <div class="col-md-2 col-sm-2">
                                            <select name="tahun" class="form-control" style="height: 34px;">
                                                @foreach(range(date('Y'), 2020) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="divisi_nama" class="form-control" value="{{ $organization_name }}" disabled>
                                            <input type="hidden" name="divisi_id" value="{{ $organization_id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Resiko</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" class="form-control" disabled> {{ $item->namaResiko->resiko_nama }}</textarea>
                                            <input type="hidden" name="resiko_id" value="{{ $item->namaResiko->id }}">
                                            <input type="hidden" name="pengukuran_id" value="{{ $item->namaPengukuran->id }}">
                                            <input type="hidden" name="pengendalian_id" value="{{ $item->namaPengendalian->id }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori</label>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" class="form-control" value="{{ $item->namaResiko->namaKategori->kategori_nama ?? '-' }}" disabled>
                                            <input type="hidden" name="kategori_id" value="{{ $item->namaResiko->namaKategori->id ?? 0 }}">
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Jangka Waktu</label>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="jangka_waktu" class="form-control" value="{{ $item->jangka_waktu }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Peluang Perbaikan</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" name="peluang_perbaikan" class="form-control" required> {{ $item->peluang_perbaikan  }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Status Mitigasi</label>
                                        <div class="col-md-4 col-sm-4">
                                            <select class="form-control" id="status_mitigasi" name="status_mitigasi">
                                                <option value="" disabled selected>Pilih Status</option required>
                                                @foreach([
                                                'Belum Dilaksanakan',
                                                'Sedang Dilaksanakan',
                                                'Selesai Dilaksanakan',
                                                ] as $status_mitigasi)
                                                <option value="{{ $status_mitigasi }}" {{ $item->status_mitigasi == $status_mitigasi ? 'selected' : '' }}>{{ $status_mitigasi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan</label>
                                        <div class="col-md-8 col-sm-9">
                                            <textarea rows="3" name="keterangan" class="form-control" required> {{ $item->keterangan  }}</textarea>

                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Link Evidence</label>
                                        <div class="col-md-8 col-sm-9">
                                            <input type="text" name="evidence" class="form-control" value="{{ $item->evidence }}" required>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>UPDATE</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- 5. Dashboard -->
            <div class="tab-pane fade" id="tabDashboard">
                <div class="card">
                    <div class="col-md-12 col-sm-12 ">

                        <body data-theme="light" class="font-nunito">
                            <div id="wrapper" class="theme-cyan">
                                <div class="block-header">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h6 class="mb-0"><b>MONITORING RESIKO</b></h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form method="GET" action="{{ route('input-risk-divisi', ['id' => $organization_id]) }}" class="d-flex justify-content-end align-items-center">
                                                <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                                <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                                    @foreach(range(date('Y'), 2020) as $year)
                                                    <option value="{{ $year }}" {{ $year == $tahun_pengendalian ? 'selected' : '' }}>
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

                        <div class="row">
                            <!-- Widget Jumlah Resiko -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card top_widget l-turquoise h-80">
                                    <div class="body">
                                        <div class="icon bg-light"><i class="fa fa-check-square"></i> </div>
                                        <div class="content text-light">
                                            <div class="text mb-2 text-uppercase"><b>JUMLAH RESIKO</b></div>
                                            <hr>

                                            <small class="text-uppercase">TOTAL </small>
                                            <h5 class="number mb-2">{{$jumlahResiko}}<span class="font-10"></h5>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Widget Inhern -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card top_widget l-parpl h-80">
                                    <div class="body">
                                        <div class="icon bg-light"><i class="fa fa-signal"></i> </div>
                                        <div class="content text-light">
                                            <div class="text mb-2 text-uppercase"><b>NILAI INHERN</b></div>
                                            <hr>

                                            <small class="text-uppercase">Nilai</small>
                                            <h5 class="number mb-2">{{$avg_inhern}} - {{$getKategoriRisk_inhern}}<span class="font-10"></h5>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Widget Expected -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card top_widget l-coral h-80">
                                    <div class="body">
                                        <div class="icon bg-light"><i class="fa fa-gears"></i> </div>
                                        <div class="content text-light">
                                            <div class="text mb-2 text-uppercase"><b>NILAI EXPECTED</b></div>
                                            <hr>

                                            <small class="text-uppercase">Nilai</small>
                                            <h5 class="number mb-2">{{$avg_exp}} - {{$getKategoriRisk_exp}}<span class="font-10"></h5>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Widget Laba Kotor -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card top_widget l-slategray h-80">
                                    <div class="body">
                                        <div class="icon bg-light"><i class="fa fa-money"></i> </div>
                                        <div class="content text-light">
                                            <div class="text mb-2 text-uppercase"><b>STATUS</b></div>
                                            <hr>

                                            <small class="text-uppercase">Terselesaikan</small>
                                            <h5 class="number mb-2">{{$persentaseSelesai}}% <span class="font-10"></h5>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="x_panel">
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                                        <th class="align-middle text-center" style="width: 90%;">Daftar Monitoring Resiko</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupedDataResiko_monitoring as $tahun => $listResiko)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $tahun }}</td>
                                                        <td>
                                                            <table class="table table-bordered m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                                        <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                                        <th class="text-center">Nilai Inhern</th>
                                                                        <th class="text-center">Kategori Inhern</th>
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
                                                                        {{-- Kolom dari Pengukuran --}}
                                                                        <td class="text-right">{{ $item_pengukuran->inhern_nilai ?? '-' }}</td>
                                                                        <td class="text-center">{{ $item_pengukuran->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                                        {{-- Kolom dari Pengendalian --}}
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

<!-- Dropdown Sasaran dan Tahun pada Tujuan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tahunSelectTujuan = document.getElementById('tahun-sasaran');
        const divisiId = document.getElementById('divisi_id').value;
        const sasaranSelect = document.getElementById('sasaran-select');

        function loadSasaran(tahun) {
            fetch(`/get-sasaran?tahun=${tahun}&divisi_id=${divisiId}`)
                .then(response => response.json())
                .then(data => {
                    sasaranSelect.innerHTML = '<option value="">-- Pilih Sasaran --</option>';
                    Object.entries(data).forEach(([id, nama]) => {
                        const opt = document.createElement('option');
                        opt.value = id;
                        opt.text = nama;
                        sasaranSelect.appendChild(opt);
                    });
                });
        }

        tahunSelectTujuan.addEventListener('change', function() {
            loadSasaran(this.value);
        });

        // Load default saat pertama kali (tahun default)
        loadSasaran(tahunSelectTujuan.value);
    });
</script>

<!-- Dropdown Tujuan dan Tahun pada Event -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tahunSelectEvent = document.getElementById('tahun-tujuan');
        const divisiId = document.getElementById('divisi_id').value;
        const tujuanSelect = document.getElementById('tujuan-select');

        function loadTujuan(tahun) {
            fetch(`/get-tujuan?tahun=${tahun}&divisi_id=${divisiId}`)
                .then(response => response.json())
                .then(data => {
                    tujuanSelect.innerHTML = '<option value="">-- Pilih Tujuan --</option>';
                    Object.entries(data).forEach(([id, nama]) => {
                        const opt = document.createElement('option');
                        opt.value = id;
                        opt.text = nama;
                        tujuanSelect.appendChild(opt);
                    });
                });
        }

        tahunSelectEvent.addEventListener('change', function() {
            loadTujuan(this.value);
        });

        // Load default saat pertama kali (tahun default)
        loadTujuan(tahunSelectEvent.value);
    });
</script>

<!-- Dropdown Event dan Tahun pada Resiko -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tahunSelect = document.getElementById('tahun-event');
        const eventSelect = document.getElementById('event-select');
        const divisiId = document.getElementById('divisi_id').value;

        function loadEvent(tahun) {
            fetch(`{{ route('event.byYear') }}?tahun=${encodeURIComponent(tahun)}&divisi_id=${encodeURIComponent(divisiId)}`)
                .then(r => r.json())
                .then(data => {
                    eventSelect.innerHTML = '<option value="">-- Pilih Event --</option>';
                    Object.entries(data).forEach(([id, nama]) => {
                        eventSelect.appendChild(new Option(nama, id));
                    });
                    if (Object.keys(data).length === 0) {
                        eventSelect.innerHTML = '<option value="">(Belum ada event)</option>';
                    }
                })
                .catch(e => {
                    console.error(e);
                    eventSelect.innerHTML = '<option value="">(Error memuat)</option>';
                });
        }

        tahunSelect.addEventListener('change', () => loadEvent(tahunSelect.value));
        loadEvent(tahunSelect.value);
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


<!-- Pengukuran Nilai Inhern -->
@php
$bobotMapping = $listbobot->mapWithKeys(function($bobot) {
return [$bobot->bobot_nilai => ['kategori' => $bobot->bobot_kategori, 'id' => $bobot->id]];
});
@endphp

<script>
    const bobotMapping = @json($bobotMapping);

    // Fungsi utama untuk menghitung bobot berdasarkan kemungkinan & dampak
    function calculateAndSetBobot(selectKemungkinan, selectDampak, bobotNilaiField, bobotKategoriField, bobotIdField) {
        if (!selectKemungkinan || !selectDampak || !bobotNilaiField || !bobotKategoriField || !bobotIdField) {
            console.warn("Missing elements for bobot calculation.");
            return;
        }

        const levelKemungkinan = parseInt(selectKemungkinan.selectedOptions[0]?.getAttribute('data-level')) || 0;
        const levelDampak = parseInt(selectDampak.selectedOptions[0]?.getAttribute('data-level')) || 0;

        if (levelKemungkinan > 0 && levelDampak > 0) {
            const total = levelKemungkinan * levelDampak;
            bobotNilaiField.value = total;

            if (bobotMapping[total]) {
                bobotKategoriField.value = bobotMapping[total].kategori;
                bobotIdField.value = bobotMapping[total].id;
            } else {
                bobotKategoriField.value = '';
                bobotIdField.value = '';
            }
        } else {
            bobotNilaiField.value = '';
            bobotKategoriField.value = '';
            bobotIdField.value = '';
        }
    }

    // Fungsi inisialisasi untuk setiap modal
    function setupModalListeners(modal, idExtractor) {
        const modalId = modal.id;
        const itemId = idExtractor(modalId);

        $(modal).on('shown.bs.modal', function() {
            setTimeout(() => {
                // Inhern
                const inh_kemungkinan = modal.querySelector(`#inhern_kemungkinan_id_${itemId}`);
                const inh_dampak = modal.querySelector(`#inhern_dampak_id_${itemId}`);
                const inh_nilai = modal.querySelector(`#inhern_nilai_${itemId}`);
                const inh_kategori = modal.querySelector(`#inhern_kategori_${itemId}`);
                const inh_bobot = modal.querySelector(`#inhern_bobot_id_${itemId}`);
                calculateAndSetBobot(inh_kemungkinan, inh_dampak, inh_nilai, inh_kategori, inh_bobot);

                // Expected
                const exp_kemungkinan = modal.querySelector(`#exp_kemungkinan_id_${itemId}`);
                const exp_dampak = modal.querySelector(`#exp_dampak_id_${itemId}`);
                const exp_nilai = modal.querySelector(`#exp_nilai_${itemId}`);
                const exp_kategori = modal.querySelector(`#exp_kategori_${itemId}`);
                const exp_bobot = modal.querySelector(`#exp_bobot_id_${itemId}`);
                calculateAndSetBobot(exp_kemungkinan, exp_dampak, exp_nilai, exp_kategori, exp_bobot);
            }, 100);
        });

        // Listener Inhern
        const inh_kemungkinan = modal.querySelector(`#inhern_kemungkinan_id_${itemId}`);
        const inh_dampak = modal.querySelector(`#inhern_dampak_id_${itemId}`);
        if (inh_kemungkinan) {
            inh_kemungkinan.addEventListener('change', () => {
                calculateAndSetBobot(inh_kemungkinan, inh_dampak,
                    modal.querySelector(`#inhern_nilai_${itemId}`),
                    modal.querySelector(`#inhern_kategori_${itemId}`),
                    modal.querySelector(`#inhern_bobot_id_${itemId}`)
                );
            });
        }
        if (inh_dampak) {
            inh_dampak.addEventListener('change', () => {
                calculateAndSetBobot(inh_kemungkinan, inh_dampak,
                    modal.querySelector(`#inhern_nilai_${itemId}`),
                    modal.querySelector(`#inhern_kategori_${itemId}`),
                    modal.querySelector(`#inhern_bobot_id_${itemId}`)
                );
            });
        }

        // Listener Expected
        const exp_kemungkinan = modal.querySelector(`#exp_kemungkinan_id_${itemId}`);
        const exp_dampak = modal.querySelector(`#exp_dampak_id_${itemId}`);
        if (exp_kemungkinan) {
            exp_kemungkinan.addEventListener('change', () => {
                calculateAndSetBobot(exp_kemungkinan, exp_dampak,
                    modal.querySelector(`#exp_nilai_${itemId}`),
                    modal.querySelector(`#exp_kategori_${itemId}`),
                    modal.querySelector(`#exp_bobot_id_${itemId}`)
                );
            });
        }
        if (exp_dampak) {
            exp_dampak.addEventListener('change', () => {
                calculateAndSetBobot(exp_kemungkinan, exp_dampak,
                    modal.querySelector(`#exp_nilai_${itemId}`),
                    modal.querySelector(`#exp_kategori_${itemId}`),
                    modal.querySelector(`#exp_bobot_id_${itemId}`)
                );
            });
        }
    }

    // Jalankan ketika DOM siap
    document.addEventListener("DOMContentLoaded", function() {
        const modalSelectors = [{
                prefix: 'modalinputPengukuran',
                extractor: id => id.replace('modalinputPengukuran', '')
            },
            {
                prefix: 'editModalPengukuran',
                extractor: id => id.replace('editModalPengukuran', '')
            },
            {
                prefix: 'modalinputPengendalian',
                extractor: id => id.replace('modalinputPengendalian', '')
            },
            {
                prefix: 'editModalPengendalian',
                extractor: id => id.replace('editModalPengendalian', '')
            },
        ];

        modalSelectors.forEach(({
            prefix,
            extractor
        }) => {
            const modals = document.querySelectorAll(`[id^='${prefix}']`);
            modals.forEach(modal => {
                setupModalListeners(modal, extractor);
            });
        });
    });
</script>




@endpush