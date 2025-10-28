@extends('layout.admin')
@section('content')
<style>
    .custom-width {
        max-width: 90%;
        /* atau 100%, atau 1200px sesuai kebutuhan */
    }

    /* ===== Header Risk Register ===== */
    .rr-header .row {
        align-items: center;
        /* sejajarkan vertikal */
        margin-bottom: 2px !important;
        /* jarak antar baris */
    }

    /* Label kolom kiri */
    .rr-header .col-2 {
        font-weight: 700;
        color: #333;
        font-size: 14px;
        text-align: right;
        padding-right: 2px !important;
        /* jarak minimal antara label & input */
        flex: 0 0 15% !important;
        max-width: 15% !important;
    }

    /* Kolom textbox */
    .rr-header .col-5 {
        flex: 0 0 45% !important;
        max-width: 45% !important;
    }

    /* Style textbox */
    .rr-header .form-control[disabled],
    .rr-header .form-control[readonly] {
        background: #e9ecef !important;
        border: 1px solid #d0d4d9 !important;
        height: 26px !important;
        font-size: 13px !important;
        padding: 1px 5px !important;
        line-height: 1.2 !important;
    }

    /* Saat print — supaya tetap rapat */
    @media print {
        .rr-header .row {
            margin-bottom: 1px !important;
        }

        .rr-header .col-2 {
            font-size: 12px;
        }

        .rr-header .form-control[disabled] {
            height: 22px !important;
            padding: 0 4px !important;
            font-size: 12px !important;
        }
    }
</style>

