@extends('layout.admin')
@section('content')

<style>
    /* Paksa semua tabel (utama & nested) stabil + wrap teks */
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }

    .table-fixed th,
    .table-fixed td {
        vertical-align: middle;
        white-space: normal !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
    }

    /* Lebar kolom level-atas (tahun / konten) */
    .col-year-10 {
        width: 10%;
    }

    .col-wide-90 {
        width: 90%;
    }

    /* Lebar kolom nested tingkat 1–3 */
    .col-20 {
        width: 20%;
    }

    .col-80 {
        width: 80%;
    }

    /* Lebar kolom nested paling dalam (list resiko) – total = 100% */
    .col-kategori {
        width: 20%;
    }

    .col-nama {
        width: 30%;
    }

    .col-penyebab {
        width: 35%;
    }

    .col-action15 {
        width: 15%;
        text-align: center;
    }

    .col-action15 .btn {
        margin: 2px;
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

                        <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-fixed" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-middle text-center" style="width: 5%;">Tahun</th>
                                    <th class="align-middle text-center" style="width: 95%;">Daftar Dampak</th>
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
                                                    <th class="align-middle text-center" style="width: 15%;">Kategori</th>
                                                    <th class="align-middle text-center" style="width: 85%;">Dampak Kategori</th>


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
                                                                    <th class="align-middle text-center" style="width: 10%;">Level</th>
                                                                    <th class="align-middle text-center" style="width: 75%;">Nama Dampak</th>
                                                                    <th class="align-middle text-center" style="width: 15%;">Action</th>
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
                            <select name="tahun" id="tahun_input" class="form-control" style="height: 34px;">
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
                                <option value="" disabled selected>Pilih Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <textarea id="dampak_nama" name="dampak_nama" rows="3" required="required" class="form-control"></textarea>
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
<div class="modal fade edit-modal" id="editModal{{$item->id}}" tabindex="1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
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
                            <select class="form-control tahun-edit" name="tahun" data-id="{{ $item->id }}" required>
                                <option value="" disabled>Pilih Tahun</option>
                                @foreach(range(date('Y'), 2020) as $year)
                                <option value="{{ $year }}"
                                    {{ $item->tahun == $year ? 'selected' : '' }}> {{ $year }}
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
                            <select class="form-control kategori-edit" name="kategori_id" data-selected="{{ $item->kategori_id }}" required>
                                <option disabled selected>Loading...</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-form-label col-md-2 col-sm-3 label-align text-right">Dampak<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8">
                            <textarea id="dampak_nama" name="dampak_nama" rows="3" required="required" class="form-control">{{ $item->dampak_nama }}</textarea>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tahunSelect = document.getElementById('tahun_input');
        const kategoriSelect = document.getElementById('kategori_id');

        function loadKategori(tahun) {
            kategoriSelect.innerHTML = '<option disabled selected>Loading...</option>';

            fetch(`/kategori-by-tahun/${tahun}`)
                .then(res => res.json())
                .then(data => {
                    kategoriSelect.innerHTML = '<option disabled selected>Pilih Kategori</option>';

                    if (data.length === 0) {
                        kategoriSelect.innerHTML += '<option disabled>Tidak ada kategori</option>';
                        return;
                    }

                    data.forEach(item => {
                        kategoriSelect.innerHTML += `
                        <option value="${item.id}">
                            ${item.kategori_nama}
                        </option>
                    `;
                    });
                })
                .catch(() => {
                    kategoriSelect.innerHTML = '<option disabled>Gagal memuat kategori</option>';
                });
        }

        // 🔹 Saat tahun berubah
        tahunSelect.addEventListener('change', function() {
            loadKategori(this.value);
        });

        // 🔹 Saat halaman pertama kali dibuka
        if (tahunSelect.value) {
            loadKategori(tahunSelect.value);
        }

    });
</script>

<script>
    function loadKategoriEdit(tahun, kategoriSelect, selectedId = null) {

        kategoriSelect.innerHTML = '<option disabled selected>Loading...</option>';

        fetch(`/kategori-by-tahun/${tahun}`)
            .then(res => res.json())
            .then(data => {

                kategoriSelect.innerHTML = '<option disabled>Pilih Kategori</option>';

                if (data.length === 0) {
                    kategoriSelect.innerHTML += '<option disabled>Tidak ada kategori</option>';
                    return;
                }

                data.forEach(item => {
                    const selected = selectedId == item.id ? 'selected' : '';
                    kategoriSelect.innerHTML += `
                    <option value="${item.id}" ${selected}>
                        ${item.kategori_nama}
                    </option>
                `;
                });
            })
            .catch(() => {
                kategoriSelect.innerHTML = '<option disabled>Gagal memuat kategori</option>';
            });
    }
</script>

<script>
    $('.edit-modal').on('shown.bs.modal', function() {

        const modal = $(this);

        const tahunSelect = modal.find('.tahun-edit')[0];
        const kategoriSelect = modal.find('.kategori-edit')[0];

        if (!tahunSelect || !kategoriSelect) return;

        const selectedKategori = kategoriSelect.dataset.selected;

        // 🔹 Load pertama kali
        loadKategoriEdit(tahunSelect.value, kategoriSelect, selectedKategori);

        // 🔹 Jika tahun diganti
        tahunSelect.addEventListener('change', function() {
            loadKategoriEdit(this.value, kategoriSelect, null);
        });

    });
</script>
@endpush