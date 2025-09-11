@extends('layout.admin')
@section('content')

<style>
    /* Pastikan border rapat & rapi */
    .table {
        border-collapse: collapse !important;
    }

    .table td,
    .table th {
        border: 1px solid #dee2e6 !important;
    }

    table.dataTable tbody td {
        vertical-align: middle;
    }
</style>

<body data-theme="light" class="font-nunito">
    <div id="wrapper" class="theme-cyan">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2><b>{{ $title }}</b></h2>`
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="col-12">
                        <div class="d-flex justify-content-end align-items-center mtop20">

                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#inputModal">
                                <i class="fa fa-plus"></i>&nbsp;INPUT KEMUNGKINAN
                            </button>
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
                                    <th class="align-middle text-center">Daftar Kemungkinan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedData as $tahun => $dataTahun)
                                <tr>
                                    <td class="align-middle text-center">{{ $tahun }}</td>
                                    <td>
                                        <table class="table table-bordered m-0">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle text-center">Level</th>
                                                    <th class="align-middle text-center">Kemungkinan</th>
                                                    <th class="align-middle text-center">Keterangan</th>
                                                    <th class="align-middle text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataTahun as $item)
                                                <tr>
                                                    <td>{{ $item->kmn_level }}</td>
                                                    <td>{{ $item->kmn_nama }}</td>
                                                    <td>{{ $item->kmn_keterangan }}</td>
                                                    <td class="align-middle text-center">
                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$item->id}}" data-id="{{$item->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="input-kemungkinan-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
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

<!-- Input Modal Mitra -->
<div class="modal fade" id="inputModal" aria-labelledby="modalInputKemungkinan" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/input-kemungkinan-add" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                        <div class="col-md-2 col-sm-3">
                            <select name="tahun" id="tahun" class="form-control" style="height: 34px;">
                                @foreach(range(date('Y'), 2020) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Level<span class="required"></span></label>
                        <div class="col-md-2 col-sm-3">
                            <input type="text" id="kmn_level" name="kmn_level" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kemungkinan<span class="required"></span></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="text" id="kmn_nama" name="kmn_nama" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Keterangan<span class="required"></span></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="text" id="kmn_keterangan" name="kmn_keterangan" required="required" class="form-control">
                        </div>
                    </div>

                    <div>
                        <br>
                        <hr>
                        <div class="field item form-group"></div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <b>SIMPAN</b></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($listkemungkinan as $item)
<div class="modal fade" id="editModal{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$item->id}}">Edit Kemungkinan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('input-kemungkinan-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Tahun<span class="required"></span></label>
                        <div class="col-md-4 col-sm-4">
                            <select class="form-control" id="tahun" name="tahun" required>
                                <option value="" disabled>Pilih Tahun</option>
                                @foreach(range(date('Y'), 2020) as $tahun)
                                <option value="{{ $tahun }}" {{ (old('rka_tahun', $item->tahun ?? '') == $tahun) ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Level<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="kmn_level" name="kmn_level" required="required" class="form-control" value="{{ $item->kmn_level }}">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Kemungkinan<span class="required"></span></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="text" id="kmn_nama" name="kmn_nama" required="required" class="form-control" value="{{ $item->kmn_nama }}">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Keterangan<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="kmn_keterangan" name="kmn_keterangan" required="required" class="form-control" value="{{ $item->kmn_keterangan }}">
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

@endsection

@push('js')

@endpush