<body data-theme="light" class="font-nunito">
    <div id="wrapper" class="theme-cyan">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2><b>APPROVAL MAN RISK</b></h2>`
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="col-12">
                        <div class="d-flex justify-content-end align-items-center mtop20">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form method="GET" action="{{ route('input-approval-mr') }}" class="d-flex justify-content-end align-items-center">
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
                                    <!-- <th class="align-middle text-center">Request By</th> -->
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
                                    <td class="align-middle text-center">
                                        @if(empty($item->app_status) || $item->app_status === 'Verified by MR')
                                        <span class="badge badge-success"><b>{{ $item->app_status }}</b></span>
                                        @elseif($item->app_status === 'Hold by MR')
                                        <span class="badge badge-info"><b>{{ $item->app_status }}</b></span>
                                        @else
                                        <span class="badge badge-warning"><b>{{ $item->app_status }}</b></span>
                                        @endif

                                    </td>
                                    <td class="align-middle text-center">

                                        @if(empty($item->app_status) || $item->app_status === 'Hold by MR')
                                        {{-- Belum Approval => tombol "Approval" --}}
                                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#EditApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-edit"></i>
                                        </a>


                                        @elseif($item->app_status === 'Verified by MR')
                                        {{-- Sudah diverifikasi oleh MR => tampilkan tombol Print --}}
                                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#EditApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#PrintApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-print"></i>
                                        </a>


                                        @else
                                        {{-- Sudah Approval => tombol "Edit Approval" --}}
                                        <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#addApproval{{$item->id}}" data-id="{{$item->id}}">
                                            <i class="fa fa-check-circle"></i>
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
                <h5 class="modal-title" id="addApproval{{$item->id}}">Approval Risk By Manrisk</h5>
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
                                @foreach(['Verified by MR', 'Hold by MR'] as $app_status)
                                <option value="{{ $app_status }}" {{ $item->app_status == $app_status ? 'selected' : '' }}>{{ $app_status }}</option>
                                @endforeach
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
                                                    <th class="align-middle text-center" style="width: 85%; background-color: #f0f0f5ff;">Exp Nilai</th>
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
                                @foreach(['Verified by MR', 'Hold by MR'] as $app_status)
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

<!-- Print Approval -->
@foreach ($listapproval as $item)
<div class="modal fade" id="PrintApproval{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="PrintApprovalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl custom-width" role="document">
        <div class="modal-content" id="print-area-{{ $item->id }}">
            <div class="modal-header">
                <h5 class="modal-title">Risk Register Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- ===== HEADER ===== --}}
                @php
                $statusMap = [1=>'Approval TW I',2=>'Approval TW II',3=>'Approval TW III',4=>'Approval TW IV'];
                @endphp

                <div class="rr-header mb-2">
                    <div class="row">
                        <div class="col-2">Tahun</div>
                        <div class="col-5">
                            <input class="form-control form-control-sm" value="{{ $item->tahun ?? date('Y') }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">Divisi</div>
                        <div class="col-5">
                            <input class="form-control form-control-sm" value="{{ $item->namaDivisi['organization_name'] ?? '-' }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">Approval</div>
                        <div class="col-5">
                            <input class="form-control form-control-sm" value="{{ $statusMap[$item->app_name] ?? '-' }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">Status</div>
                        <div class="col-5">
                            <input class="form-control form-control-sm" value="{{ $item->app_status ?? 'Menunggu' }}" disabled>
                        </div>
                    </div>
                </div>
                <hr>

                @php
                $detail = $list_approval_detail->where('app_divisi_id', $item->id)->values();
                @endphp

                {{-- ================== TABEL RISK REGISTER (SATU TABEL) ================== --}}

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width:48px;">No</th>
                                <th style="min-width:180px;">Nama Risiko</th>
                                <th style="min-width:140px;">Kategori Risiko</th>

                                <th class="text-center" style="width:80px;">Inhern Prob</th>
                                <th class="text-center" style="width:100px;">Inhern Dampak</th>
                                <th class="text-center" style="width:80px;">Inhern Nilai</th>
                                <th class="text-center" style="width:120px;">Kategori Inhern</th>

                                <th style="min-width:220px;">Pengendalian Risiko</th>

                                <th class="text-center" style="width:100px;">Exp Dampak</th>
                                <th class="text-center" style="width:80px;">Exp Prob</th>
                                <th class="text-center" style="width:80px;">Exp Nilai</th>
                                <th class="text-center" style="width:110px;">Kategori Exp</th>

                                <th style="min-width:120px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $d)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $d->resiko_nama ?? '-' }}</td>
                                <td>{{ $d->kategori_nama ?? '-' }}</td>

                                {{-- Inhern --}}
                                <td class="text-center">{{ $d->inhern_kemungkinan ?? '-' }}</td>
                                <td class="text-center">{{ $d->inhern_dampak ?? '-' }}</td>
                                <td class="text-center">{{ $d->inhern_nilai ?? '-' }}</td>
                                <td class="text-center">{{ $d->inhern_bobot ?? '-' }}</td>

                                {{-- Pengendalian --}}
                                <td>{{ $d->rencana ?? '-' }}</td>

                                {{-- Residual/Expected (Exp) --}}
                                <td class="text-center">{{ $d->exp_dampak ?? '-' }}</td>
                                <td class="text-center">{{ $d->exp_kemungkinan ?? '-' }}</td>
                                <td class="text-center">{{ $d->exp_nilai ?? '-' }}</td>
                                <td class="text-center">{{ $d->exp_bobot ?? '-' }}</td>

                                {{-- Monitoring --}}
                                <td>{{ $d->status_mitigasi ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                {{-- ============ HALAMAN TANDA TANGAN ============ --}}
                <section class="signatures mt-5">
                    <div class="signature-box">
                        <p class="sig-title">Disiapkan Oleh:</p>
                        <p class="sig-sub">Kepala Divisi {{ $item->namaDivisi['organization_name'] ?? 'Divisi YBS' }}</p>
                        <div class="sig-space"></div>
                        <p class="sig-line">({{ ($item->namaKadiv->first_name ?? '').' '.($item->namaKadiv->last_name ?? '') }})</p>
                    </div>

                    <div class="signature-box">
                        <p class="sig-title">Diverifikasi Oleh:</p>
                        <p class="sig-sub">Kepala Divisi Manajemen Risiko MUJ</p>
                        <div class="sig-space"></div>
                        <p class="sig-line">({{ $nama_kepala_mr ?? 'Nama Kepala MR' }})</p>
                    </div>
                </section>

                <hr class="no-print">
                <div class="text-right no-print">
                    <button type="button" class="btn btn-info btn-print-preview" data-id="{{ $item->id }}">
                        <i class="fa fa-print"></i> <b>PRINT PREVIEW</b>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@endforeach



@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-print-preview');
            if (!btn) return;

            const id = btn.dataset.id;
            const src = document.querySelector('#print-area-' + id);
            if (!src) return;

            // --- Ambil header informasi ---
            const rr = src.querySelector('.rr-header');
            const head = {
                tahun: '',
                divisi: '',
                approval: '',
                status: ''
            };
            if (rr) {
                const inputs = rr.querySelectorAll('input, .form-control');
                head.tahun = inputs[0]?.value || inputs[0]?.textContent || '';
                head.divisi = inputs[1]?.value || inputs[1]?.textContent || '';
                head.approval = inputs[2]?.value || inputs[2]?.textContent || '';
                head.status = inputs[3]?.value || inputs[3]?.textContent || '';
            }

            // --- Ambil tabel utama ---
            const table = src.querySelector('table');
            if (!table) return;

            // Clone tabel & hilangkan inline style bawaan
            const cleanTable = table.cloneNode(true);
            cleanTable.removeAttribute('style');
            cleanTable.querySelectorAll('[style]').forEach(el => el.removeAttribute('style'));
            cleanTable.querySelectorAll('colgroup, col').forEach(el => el.remove());

            // --- Ambil tanda tangan (opsional) ---
            const signatureSection = src.querySelector('.signatures');
            const signaturesHTML = signatureSection ? signatureSection.outerHTML : '';

            // --- Buat iframe print ---
            const frame = document.createElement('iframe');
            frame.style.position = 'fixed';
            frame.style.right = '0';
            frame.style.bottom = '0';
            frame.style.width = '0';
            frame.style.height = '0';
            frame.style.border = '0';
            document.body.appendChild(frame);

            const w = frame.contentWindow;
            const d = w.document;

            // --- HTML print lengkap ---
            const html = `
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Risk Register Divisi</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
            <style>
                @page { size: A4 landscape; margin: 1cm; }
                body { margin:0; font-size:10px; color:#111; }
                h5 { font-size: 16px; font-weight: 700; margin: 0 0 10px; }
                .hr { border-top:1px solid #e5e7eb; margin: 6px 0 12px; }

                .hdr {
                    display: grid;
                    grid-template-columns: 120px 1fr;
                    grid-row-gap: 6px;
                    grid-column-gap: 10px;
                    max-width: 70%;
                    margin-bottom: 10px;
                }
                .hdr .lbl { font-weight:700; }
                .hdr .val {
                    background:#eef2f7;
                    border:1px solid #e0e6ed;
                    border-radius:6px;
                    padding:6px 8px;
                }

                /* ====== TABLE STYLE ====== */
                .table-responsive { overflow: visible !important; }
                table { 
                    width:100%; 
                    border-collapse:collapse; 
                    table-layout:auto; /* biar fleksibel */
                }
                .table { font-size:9.5px; }
                .table th, .table td {
                    border:1px solid #cfd6de;
                    padding:4px 6px;
                    vertical-align:middle;
                    word-wrap:break-word;
                    white-space:normal;
                }
                thead.thead-light th { background:#f0f0f5 !important; }
                tr, td, th { page-break-inside: avoid; }

                /* ====== ATUR LEBAR KOLOM ====== */
                .table th:nth-child(1)  { width:3%;  }  /* No */
                .table th:nth-child(2)  { width:15%; } /* Nama Resiko */
                .table th:nth-child(3)  { width:10%; } /* Kategori Resiko */
                .table th:nth-child(4)  { width:5%;  } /* Inhern Prob */
                .table th:nth-child(5)  { width:5%;  } /* Inhern Dampak */
                .table th:nth-child(6)  { width:5%;  } /* Inhern Nilai */
                .table th:nth-child(7)  { width:8%;  } /* Kategori Inhern */
                .table th:nth-child(8)  { width:15%; } /* Pengendalian Resiko */
                .table th:nth-child(9)  { width:5%;  } /* Exp Dampak */
                .table th:nth-child(10) { width:5%;  } /* Exp Prob */
                .table th:nth-child(11) { width:5%;  } /* Exp Nilai */
                .table th:nth-child(12) { width:8%;  } /* Kategori Exp */
                .table th:nth-child(13) { width:8%;  } /* Status */

                /* ====== SIGNATURE SECTION ====== */
                .signatures {
                    page-break-before:always;
                    min-height:80vh;
                    display:flex;
                    justify-content:space-between;
                    align-items:flex-start;
                    padding:8vh 3vw 0;
                    font-size:12px;
                }
                .signature-box { width:46%; text-align:center; }
                .sig-title { font-weight:700; margin-bottom:2px; }
                .sig-sub { margin:0 0 60px; }
                .sig-space { height:90px; }
                .sig-line { display:inline-block; min-width:260px; margin-top:10px; border-top:1px solid #000; padding-top:6px; font-weight:600; }

                /* ====== HIDE ELEMENT NON-PRINT ====== */
                .no-print, .btn, .btn-print-preview { display:none !important; }

                @media print {
                    header, footer { display:none !important; }
                    .table { font-size:9px; }
                    .table th, .table td { padding:3px 5px; }
                }
            </style>
        </head>
        <body>

            <h5>Risk Register Divisi</h5>
            <div class="hr"></div>

            <div class="hdr">
                <div class="lbl">Tahun</div><div class="val">${head.tahun || '-'}</div>
                <div class="lbl">Divisi</div><div class="val">${head.divisi || '-'}</div>
                <div class="lbl">Approval</div><div class="val">${head.approval || '-'}</div>
                <div class="lbl">Status</div><div class="val">${head.status || '-'}</div>
            </div>

            <div class="table-responsive">${cleanTable.outerHTML}</div>

            ${signaturesHTML}

        </body>
        </html>`;

            d.open();
            d.write(html);
            d.close();

            setTimeout(() => {
                w.focus();
                w.print();
                setTimeout(() => frame.remove(), 350);
            }, 250);
        });
    });
</script>




@endpush