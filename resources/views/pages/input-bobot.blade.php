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
                                <i class="fa fa-plus"></i>&nbsp;INPUT BOBOT
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
                                    <th class="align-middle text-center">Daftar Bobot</th>
                                    <th class="align-middle text-center">Tabel Bobot</th>
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
                                                    <th class="align-middle text-center">Bobot Nilai</th>
                                                    <th class="align-middle text-center">Bobot Kategori</th>
                                                    <th class="align-middle text-center">Bobot Warna</th>
                                                    <th class="align-middle text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataTahun as $item)
                                                <tr>
                                                    <td>{{ $item->bobot_nilai }}</td>
                                                    <td>{{ $item->bobot_kategori }}</td>
                                                    <td class="align-middle text-center">
                                                        @php
                                                        $color = match(strtolower($item->bobot_kategori)) {
                                                        'very low risk' => '#00FF00', // hijau muda
                                                        'low risk' => '#008000', // hijau tua
                                                        'medium risk' => '#ffff00', // kuning
                                                        'high risk' => '#fd7e14', // oranye
                                                        'very high risk'=> '#8B0000', // merah
                                                        default => '#ffffff' // putih/default
                                                        };
                                                        @endphp

                                                        <div style="width: 30px; height: 30px; background-color: {{ $color }}; border: 1px solid #ccc; margin: auto; border-radius: 4px;"></div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{$item->id}}" data-id="{{$item->id}}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="input-bobot-delete/{{$item->id}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Akan Menghapus Data?');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-center">
                                            <table class="table table-bordered text-center" style="max-width: 700px; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle" style="background-color:#555; color:#fff;" rowspan="2">PEMBOBOTAN RISIKO</th>
                                                        <th colspan="5">DAMPAK (D)</th>
                                                    </tr>
                                                    <tr>
                                                        @for ($d = 1; $d <= 5; $d++)
                                                            <th>{{ $d }}</th>
                                                            @endfor
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($p = 1; $p <= 5; $p++)
                                                        <tr>

                                                        <td><strong>K{{ $p }}</strong></td>
                                                        @for ($d = 1; $d <= 5; $d++)
                                                            @php
                                                            $nilai=$d * $p;
                                                            $kategori=$bobotKategoriMap[$nilai] ?? 'Unknown' ;

                                                            // Singkatan
                                                            $singkatan=[ 'Very Low Risk'=> 'VLR',
                                                            'Low Risk' => 'LR',
                                                            'Medium Risk' => 'MR',
                                                            'High Risk' => 'HR',
                                                            'Very High Risk' => 'VHR',
                                                            ];
                                                            $label = $singkatan[$kategori] ?? $kategori;

                                                            // Warna
                                                            $bgColor = match ($kategori) {
                                                            'Very Low Risk' => '#00FF00',
                                                            'Low Risk' => '#008000',
                                                            'Medium Risk' => '#FFFF00',
                                                            'High Risk' => '#FF8C00',
                                                            'Very High Risk' => '#8B0000',
                                                            default => '#CCC',
                                                            };
                                                            $textColor = in_array($kategori, ['Low Risk', 'Very Low Risk', 'Medium Risk']) ? '#000' : '#fff';
                                                            @endphp
                                                            <td style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                                                                <strong>{{ $label }} ({{ $nilai }})</strong>
                                                            </td>
                                                            @endfor
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>


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
<div class="modal fade" id="inputModal" aria-labelledby="modalInputBobot" aria-hidden="true">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/input-bobot-add" method="POST" enctype="multipart/form-data">
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
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Nilai<span class="required"></span></label>
                        <div class="col-md-4 col-sm-4">
                            <input type="number" min="0" max="25" step="1" id="bobot_nilai" name="bobot_nilai" required="required" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Kategori<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <select class="form-control" id="bobot_kategori" name="bobot_kategori" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                <option value="Very Low Risk">Very Low Risk</option>
                                <option value="Low Risk">Low Risk</option>
                                <option value="Medium Risk">Medium Risk</option>
                                <option value="High Risk">High Risk</option>
                                <option value="Very High Risk">Very High Risk</option>
                            </select>
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

@foreach ($listbobot as $item)
<div class="modal fade" id="editModal{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$item->id}}">Edit Bobot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('input-bobot-update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Nilai<span class="required"></span></label>
                        <div class="col-md-4 col-sm-4">
                            <input type="number" min="0" max="25" step="1" id="bobot_nilai" name="bobot_nilai" required="required" class="form-control" value="{{ $item->bobot_nilai }}">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-3 col-sm-4 label-align text-right">Kategori<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <select class="form-control" id="bobot_kategori" name="bobot_kategori">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach([
                                'Very Low Risk',
                                'Low Risk',
                                'Medium Risk',
                                'High Risk',
                                'Very High Risk',
                                ] as $bobot_kategori)
                                <option value="{{ $bobot_kategori }}" {{ $item->bobot_kategori == $bobot_kategori ? 'selected' : '' }}>{{ $bobot_kategori }}</option>
                                @endforeach
                            </select>
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