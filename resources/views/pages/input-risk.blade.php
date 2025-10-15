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
        max-width: 90%;
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
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabView">5. APPROVAL</a></li>

            </ul>
        </div>

        <div class="tab-content">
            <!-- 1. Identifikasi -->
            <div class="tab-pane fade show active" id="tabIdentifikasi">

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
                                            <form method="GET" action="{{ route('input-risk') }}" class="d-flex justify-content-end align-items-center">
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
                    </div>

                    <ul class="nav nav-tabs-new2">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-sasaran">1. SASARAN</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-tujuan">2. TUJUAN</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-event">3. EVENT</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-resiko">4. RESIKO</a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- 1.1 sasaran -->
                        <div class="tab-pane fade show active" id="tab-sasaran">

                            <!-- table sasaran -->
                            <div class="card">
                                <div class="col-md-12 col-sm-12 ">

                                    <body data-theme="light" class="font-nunito">
                                        <div id="wrapper" class="theme-cyan">
                                            <div class="block-header">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h6><b>SASARAN</b></h6>`
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-end align-items-center mtop20">

                                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalinputSasaran">
                                                                    <i class="fa fa-plus"></i>&nbsp;INPUT SASARAN
                                                                </button>
                                                            </div>
                                                        </div>
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
                                                                    <th class="align-middle text-center" style="width: 90%;">Daftar Sasaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($groupedDataSasaran as $tahun => $dataTahun)
                                                                <tr>
                                                                    <td class="align-middle text-center">{{ $tahun }}</td>
                                                                    <td>
                                                                        <table class="table table-bordered m-0">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="align-middle text-center" style="width: 85%;">Sasaran</th>
                                                                                    <th class="align-middle text-center" style="width: 15%;">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($dataTahun as $item)
                                                                                <tr>
                                                                                    <td>{{ $item->sasaran_nama }}</td>
                                                                                    <td class="align-middle text-center">
                                                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalSasaran{{$item->id}}" data-id="{{$item->id}}">
                                                                                            <i class="fa fa-edit"></i>
                                                                                        </a>
                                                                                        <a href="input-sasaran-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input sasaran -->
                            <div class="modal fade" id="modalinputSasaran" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Form Input Sasaran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="/input-sasaran-add" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <select name="tahun" id="tahun" class="form-control" style="height: 34px;">
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
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Sasaran<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <textarea name="sasaran_nama" rows="3" required="required" class="form-control"></textarea>
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

                            <!-- edit sasaran -->
                            @foreach ($listsasaran as $item)
                            <div class="modal fade" id="editModalSasaran{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalSasaranLabel{{$item->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalSasaranLabel{{$item->id}}">Edit Sasaran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('input-sasaran-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="_method" value="PUT">

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <select class="form-control" id="tahun" name="tahun" required>
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
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right ">Sasaran<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <textarea name="sasaran_nama" rows="3" required="required" class="form-control" required="required">{{ $item->sasaran_nama }}</textarea>
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

                        <!-- 1.2 tujuan -->
                        <div class="tab-pane fade" id="tab-tujuan">

                            <!-- table tujuan -->
                            <div class="card">
                                <div class="col-md-12 col-sm-12 ">

                                    <body data-theme="light" class="font-nunito">
                                        <div id="wrapper" class="theme-cyan">
                                            <div class="block-header">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h6><b>TUJUAN</b></h6>`
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-end align-items-center mtop20">

                                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalinputTujuan">
                                                                    <i class="fa fa-plus"></i>&nbsp;INPUT TUJUAN
                                                                </button>
                                                            </div>
                                                        </div>
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
                                                                    <th class="align-middle text-center" style="width: 90%;">Daftar Tujuan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($groupedDataTujuan as $tahun => $dataTahun)
                                                                <tr>
                                                                    <td class="align-middle text-center">{{ $tahun }}</td>
                                                                    <td>
                                                                        <table class="table table-bordered m-0">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="align-middle text-center" style="width: 40%;">Sasaran</th>
                                                                                    <th class="align-middle text-center" style="width: 60%;">List Tujuan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                @foreach ($dataTahun as $namaSasaran => $itemSasaran)
                                                                                <tr>
                                                                                    <td class="align-middle text-center">{{ $namaSasaran }}</td>
                                                                                    <td>
                                                                                        <table class="table table-bordered m-0">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th class="align-middle text-center" style="width: 85%;">Tujuan</th>
                                                                                                    <th class="align-middle text-center" style="width: 15%;">Action</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach ($itemSasaran as $item)
                                                                                                <tr>
                                                                                                    <td>{{ $item->tujuan_nama }}</td>
                                                                                                    <td class="align-middle text-center">
                                                                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalTujuan{{$item->id}}" data-id="{{$item->id}}">
                                                                                                            <i class="fa fa-edit"></i>
                                                                                                        </a>
                                                                                                        <a href="input-tujuan-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input tujuan -->
                            <div class="modal fade" id="modalinputTujuan" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Form Input Tujuan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="/input-tujuan-add" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <select name="tahun" id="tahun-sasaran" class="form-control" style="height: 34px;">
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
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Sasaran<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <select id="sasaran-select" name="sasaran_id" class="form-control">
                                                            <option value="">-- Pilih Sasaran --</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tujuan<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <textarea name="tujuan_nama" rows="3" required="required" class="form-control" required="required"></textarea>
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

                            <!-- edit tujuan -->
                            @foreach ($listtujuan as $item)
                            <div class="modal fade" id="editModalTujuan{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalTujuanLabel{{$item->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalTujuanLabel{{$item->id}}">Edit Tujuan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('input-tujuan-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Sasaran<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <select name="sasaran_id" class="form-control">
                                                            @foreach ($listsasaranedit as $sasaran)
                                                            <option value="{{ $sasaran->id }}"
                                                                {{ $item->sasaran_id == $sasaran->id ? 'selected' : '' }}>
                                                                {{ $sasaran->sasaran_nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tujuan<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <textarea name="tujuan_nama" rows="3" required="required" class="form-control" required="required">{{ $item->tujuan_nama }}</textarea>

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

                        <!-- 1.3 Event -->
                        <div class="tab-pane fade" id="tab-event">

                            <!-- table event -->
                            <div class="card">
                                <div class="col-md-12 col-sm-12 ">

                                    <body data-theme="light" class="font-nunito">
                                        <div id="wrapper" class="theme-cyan">
                                            <div class="block-header">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h6><b>EVENT</b></h6>`
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-end align-items-center mtop20">

                                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalinputEvent">
                                                                    <i class="fa fa-plus"></i>&nbsp;INPUT EVENT
                                                                </button>
                                                            </div>
                                                        </div>
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
                                                                    <th class="align-middle text-center" style="width: 90%;">Daftar Sasaran, Tujuan & Event</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($groupedDataEvent as $tahun => $dataTahun)
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
                                                                                                @foreach ($dataSasaran as $namaTujuan => $itemTujuan)
                                                                                                <tr>
                                                                                                    <td class="align-middle text-center">{{ $namaTujuan }}</td>
                                                                                                    <td>
                                                                                                        <table class="table table-bordered m-0">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <th class="align-middle text-center" style="width: 85%;">Event</th>
                                                                                                                    <th class="align-middle text-center" style="width: 15%;">Action</th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($itemTujuan as $item)
                                                                                                                <tr>
                                                                                                                    <td>{{ $item->event_nama }}</td>
                                                                                                                    <td class="align-middle text-center">
                                                                                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalEvent{{$item->id}}" data-id="{{$item->id}}">
                                                                                                                            <i class="fa fa-edit"></i>
                                                                                                                        </a>
                                                                                                                        <a href="input-event-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
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

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- input event -->
                            <div class="modal fade" id="modalinputEvent" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Form Input Event</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="/input-event-add" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                                                    <div class="col-md-2 col-sm-2">
                                                        <select name="tahun" id="tahun-tujuan" class="form-control" style="height: 34px;">
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
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tujuan<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <select id="tujuan-select" name="tujuan_id" class="form-control">
                                                            <option value="">-- Pilih Tujuan --</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Event<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <textarea name="event_nama" rows="3" required="required" class="form-control" required="required"></textarea>

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

                            <!-- edit event -->
                            @foreach ($listevent as $item)
                            <div class="modal fade" id="editModalEvent{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalEventLabel{{$item->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalEventLabel{{$item->id}}">Edit Tujuan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('input-event-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tujuan<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">
                                                        <select name="tujuan_id" class="form-control">
                                                            @foreach ($listtujuanedit as $tujuan)
                                                            <option value="{{ $tujuan->id }}"
                                                                {{ $item->tujuan_id == $tujuan->id ? 'selected' : '' }}>
                                                                {{ $tujuan->tujuan_nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row align-items-center">
                                                    <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Event<span class="required"></span></label>
                                                    <div class="col-md-8 col-sm-9">

                                                        <textarea name="event_nama" rows="3" required="required" class="form-control" required="required">{{ $item->event_nama }}</textarea>
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

                        <!-- 1.4 Resiko -->
                        <div class="tab-pane fade" id="tab-resiko">

                            <!-- table Resiko -->
                            <div class="card">
                                <div class="col-md-12 col-sm-12 ">

                                    <body data-theme="light" class="font-nunito">
                                        <div id="wrapper" class="theme-cyan">
                                            <div class="block-header">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h6><b>RESIKO</b></h6>`
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-end align-items-center mtop20">

                                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalinputResiko">
                                                                    <i class="fa fa-plus"></i>&nbsp;INPUT RESIKO
                                                                </button>
                                                            </div>
                                                        </div>
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
                    </div>


                </div>


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
                                            <form method="GET" action="{{ route('input-risk') }}" class="d-flex justify-content-end align-items-center">
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
                                            <form method="GET" action="{{ route('input-risk') }}" class="d-flex justify-content-end align-items-center">
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
                                                                    $item_pengendalian = $listpengendalian->get($resiko->id);
                                                                    $item_pengukuran = $listpengukuran->get($resiko->id);
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $resiko->resiko_nama }}</td>
                                                                        <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                                        {{-- Kolom dari Pengukuran --}}
                                                                        <td class="text-right">{{ $item_pengukuran?->inhern_nilai ?? '-' }}</td>
                                                                        <td class="text-center">{{ $item_pengukuran?->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                                        {{-- Kolom dari Pengendalian --}}
                                                                        <td>{{ $item_pengendalian?->rencana ?? '-' }}</td>
                                                                        <td>{{ $item_pengendalian?->pic ?? '-' }}</td>
                                                                        <td class="text-right">{{ $item_pengendalian?->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                                        <td class="text-right">{{ $item_pengendalian?->namaDampak->dampak_level ?? '-' }}</td>
                                                                        <td class="text-right">{{ $item_pengendalian?->exp_nilai ?? '-' }}</td>
                                                                        <td class="text-center">{{ $item_pengendalian?->namaBobotExp->bobot_kategori ?? '-' }}</td>
                                                                        <td class="align-middle text-center">

                                                                            @if ($item_pengukuran && ($item_pengendalian === null || $item_pengendalian->exp_nilai === null))
                                                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalinputPengendalian{{$item_pengukuran->id}}" data-id="{{$item_pengukuran->id}}">
                                                                                <i class="fa fa-plus"></i>
                                                                            </a>
                                                                            @else

                                                                            @if($item_pengendalian)
                                                                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModalPengendalian{{$item_pengendalian->id}}" data-id="{{$item_pengendalian->id}}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
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
                                            <form method="GET" action="{{ route('input-risk') }}" class="d-flex justify-content-end align-items-center">
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
                                                                        <td>

                                                                            @if(empty($item->status_mitigasi) || $item->status_mitigasi === 'Selesai Dilaksanakan')
                                                                            <span class="badge badge-success"><b>{{ $item->status_mitigasi }}</b></span>
                                                                            @elseif($item->status_mitigasi === 'Sedang Dilaksanakan')
                                                                            <span class="badge badge-info"><b>{{ $item->status_mitigasi }}</b></span>
                                                                            @elseif($item->status_mitigasi === 'Belum Dilaksanakan')
                                                                            <span class="badge badge-warning"><b>{{ $item->status_mitigasi }}</b></span>
                                                                            @endif

                                                                        </td>
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

            <!-- 5. Approval -->
            <div class="tab-pane fade" id="tabView">
                <!-- table Resiko -->
                <div class="card">
                    <div class="col-md-12 col-sm-12 ">

                        <body data-theme="light" class="font-nunito">
                            <div id="wrapper" class="theme-cyan">
                                <div class="block-header">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h6><b>LIST RESIKO</b></h6>`
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <form method="GET" action="{{ route('input-risk') }}" class="d-flex justify-content-end align-items-center">
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
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#inputModalApproval">
                                                <i class="fa fa-plus"></i>&nbsp;REQUEST NEW APPROVAL
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </body>

                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="align-middle text-center">Tahun</th>
                                                            <th class="align-middle text-center">Divisi</th>
                                                            <!-- <th class="align-middle text-center">Request By</th> -->
                                                            <th class="align-middle text-center">Approval Name</th>
                                                            <th class="align-middle text-center">Keterangan</th>
                                                            <th class="align-middle text-center">Approval Status</th>
                                                            <th class="align-middle text-center">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($listapproval as $item)
                                                        <tr>

                                                            <td class="align-middle text-center">{{ $item->tahun ?? '-' }}</td>
                                                            <td class="align-middle text-center">{{ $item->namaDivisi['organization_name'] ?? '-'}}</td>
                                                            <!-- <td class="align-middle text-center">{{ $item->namaPekerja['email'] ?? '-' }}</td> -->

                                                            @php
                                                            $statusMap = [
                                                            1 => 'Approval TW I',
                                                            2 => 'Approval TW II',
                                                            3 => 'Approval TW III',
                                                            4 => 'Approval TW IV',
                                                            ];
                                                            @endphp

                                                            <td class="align-middle text-center">{{ $statusMap[$item->app_name] ?? $item->app_name ?? '-' }}</td>
                                                            <td class="align-middle text-center">{{ $item->keterangan ?? '-' }}</td>
                                                            <td class="align-middle text-center">

                                                                @if(empty($item->app_status) || $item->app_status === 'Verified by MR')
                                                                <span class="badge badge-success"><b>{{ $item->app_status }}</b></span>
                                                                @elseif($item->app_status === 'Hold by MR')
                                                                <span class="badge badge-info"><b>{{ $item->app_status }}</b></span>
                                                                @elseif($item->app_status === 'Request Approval')
                                                                <span class="badge badge-info"><b>{{ $item->app_status }}</b></span>
                                                                @elseif($item->app_status === 'Approve - Review MR')
                                                                <span class="badge badge-info"><b>{{ $item->app_status }}</b></span>
                                                                @elseif($item->app_status === 'Hold')
                                                                <span class="badge badge-warning"><b>{{ $item->app_status }}</b></span>

                                                                @endif


                                                            </td>
                                                            <td class="align-middle text-center">

                                                                @if(empty($item->app_status) || $item->app_status === 'Verified by MR')
                                                                <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ViewApproval{{$item->id}}" data-id="{{$item->id}}">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                @else
                                                                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#EditApproval{{$item->id}}" data-id="{{$item->id}}">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                @endif

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

                        <hr>

                        <!-- Input Approval -->
                        <div class="modal fade" id="inputModalApproval" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl custom-width" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Request Approval</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/input-approval-add" method="POST" enctype="multipart/form-data">
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
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kepala Divisi</label>
                                                <div class="col-md-4 col-sm-4">
                                                    <input type="text" name="app_nama_kadiv" class="form-control" value="{{ $kepalaDivisiName }}" disabled>
                                                    <input type="hidden" name="app_kadiv" value="{{ $kepalaDivisiUserId }}">
                                                    <input type="hidden" name="app_status" value="Request Approval">
                                                    <input type="hidden" name="user_id" value="  {{ Auth::user()->user_id }}">

                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Request Approval</label>
                                                <div class="col-md-2 col-sm-2">
                                                    <select class="form-control" id="app_name" name="app_name" required>
                                                        <option value="" selected disabled>Pilih Approval</option>
                                                        <option value="1">Approval TW 1</option>
                                                        <option value="2">Approval TW 2</option>
                                                        <option value="3">Approval TW 3</option>
                                                        <option value="4">Approval TW 4</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <textarea rows="2" name="keterangan" class="form-control">{{ $item->keterangan }}</textarea>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="x_panel">
                                                <div class="x_content">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="table-responsive">
                                                                <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                                                    <thead class="thead-light">
                                                                        <tr>
                                                                            <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                                                            <th class="align-middle text-center" style="width: 70%;">Daftar Sasaran, Tujuan, Event & Resiko</th>

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
                                                                                            <th class="align-middle text-center" style="width: 20%; background-color: #f0f0f5;">Sasaran</th>
                                                                                            <th class="align-middle text-center" style="width: 80%; background-color: #f0f0f5;">List Tujuan</th>
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
                                                                                                            <th class="align-middle text-center" style="width: 20%; background-color: #f0f0f5;">Tujuan</th>
                                                                                                            <th class="align-middle text-center" style="width: 80%; background-color: #f0f0f5;">List Event</th>
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
                                                                                                                            <th class="align-middle text-center" style="width: 20%; background-color: #f0f0f5;">Event</th>
                                                                                                                            <th class="align-middle text-center" style="width: 80%; background-color: #f0f0f5;">List Resiko</th>
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
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Kategori Resiko</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Nama Resiko</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Penyebab Resiko</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Dampak</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Strategi</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prosedur</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Level</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Dampak</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Nilai</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Kategori</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Rencana Pengendalian</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">PIC</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Level</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Dampak</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Nilai</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Kategori</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Jangka Waktu</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Peluang perbaikan</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Status</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Keterangan</th>
                                                                                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Evidence</th>
                                                                                                                                        </tr>
                                                                                                                                    </thead>
                                                                                                                                    <tbody>
                                                                                                                                        @foreach ($itemResiko as $resiko)
                                                                                                                                        <tr>
                                                                                                                                            <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                                                                                                            <td>{{ $resiko->resiko_nama }}</td>
                                                                                                                                            <td>{{ $resiko->resiko_penyebab ?? '-' }}</td>
                                                                                                                                            {{-- Kolom Pengukuran --}}
                                                                                                                                            <td class="text-left">{{ $resiko->namaPengukuran->dampak ?? '-' }}</td>
                                                                                                                                            <td class="text-left">{{ $resiko->namaPengukuran->strategi ?? '-' }}</td>
                                                                                                                                            <td class="text-left">{{ $resiko->namaPengukuran->prosedur ?? '-' }}</td>
                                                                                                                                            <td class="text-right">{{ $resiko->namaPengukuran->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                                                                                                            <td class="text-right">{{ $resiko->namaPengukuran->namaDampak->dampak_level ?? '-' }}</td>
                                                                                                                                            <td class="text-right">{{ $resiko->namaPengukuran->inhern_nilai ?? '-' }}</td>
                                                                                                                                            <td class="text-center">{{ $resiko->namaPengukuran->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                                                                                                            {{-- Kolom Pengendalian --}}
                                                                                                                                            <td class="text-left">{{ $resiko->namaPengendalian->rencana ?? '-' }}</td>
                                                                                                                                            <td class="text-left">{{ $resiko->namaPengendalian->pic ?? '-' }}</td>
                                                                                                                                            <td class="text-right">{{ $resiko->namaPengendalian->namaKemungkinan->kmn_level ?? '-' }}</td>
                                                                                                                                            <td class="text-right">{{ $resiko->namaPengendalian->namaDampak->dampak_level ?? '-' }}</td>
                                                                                                                                            <td class="text-right">{{ $resiko->namaPengendalian->exp_nilai ?? '-' }}</td>
                                                                                                                                            <td class="text-center">{{ $resiko->namaPengendalian->namaBobotExp->bobot_kategori ?? '-' }}</td>
                                                                                                                                            {{-- Kolom Monitoring --}}
                                                                                                                                            <td class="text-center">{{ $resiko->namaMonitoring->jangka_waktu ?? '-' }}</td>
                                                                                                                                            <td class="text-left">{{ $resiko->namaMonitoring->peluang_perbaikan ?? '-' }}</td>
                                                                                                                                            <td class="text-center">{{ $resiko->namaMonitoring->status_mitigasi ?? '-' }}</td>
                                                                                                                                            <td class="text-left">{{ $resiko->namaMonitoring->keterangan ?? '-' }}</td>
                                                                                                                                            <td class="text-left">{{ $resiko->namaMonitoring->evidence ?? '-' }}</td>

                                                                                                                                            {{-- ================== HIDDEN INPUT ================== --}}
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][sasaran_nama]" value="{{ $namaSasaran }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][tujuan_nama]" value="{{ $namaTujuan }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][event_nama]" value="{{ $namaEvent }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][kategori_nama]" value="{{ $resiko->namaKategori->kategori_nama ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][resiko_nama]" value="{{ $resiko->resiko_nama }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][resiko_penyebab]" value="{{ $resiko->resiko_penyebab ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][dampak]" value="{{ $resiko->namaPengukuran->dampak ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][strategi]" value="{{ $resiko->namaPengukuran->strategi ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][prosedur]" value="{{ $resiko->namaPengukuran->prosedur ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][inhern_dampak]" value="{{ $resiko->namaPengukuran->namaDampak->dampak_level ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][inhern_kemungkinan]" value="{{ $resiko->namaPengukuran->namaKemungkinan->kmn_level ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][inhern_nilai]" value="{{ $resiko->namaPengukuran->inhern_nilai ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][inhern_bobot]" value="{{ $resiko->namaPengukuran->namaBobotInhern->bobot_kategori ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][rencana]" value="{{ $resiko->namaPengendalian->rencana ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][pic]" value="{{ $resiko->namaPengendalian->pic ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][exp_kemungkinan]" value="{{ $resiko->namaPengendalian->namaKemungkinan->kmn_level ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][exp_dampak]" value="{{ $resiko->namaPengendalian->namaDampak->dampak_level ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][exp_nilai]" value="{{ $resiko->namaPengendalian->exp_nilai ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][exp_bobot]" value="{{ $resiko->namaPengendalian->namaBobotExp->bobot_kategori ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][jangka_waktu]" value="{{ $resiko->namaMonitoring->jangka_waktu ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][peluang_perbaikan]" value="{{ $resiko->namaMonitoring->peluang_perbaikan ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][status_mitigasi]" value="{{ $resiko->namaMonitoring->status_mitigasi ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][keterangan]" value="{{ $resiko->namaMonitoring->keterangan ?? '' }}">
                                                                                                                                            <input type="hidden" name="resiko[{{ $resiko->id }}][evidence]" value="{{ $resiko->namaMonitoring->evidence ?? '' }}">
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


                                            <hr>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>REQUEST APPROVAL</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Approval -->
                        @foreach ($listapproval as $item)
                        <div class="modal fade" id="EditApproval{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="EditApprovalLabel{{$item->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-xl custom-width" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="EditApproval{{$item->id}}">Form Edit Approval</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('input-approval-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                                                    <input type="text" name="divisi_nama" class="form-control" value="{{ $item->namaDivisi['organization_name'] }}" disabled>
                                                    <input type="hidden" name="divisi_id" value="{{ $item->divisi_id }}">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kepala Divisi</label>
                                                <div class="col-md-4 col-sm-4">
                                                    <input type="text" name="app_kadiv_nama" class="form-control" value="{{ $item->namaKadiv->first_name . ' ' . $item->namaKadiv->last_name }}" disabled>
                                                    <input type="hidden" name="app_kadiv" value="{{ $item->app_kadiv }}">
                                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                                    <input type="hidden" name="app_status" value="Request Approval">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Request Approval</label>
                                                <div class="col-md-2 col-sm-2">

                                                    @php
                                                    $statusMap = [
                                                    1 => 'Approval TW I',
                                                    2 => 'Approval TW II',
                                                    3 => 'Approval TW III',
                                                    4 => 'Approval TW IV',
                                                    ];
                                                    @endphp


                                                    <input type="text" name="app_status_nama" class="form-control" value="{{ $statusMap[$item->app_name] ?? '-' }}" disabled>
                                                    <input type="hidden" name="app_name" value="{{ $item->app_name }}">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan</label>
                                                <div class="col-md-4 col-sm-4">
                                                    <textarea rows="2" name="keterangan" class="form-control" value="{{ $item->keterangan  }}"> {{ $item->keterangan  }}</textarea>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="x_panel">
                                                <div class="x_content">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="table-responsive">
                                                                <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                                                    <thead class="thead-light">
                                                                        <tr>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Sasaran</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Tujuan</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Event</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Kategori Resiko</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Nama Resiko</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Penyebab Resiko</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Dampak</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Strategi</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prosedur</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Level</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Dampak</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Nilai</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Kategori</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Rencana Pengendalian</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">PIC</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Level</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Dampak</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Nilai</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Kategori</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Jangka Waktu</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Peluang perbaikan</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Status</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Keterangan</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Evidence</th>
                                                                        </tr>
                                                                    </thead>

                                                                    @php
                                                                    // === HANYA DATA UNTUK MODAL/APP DIVISI INI ===
                                                                    $detail = $list_approval_detail
                                                                    ->where('app_divisi_id', $item->id)
                                                                    ->values();

                                                                    // Group bertingkat: sasaran -> tujuan -> event
                                                                    $grouped = $detail
                                                                    ->groupBy('sasaran_nama')
                                                                    ->map(function ($tujuanGroup) {
                                                                    return $tujuanGroup->groupBy('tujuan_nama')
                                                                    ->map(function ($eventGroup) {
                                                                    return $eventGroup->groupBy('event_nama');
                                                                    });
                                                                    });
                                                                    @endphp

                                                                    <tbody>
                                                                        @foreach ($grouped as $sasaran => $tujuanGroup)
                                                                        @php $sasaranRowspan = $tujuanGroup->flatten(2)->count(); @endphp
                                                                        @foreach ($tujuanGroup as $tujuan => $eventGroup)
                                                                        @php $tujuanRowspan = $eventGroup->flatten(1)->count(); @endphp
                                                                        @foreach ($eventGroup as $event => $rows)
                                                                        @php $eventRowspan = $rows->count(); @endphp
                                                                        @foreach ($rows as $index => $item)
                                                                        <tr>
                                                                            {{-- SASARAN --}}
                                                                            @if ($loop->parent->first && $loop->parent->parent->first && $index == 0)
                                                                            <td rowspan="{{ $sasaranRowspan }}">{{ $sasaran ?? '-' }}</td>
                                                                            @endif

                                                                            {{-- TUJUAN --}}
                                                                            @if ($loop->parent->first && $index == 0)
                                                                            <td rowspan="{{ $tujuanRowspan }}">{{ $tujuan ?? '-' }}</td>
                                                                            @endif

                                                                            {{-- EVENT --}}
                                                                            @if ($index == 0)
                                                                            <td rowspan="{{ $eventRowspan }}">{{ $event ?? '-' }}</td>
                                                                            @endif

                                                                            {{-- Kolom lain tetap biasa --}}
                                                                            <td>{{ $item->kategori_nama ?? '-' }}</td>
                                                                            <td>{{ $item->resiko_nama }}</td>
                                                                            <td>{{ $item->resiko_penyebab ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->dampak ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->strategi ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->prosedur ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->inhern_kemungkinan ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->inhern_dampak ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->inhern_nilai ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->inhern_bobot ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->rencana ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->pic ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->exp_kemungkinan ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->exp_dampak ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->exp_nilai ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->exp_bobot ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->jangka_waktu ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->peluang_perbaikan ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->status_mitigasi ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->keterangan ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->evidence ?? '-' }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                        @endforeach
                                                                        @endforeach
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <hr>
                                            <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>REQUEST APPROVAL</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- View Approval -->
                        @foreach ($listapproval as $item)
                        <div class="modal fade" id="ViewApproval{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="ViewApprovalLabel{{$item->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-xl custom-width" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ViewApproval{{$item->id}}">View Approval</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('input-approval-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="_method" value="PUT">

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun</label>
                                                <div class="col-md-2 col-sm-2">
                                                    <select name="tahun" class="form-control" style="height: 34px;" disabled>
                                                        @foreach(range(date('Y'), 2020) as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Divisi</label>
                                                <div class="col-md-4 col-sm-4">
                                                    <input type="text" name="divisi_nama" class="form-control" value="{{ $item->namaDivisi['organization_name'] }}" disabled>
                                                    <input type="hidden" name="divisi_id" value="{{ $item->divisi_id }}">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kepala Divisi</label>
                                                <div class="col-md-4 col-sm-4">
                                                    <input type="text" name="app_kadiv_nama" class="form-control" value="{{ $item->namaKadiv->first_name . ' ' . $item->namaKadiv->last_name }}" disabled>
                                                    <input type="hidden" name="app_kadiv" value="{{ $item->app_kadiv }}">
                                                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                                                    <input type="hidden" name="app_status" value="Request Approval">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Request Approval</label>
                                                <div class="col-md-2 col-sm-2">

                                                    @php
                                                    $statusMap = [
                                                    1 => 'Approval TW I',
                                                    2 => 'Approval TW II',
                                                    3 => 'Approval TW III',
                                                    4 => 'Approval TW IV',
                                                    ];
                                                    @endphp


                                                    <input type="text" name="app_status_nama" class="form-control" value="{{ $statusMap[$item->app_name] ?? '-' }}" disabled>
                                                    <input type="hidden" name="app_name" value="{{ $item->app_name }}">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan</label>
                                                <div class="col-md-4 col-sm-4">
                                                    <textarea rows="2" name="keterangan" class="form-control" value="{{ $item->keterangan  }}" disabled> {{ $item->keterangan  }}</textarea>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="x_panel">
                                                <div class="x_content">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="table-responsive">
                                                                <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                                                    <thead class="thead-light">
                                                                        <tr>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Sasaran</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Tujuan</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Event</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Kategori Resiko</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Nama Resiko</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Penyebab Resiko</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Dampak</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Strategi</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prosedur</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Level</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Dampak</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Nilai</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Prb Kategori</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Rencana Pengendalian</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">PIC</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Level</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Dampak</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Nilai</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Exp Kategori</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Jangka Waktu</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Peluang perbaikan</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Status</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Keterangan</th>
                                                                            <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5;">Evidence</th>
                                                                        </tr>
                                                                    </thead>

                                                                    @php
                                                                    // === HANYA DATA UNTUK MODAL/APP DIVISI INI ===
                                                                    $detail = $list_approval_detail
                                                                    ->where('app_divisi_id', $item->id)
                                                                    ->values();

                                                                    // Group bertingkat: sasaran -> tujuan -> event
                                                                    $grouped = $detail
                                                                    ->groupBy('sasaran_nama')
                                                                    ->map(function ($tujuanGroup) {
                                                                    return $tujuanGroup->groupBy('tujuan_nama')
                                                                    ->map(function ($eventGroup) {
                                                                    return $eventGroup->groupBy('event_nama');
                                                                    });
                                                                    });
                                                                    @endphp

                                                                    <tbody>
                                                                        @foreach ($grouped as $sasaran => $tujuanGroup)
                                                                        @php $sasaranRowspan = $tujuanGroup->flatten(2)->count(); @endphp
                                                                        @foreach ($tujuanGroup as $tujuan => $eventGroup)
                                                                        @php $tujuanRowspan = $eventGroup->flatten(1)->count(); @endphp
                                                                        @foreach ($eventGroup as $event => $rows)
                                                                        @php $eventRowspan = $rows->count(); @endphp
                                                                        @foreach ($rows as $index => $item)
                                                                        <tr>
                                                                            {{-- SASARAN --}}
                                                                            @if ($loop->parent->first && $loop->parent->parent->first && $index == 0)
                                                                            <td rowspan="{{ $sasaranRowspan }}">{{ $sasaran ?? '-' }}</td>
                                                                            @endif

                                                                            {{-- TUJUAN --}}
                                                                            @if ($loop->parent->first && $index == 0)
                                                                            <td rowspan="{{ $tujuanRowspan }}">{{ $tujuan ?? '-' }}</td>
                                                                            @endif

                                                                            {{-- EVENT --}}
                                                                            @if ($index == 0)
                                                                            <td rowspan="{{ $eventRowspan }}">{{ $event ?? '-' }}</td>
                                                                            @endif

                                                                            {{-- Kolom lain tetap biasa --}}
                                                                            <td>{{ $item->kategori_nama ?? '-' }}</td>
                                                                            <td>{{ $item->resiko_nama }}</td>
                                                                            <td>{{ $item->resiko_penyebab ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->dampak ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->strategi ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->prosedur ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->inhern_kemungkinan ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->inhern_dampak ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->inhern_nilai ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->inhern_bobot ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->rencana ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->pic ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->exp_kemungkinan ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->exp_dampak ?? '-' }}</td>
                                                                            <td class="text-right">{{ $item->exp_nilai ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->exp_bobot ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->jangka_waktu ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->peluang_perbaikan ?? '-' }}</td>
                                                                            <td class="text-center">{{ $item->status_mitigasi ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->keterangan ?? '-' }}</td>
                                                                            <td class="text-left">{{ $item->evidence ?? '-' }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                        @endforeach
                                                                        @endforeach
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <hr>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

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