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
                                <i class="fa fa-plus"></i>&nbsp;INPUT DAMPAK
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
                                    <th class="align-middle text-center">Daftar Dampak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedData as $tahun => $kategoriGroup)
                                <tr>
                                    <td class="align-middle text-center">{{ $tahun }}</td>
                                    <td>
                                        <table class="table table-bordered table-sm m-0">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle text-center">Kategori</th>
                                                    <th class="align-middle text-center">Dampak Kategori</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kategoriGroup as $kategoriNama => $items)

                                                <tr>
                                                    <td class="align-middle text-center">{{ $kategoriNama }}</td>
                                                    <td>
                                                        <table class="table table-bordered table-sm m-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="align-middle text-center" style="width: 15%;">Level</th>
                                                                    <th class="align-middle text-center" style="width: 55%;">Nama Dampak</th>
                                                                    <th class="align-middle text-center" style="width: 25%;">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @foreach ($items as $item)
                                                                <tr>
                                                                    <td class="align-middle text-center">{{ $item->dampak_level }}</td>
                                                                    <td>{{ $item->dampak_nama }}</td>
                                                                    <td class="align-middle text-center">
                                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$item->id}}" data-id="{{$item->id}}">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a href="input-dampak-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
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

<!-- Input Modal Dampak -->
<div class="modal fade" id="inputModal" aria-labelledby="modalInputDampak" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/input-dampak-add" method="POST" enctype="multipart/form-data">
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
                            <input type="text" id="dampak_level" name="dampak_level" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori<span class="required"></span></label>
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
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="dampak_nama" name="dampak_nama" required="required" class="form-control">
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

@foreach ($listdampak as $item)
<div class="modal fade" id="editModal{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$item->id}}">Edit Dampak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('input-dampak-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Tahun<span class="required"></span></label>
                        <div class="col-md-2 col-sm-3">
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
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Level<span class="required"></span></label>
                        <div class="col-md-2 col-sm-3">
                            <input type="text" id="dampak_level" name="dampak_level" required="required" class="form-control" value="{{ $item->dampak_level }}">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Kategori<span class="required"></span></label>
                        <div class="col-md-4 col-sm-4">
                            <select id="kategori_id" name="kategori_id" class="form-control" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach ($listkategori as $kategori)
                                <option value="{{$kategori->id}}" {{ $item->kategori_id == $kategori->id ? 'selected' : '' }}> {{$kategori->kategori_nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="dampak_nama" name="dampak_nama" required="required" class="form-control" value="{{ $item->dampak_nama }}">
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