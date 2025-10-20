@extends('layout.admin')
@section('content')
<style>
    .custom-width {
        max-width: 90%;
        /* atau 100%, atau 1200px sesuai kebutuhan */
    }
</style>

<style>
    /* Kunci perilaku tabel */
    .table-fixed {
        table-layout: fixed;
        /* penting: paksa patuhi width kolom */
        width: 100%;
        word-wrap: break-word;
    }

    .table-fixed th,
    .table-fixed td {
        vertical-align: middle;
        white-space: normal !important;
        /* biar teks turun baris */
        word-break: break-word !important;
    }

    /* Level tabel utama */
    .col-tahun {
        width: 15% !important;
        text-align: center;
    }

    .col-tujuan-list {
        width: 85% !important;
    }

    /* Tabel di dalam kolom "Daftar Tujuan" */
    .col-sasaran {
        width: 30% !important;
    }

    .col-tujuan {
        width: 75% !important;
    }

    /* kolom isi tujuan */
    .col-action {
        width: 25% !important;
        text-align: center;
    }

    /* kolom aksi */
    .col-action a {
        margin: 2px;
    }

    /* tombol rapi */
</style>


<body data-theme="light" class="font-nunito">
    <div id="wrapper" class="theme-cyan">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2><b>APPROVAL - {{ $organization_name }}</b></h2>`
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="col-12">
                        <div class="d-flex justify-content-end align-items-center mtop20">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form method="GET" action="{{ route('input-approval') }}" class="d-flex justify-content-end align-items-center">
                                    <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                    <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                        @foreach(range(date('Y'), 2020) as $year)
                                        <option value="{{ $year }}" {{ $year == $tahun ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                    <th class="align-middle text-center">Request By</th>
                                    <th class="align-middle text-center">Approval Name</th>
                                    <th class="align-middle text-center">Approval Status</th>
                                    <th class="align-middle text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listapproval as $item)
                                <tr>

                                    <td class="align-middle text-center">{{ $item->tahun ?? '-' }}</td>
                                    <td class="align-middle text-center">{{ $item->namaDivisi['organization_name'] ?? '-'}}</td>
                                    <td class="align-middle text-center">{{ $item->namaPekerja['email'] ?? '-' }}</td>

                                    @php
                                    $statusMap = [
                                    1 => 'Approval TW I',
                                    2 => 'Approval TW II',
                                    3 => 'Approval TW III',
                                    4 => 'Approval TW IV',
                                    ];
                                    @endphp

                                    <td class="align-middle text-center">{{ $statusMap[$item->app_name] ?? $item->app_name ?? '-' }}</td>
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

                                        @if(empty($item->app_status) || $item->app_status === 'Request Approval')
                                        {{-- Belum Approval => tombol "Approval" --}}
                                        <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#addApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-check-circle"></i>
                                        </a>
                                        @elseif($item->app_status === 'Verified by MR')
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ViewApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @elseif($item->app_status === 'Hold by MR')
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#ViewApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @else
                                        {{-- Sudah Approval => tombol "Edit Approval" --}}
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

<!-- Input Approval -->
@foreach ($listapproval as $item)
<div class="modal fade" id="addApproval{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="addApproval{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl custom-width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addApproval{{$item->id}}">Approval Risk Register Divisi</h5>
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
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Approval Status</label>
                        <div class="col-md-2 col-sm-2">
                            <select class="form-control" id="app_status" name="app_status" required>
                                <option value="" selected disabled>Pilih Approval</option>
                                <option value="Approve - Review MR">Approve - Review MR</option>
                                <option value="Hold">Hold</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan</label>
                        <div class="col-md-4 col-sm-4">
                            <textarea rows="2" name="keterangan" class="form-control" required> {{ $item->keterangan  }}</textarea>
                        </div>
                    </div>


                    <hr>

                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered table-hover dataTable table-fixed" style="width:200%">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Sasaran</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Tujuan</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Event</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Kategori Resiko</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Nama Resiko</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Penyebab Resiko</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Dampak</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Strategi</th>
                                                    <th class="align-middle text-center" style="width: 25%; background-color: #f0f0f5;">Prosedur</th>
                                                    <th class="align-middle text-center" style="width: 15%; background-color: #f0f0f5;">Prb Level</th>
                                                    <th class="align-middle text-center" style="width: 15%; background-color: #f0f0f5;">Prb Dampak</th>
                                                    <th class="align-middle text-center" style="width: 15%; background-color: #f0f0f5;">Prb Nilai</th>
                                                    <th class="align-middle text-center" style="width: 25%; background-color: #f0f0f5;">Prb Kategori</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Rencana Pengendalian</th>
                                                    <th class="align-middle text-center" style="width: 25%; background-color: #f0f0f5;">PIC</th>
                                                    <th class="align-middle text-center" style="width: 15%; background-color: #f0f0f5;">Exp Level</th>
                                                    <th class="align-middle text-center" style="width: 15%; background-color: #f0f0f5;">Exp Dampak</th>
                                                    <th class="align-middle text-center" style="width: 15%; background-color: #f0f0f5;">Exp Nilai</th>
                                                    <th class="align-middle text-center" style="width: 25%; background-color: #f0f0f5;">Exp Kategori</th>
                                                    <th class="align-middle text-center" style="width: 25%; background-color: #f0f0f5;">Jangka Waktu</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Peluang perbaikan</th>
                                                    <th class="align-middle text-center" style="width: 25%; background-color: #f0f0f5;">Status</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Keterangan</th>
                                                    <th class="align-middle text-center" style="width: 35%; background-color: #f0f0f5;">Evidence</th>
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
                    <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>SIMPAN</b></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Edit Approval -->
@foreach ($listapproval as $item)
<div class="modal fade" id="EditApproval{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="EditApprovalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl custom-width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditApproval{{$item->id}}">Approval Risk Register Divisi</h5>
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
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Approval Status</label>
                        <div class="col-md-2 col-sm-2">
                            <select class="form-control" id="app_status" name="app_status">
                                <option value="" disabled selected>Pilih Approval</option>
                                @foreach(['Approve - Review MR', 'Hold'] as $app_status)
                                <option value="{{ $app_status }}" {{ $item->app_status == $app_status ? 'selected' : '' }}>{{ $app_status }}</option>
                                @endforeach
                            </select>
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
                    <button type=" submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>UPDATE</b></button>
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
                <h5 class="modal-title" id="ViewApproval{{$item->id}}">Approval Risk Register Divisi</h5>
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
                        <div class="col-md-4 col-sm-4" disabled>
                            <input type="text" name="app_kadiv_nama" class="form-control" value="{{ $item->namaKadiv->first_name . ' ' . $item->namaKadiv->last_name }}" disabled>
                            <input type="hidden" name="app_kadiv" value="{{ $item->app_kadiv }}">
                            <input type="hidden" name="user_id" value="{{ $item->user_id }}">
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
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Approval Status</label>
                        <div class="col-md-2 col-sm-2">
                            <input type="text" name="app_status" class="form-control" value="{{ $item->app_status ?? '-' }}" disabled>
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

@endsection

@push('js')

@endpush