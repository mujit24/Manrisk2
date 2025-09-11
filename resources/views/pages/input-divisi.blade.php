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
                                <i class="fa fa-plus"></i>&nbsp;INPUT DIVISI
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
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($listdivisi as $item)
                                <tr>
                                    <td>{{$item->nama_divisi}}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$item->id}}" data-id="{{$item->id}}"><i class="fa fa-edit"></i></a>
                                        <a href="input-divisi-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
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
<div class="modal fade" id="inputModal" aria-labelledby="modalInputDivisi" aria-hidden="true">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/input-divisi-add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Nama Divisi<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="nama_divisi" name="nama_divisi" required="required" class="form-control">
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

@foreach ($listdivisi as $item)
<div class="modal fade" id="editModal{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$item->id}}">Edit Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('input-divisi-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Nama Divisi<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" id="nama_divisi" name="nama_divisi" required="required" class="form-control" value="{{ $item->nama_divisi }}">
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