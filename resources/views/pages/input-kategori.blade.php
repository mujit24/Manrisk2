@extends('layout.admin')
@section('content')

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
                                <i class="fa fa-plus"></i>&nbsp;INPUT KATEGORI
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
                                    <th class="align-middle text-center">Daftar Kategori</th>
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
                                                    <th class="align-middle text-center">Kategori</th>
                                                    <th class="align-middle text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataTahun as $item)
                                                <tr>
                                                    <td>{{ $item->kategori_nama }}</td>
                                                    <td class="align-middle text-center">
                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$item->id}}" data-id="{{$item->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="input-kategori-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
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

<!-- Input Modal Kategori -->
<div class="modal fade" id="inputModal" aria-labelledby="modalInputKategori" aria-hidden="true">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/input-kategori-add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Tahun<span class="required"></span></label>
                        <div class="col-md-4 col-sm-4">
                            <select name="tahun" id="tahun" class="form-control" style="height: 34px;">
                                @foreach(range(date('Y'), 2020) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Kategori<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="kategori_nama" name="kategori_nama" required="required" class="form-control">
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

@foreach ($listkategori as $item)
<div class="modal fade" id="editModal{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$item->id}}">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('input-kategori-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Kategori<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="kategori_nama" name="kategori_nama" required="required" class="form-control" value="{{ $item->kategori_nama }}">
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