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
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        padding: 20px;
        background-color: #f4f4f4;
    }

    #heatmap-risk {
        background-color: #ffffff;
        padding: 10px;
        border-radius: 8px;
    }

    /* Style untuk label anotasi */
    .apexcharts-point-annotation-label {
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
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

    /* Buat tabel lebih padat */
    .table-sm th,
    .table-sm td {
        padding: 4px 6px !important;
        font-size: 12px;
    }

    /* Ukuran kolom */
    .small-col {
        width: 20%;
    }

    .mid-col {
        width: 25%;
    }

    .tiny-col {
        width: 10%;
    }

    /* Bungkus teks biar gak meluber */
    td,
    th {
        white-space: normal !important;
        word-wrap: break-word;
        vertical-align: middle !important;
    }

    /* Teks lebih kecil dan rapi */
    .small-text {
        font-size: 12px;
        line-height: 1.3;
    }

    /* tombol rapi */
</style>

<div class="block-header">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- Nama Divisi mengikuti dari divisi user saat login -->
            <h2><b>Dashboard</b></h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                <li class="breadcrumb-item">Dashboard </li>

            </ul>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="d-flex flex-row-reverse">
                <div class="page_action">

                </div>

                <div class="p-2 d-flex">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">

    <div class="card">
        <div class="col-md-12 col-sm-12 ">

            <body data-theme="light" class="font-nunito">
                <div id="wrapper" class="theme-cyan">
                    <div class="block-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-2 mb-lg-0">
                                <h6 class="mb-0 font-weight-bold text-uppercase text-success">{{$organization_name}}</h6>
                            </div>

                            <div class="col-lg-9 col-md-12 col-sm-12">
                                {{-- FORM FILTER --}}
                                <form method="GET" action="{{ route('dashboard-divisi') }}"
                                    class="form-inline justify-content-end flex-wrap">

                                    @php
                                    $twLabel = [
                                    1 => 'Triwulan 1',
                                    2 => 'Triwulan 2',
                                    3 => 'Triwulan 3',
                                    4 => 'Triwulan 4'
                                    ];
                                    $twNow = $tw_now ?? 1;
                                    $thNow = $tahun_dash ?? date('Y');

                                    @endphp

                                    {{-- Filter Triwulan --}}
                                    <div class="form-group mr-2 mb-2">
                                        <label for="tw" class="mr-2 font-weight-bold">Triwulan</label>
                                        <select name="tw" id="tw" class="form-control form-control-sm " style="width:130px;">
                                            @foreach([1,2,3,4] as $tw)
                                            <option value="{{ $tw }}" {{ (int)$tw === (int)$twNow ? 'selected' : '' }}>
                                                {{ $twLabel[$tw] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Filter Tahun --}}
                                    <div class="form-group mr-2 mb-2">
                                        <label for="tahun" class="mr-2 font-weight-bold">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control form-control-sm" style="width:110px;">
                                            @foreach(range(date('Y'), 2020) as $year)
                                            <option value="{{ $year }}" {{ (string)$year === (string)$thNow ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Tombol Filter --}}
                                    <div class="form-group mb-2">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>

                                    &nbsp;
                                    <div class="form-group mb-2">
                                        <button type="button" class="btn btn-secondary btn-sm btn-print-laporan">
                                            <i class="fa fa-print"></i> Cetak Laporan
                                        </button>
                                    </div>

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

                <!-- Widget persentasi selesai pekerjaan  -->
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

            <!-- Risk Register Inhern  -->
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>EXPECTED MUJ</b></h2>
                        </div>
                        <div class="body">
                            <div id="heatmap-inhern-risk" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Risk Register Expected  -->
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>REALISASI MUJ</b></h2>
                        </div>
                        <div class="body">
                            <div id="heatmap-exp-risk" style="height: 500px"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>AVERAGE RESIKO</b></h2>
                        </div>
                        <div class="body">
                            <div id="average-risk-chart" style="height: 510px"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<!-- Risk Register Divisi  -->
<div class="row clearfix">
    <div class="card">
        <div class="col-md-12 col-sm-12 ">

            <body data-theme="light" class="font-nunito">
                <div id="wrapper" class="theme-cyan">
                    <div class="block-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h6 class="mb-0"><b>LIST RESIKO</b></h6>
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
                                <table id="datatable" class="table table-sm table-bordered table-hover" style="width:100%;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="align-middle text-center small-col">Nama Resiko</th>
                                            <th class="align-middle text-center tiny-col">Kriteria</th>
                                            <th class="align-middle text-center tiny-col">Exp<br>Nilai</th>
                                            <th class="align-middle text-center tiny-col">Exp<br>Kat</th>
                                            <!-- <th class="align-middle text-center mid-col">Realisasi</th> -->
                                            <th class="align-middle text-center tiny-col">Real<br>Nilai</th>
                                            <th class="align-middle text-center tiny-col">Real<br>Kat</th>
                                        </tr>
                                    </thead>

                                    @php
                                    $approvalId = $approvalDiv->first()->id ?? null;
                                    $item = $approvalId && isset($detailByApproval[$approvalId])
                                    ? $detailByApproval[$approvalId]
                                    : collect();
                                    @endphp

                                    <tbody>
                                        @forelse ($item as $index => $data)
                                        <tr>
                                            <td class="text-left small-text">{{ $data->resiko_nama }}</td>
                                            <td class="text-center">{{ $data->kategori_nama ?? '-' }}</td>
                                            <td class="text-right">{{ $data->inhern_nilai ?? '-' }}</td>
                                            <td class="text-center">{{ $data->inhern_bobot ?? '-' }}</td>
                                            <!-- <td class="text-left small-text">{{ $data->realisasi ?? '-' }}</td> -->
                                            <td class="text-right">{{ $data->exp_nilai ?? '-' }}</td>
                                            <td class="text-center">{{ $data->exp_bobot ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                                        </tr>
                                        @endforelse
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

<!-- Modal Print Preview -->
<div class="modal fade" id="modalPrintPreview" tabindex="-1" role="dialog" aria-labelledby="modalPrintPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold" id="modalPrintPreviewLabel">Print Preview Laporan Manajemen Risiko</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="print-preview-content" style="max-height: 80vh; overflow-y: auto;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-print-now"><i class="fa fa-print"></i> Print</button>
                <button type="button" class="btn btn-success btn-download-docx"><i class="fa fa-file-word"></i> Download DOCX</button>
            </div>
        </div>
    </div>
</div>

<form id="formExportDocx" action="{{ route('laporan.export.docx') }}" method="POST" enctype="multipart/form-data" target="_blank" style="display:none;">
    @csrf

    <input type="hidden" name="organization">
    <input type="hidden" name="periode">
    <input type="hidden" name="tahun">

    <!-- Input file untuk gambar -->
    <input type="file" name="riskRegisterImg">
    <input type="file" name="heatmapExpected">
    <input type="file" name="heatmapRealisasi">
    <input type="file" name="averageChart">
</form>

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

<!-- Bar Chart Divisi-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tahun = "{{ request('tahun', date('Y')) }}";
        const tw = "{{ request('tw', 1) }}";

        fetch(`/chart-divisi/{tahun?}=${tahun}&tw=${tw}`)
            .then(res => res.json())
            .then(data => {
                const options = {
                    chart: {
                        type: 'bar',
                        height: 400,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                            name: 'Nilai Inhern',
                            data: data.inhern,
                            color: '#9c27b0'
                        },
                        {
                            name: 'Nilai Expected',
                            data: data.exp,
                            color: '#f44336'
                        }
                    ],
                    xaxis: {
                        categories: data.labels,
                        labels: {
                            rotate: -45,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        y: {
                            formatter: (val, opts) => {
                                const idx = opts.dataPointIndex;
                                const series = opts.seriesIndex;
                                if (series === 0)
                                    return `${val} (${data.kategoriInhern[idx]})`;
                                else
                                    return `${val} (${data.kategoriExp[idx]})`;
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        strokeDashArray: 4
                    }
                };

                const chart = new ApexCharts(document.querySelector("#chart-bar-divisi"), options);
                chart.render();
            })
            .catch(err => console.error('Error load chart:', err));
    });
</script>

<!-- Heatmap INHERN: COUNT per sel D-K -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const m = @json($matrixInhern ?? []);
        const el = document.querySelector('#heatmap-inhern-risk');
        if (!el || !m) return;

        // Buat series dari matriks [d][k]
        function seriesFromMatrix(mat) {
            const series = [];
            for (let d = 1; d <= 5; d++) {
                const row = [];
                for (let k = 1; k <= 5; k++) {
                    const cnt = (mat?.[d]?.[k]) || 0;
                    row.push({
                        x: `K ${k}`,
                        y: d * k,
                        metaCount: cnt
                    }); // y utk pewarnaan (grid risiko)
                }
                series.push({
                    name: `D ${d}`,
                    data: row
                }); // D1 di atas, D5 di bawah (sesuai screenshot)
            }
            return series;
        }

        const options = {
            series: seriesFromMatrix(m),
            chart: {
                type: 'heatmap',
                height: 500,
                fontFamily: 'Arial, sans-serif'
            },
            plotOptions: {
                heatmap: {
                    enableShades: false,
                    colorScale: {
                        ranges: [{
                                from: 1,
                                to: 1,
                                name: 'VLR',
                                color: '#dce775'
                            },
                            {
                                from: 2,
                                to: 4,
                                name: 'LR',
                                color: '#8bc34a'
                            },
                            {
                                from: 5,
                                to: 9,
                                name: 'MR',
                                color: '#ffeb3b'
                            },
                            {
                                from: 10,
                                to: 16,
                                name: 'HR',
                                color: '#ff9800'
                            },
                            {
                                from: 17,
                                to: 25,
                                name: 'VHR',
                                color: '#ef5350'
                            },
                        ]
                    }
                }
            },
            title: {
                text: 'Expected Risk',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    const s = opts.w.config.series[opts.seriesIndex];
                    const dp = s.data[opts.dataPointIndex];
                    const c = dp.metaCount || 0;
                    return c > 0 ? String(c) : '';
                },
                style: {
                    colors: ['#1f2937'],
                    fontSize: '12px',
                    fontWeight: 600
                }
            },
            stroke: {
                width: 2,
                colors: ['#fff']
            },
            xaxis: {
                title: {
                    text: 'Kemungkinan',
                    style: {
                        fontWeight: 'bold'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Dampak',
                    style: {
                        fontWeight: 'bold'
                    }
                }
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: (val, {
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const d = seriesIndex + 1; // karena kita tidak membalik D
                        const k = dataPointIndex + 1;
                        const dp = w.config.series[seriesIndex].data[dataPointIndex];
                        return `D ${d} × K ${k} = ${val} | Count: ${dp.metaCount || 0}`;
                    }
                }
            }
        };

        new ApexCharts(el, options).render();
    });
</script>

<!-- Heatmap EXPECTED: COUNT per sel D-K -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const m = @json($matrixExp ?? []);
        const el = document.querySelector('#heatmap-exp-risk');
        if (!el || !m) return;

        function seriesFromMatrix(mat) {
            const series = [];
            for (let d = 1; d <= 5; d++) {
                const row = [];
                for (let k = 1; k <= 5; k++) {
                    const cnt = (mat?.[d]?.[k]) || 0;
                    row.push({
                        x: `K ${k}`,
                        y: d * k,
                        metaCount: cnt
                    });
                }
                series.push({
                    name: `D ${d}`,
                    data: row
                });
            }
            return series;
        }

        const options = {
            series: seriesFromMatrix(m),
            chart: {
                type: 'heatmap',
                height: 500,
                fontFamily: 'Arial, sans-serif'
            },
            plotOptions: {
                heatmap: {
                    enableShades: false,
                    colorScale: {
                        ranges: [{
                                from: 1,
                                to: 1,
                                name: 'VLR',
                                color: '#dce775'
                            },
                            {
                                from: 2,
                                to: 4,
                                name: 'LR',
                                color: '#8bc34a'
                            },
                            {
                                from: 5,
                                to: 9,
                                name: 'MR',
                                color: '#ffeb3b'
                            },
                            {
                                from: 10,
                                to: 16,
                                name: 'HR',
                                color: '#ff9800'
                            },
                            {
                                from: 17,
                                to: 25,
                                name: 'VHR',
                                color: '#ef5350'
                            },
                        ]
                    }
                }
            },
            title: {
                text: 'Realisasi Risk',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    const s = opts.w.config.series[opts.seriesIndex];
                    const dp = s.data[opts.dataPointIndex];
                    const c = dp.metaCount || 0;
                    return c > 0 ? String(c) : '';
                },
                style: {
                    colors: ['#1f2937'],
                    fontSize: '12px',
                    fontWeight: 600
                }
            },
            stroke: {
                width: 2,
                colors: ['#fff']
            },
            xaxis: {
                title: {
                    text: 'Kemungkinan',
                    style: {
                        fontWeight: 'bold'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Dampak',
                    style: {
                        fontWeight: 'bold'
                    }
                }
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: (val, {
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const d = seriesIndex + 1;
                        const k = dataPointIndex + 1;
                        const dp = w.config.series[seriesIndex].data[dataPointIndex];
                        return `D ${d} × K ${k} = ${val} | Count: ${dp.metaCount || 0}`;
                    }
                }
            }
        };

        new ApexCharts(el, options).render();
    });
</script>

<!-- Average chart -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const el = document.querySelector('#average-risk-chart');
        if (!el) return;

        // Data dari backend (controller Laravel)
        // Bentuk data: [{triwulan: 1, inhern_avg: 8.5, exp_avg: 6.2}, ...]
        const data = @json($averageRisk ?? []);

        // Siapkan data untuk chart
        const triwulanLabels = ['Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV'];
        const inhernSeries = [];
        const expectedSeries = [];

        for (let i = 1; i <= 4; i++) {
            const item = data.find(d => d.triwulan == i);
            inhernSeries.push(item ? parseFloat(item.inhern_avg) : 0);
            expectedSeries.push(item ? parseFloat(item.exp_avg) : 0);
        }

        const options = {
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: false
                },
                fontFamily: 'Arial, sans-serif'
            },
            title: {
                text: 'Average Risk',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            },
            xaxis: {
                categories: triwulanLabels,
                title: {
                    text: 'Triwulan',
                    style: {
                        fontWeight: 'bold'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Rata-rata',
                    style: {
                        fontWeight: 'bold'
                    }
                },
                min: 0
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 5
            },
            colors: ['#e74c3c', '#3498db'],
            series: [{
                    name: 'Exp Risk',
                    data: inhernSeries
                },
                {
                    name: 'Real Risk',
                    data: expectedSeries
                }
            ],
            dataLabels: {
                enabled: true,
                formatter: val => val.toFixed(1)
            },
            tooltip: {
                y: {
                    formatter: val => `Rata-rata: ${val.toFixed(0)}`
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            }
        };

        new ApexCharts(el, options).render();
    });
</script>

<!-- print preview -->
<!-- Dependency -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const btnCetak = document.querySelector(".btn-print-laporan");
        const modal = $("#modalPrintPreview");
        const modalBody = document.getElementById("print-preview-content");

        const btnDownload = document.querySelector(".btn-download-docx");
        const btnPrintNow = document.querySelector(".btn-print-now");

        const ORG_NAME = "{{ $organization_name ?? 'Divisi Anda' }}";

        // ======================================================
        // FUNCTION: Capture HTML element → Blob PNG
        // ======================================================
        async function captureBlob(id) {
            const el = document.getElementById(id);

            if (!el) {
                const canvas = document.createElement("canvas");
                canvas.width = 10;
                canvas.height = 10;
                return await new Promise(resolve => canvas.toBlob(resolve, "image/png"));
            }

            const canvas = await html2canvas(el, {
                scale: 2
            });
            return await new Promise(resolve => canvas.toBlob(resolve, "image/png"));
        }

        // ======================================================
        // 1. Buka Modal Print Preview
        // ======================================================
        btnCetak.addEventListener("click", () => {

            const triwulanText =
                document.querySelector('select[name="tw"] option:checked')?.textContent || "Triwulan I";

            const tahunText =
                document.querySelector('select[name="tahun"]')?.value || new Date().getFullYear();

            const htmlTable = document.querySelector(".table.table-bordered")?.outerHTML || "<p>Tidak ada data</p>";
            const htmlHeatmapExpected = document.getElementById("heatmap-inhern-risk")?.outerHTML || "<p>Tidak ada data</p>";
            const htmlHeatmapRealisasi = document.getElementById("heatmap-exp-risk")?.outerHTML || "<p>Tidak ada data</p>";
            const htmlAverage = document.getElementById("average-risk-chart")?.outerHTML || "<p>Tidak ada data</p>";

            modalBody.innerHTML = `
            <div id="laporanPrintArea" style="font-family:Arial; line-height:1.5; font-size:11pt;">
                <h4 style="text-align:center"><b>LAPORAN MANAJEMEN RISIKO - ${ORG_NAME}</b></h4>
                <p style="text-align:center">Periode: ${triwulanText} Tahun ${tahunText}</p>
                <p style="text-align:center">Penyusun: ${ORG_NAME}</p>

                <h5><b>1. Profil Risiko Unit Kerja</b></h5>
                <p><b>a. Risk Register</b></p>
                <div id="riskRegisterContainer">${htmlTable}</div>

                <p><b>b. Peta Risiko</b></p>
                <div style="display:flex; gap:15px;">
                    <div id="heatmapExpectedWrapper" style="width:49%">${htmlHeatmapExpected}</div>
                    <div id="heatmapRealisasiWrapper" style="width:49%">${htmlHeatmapRealisasi}</div>
                </div>

                <p><b>c. Trend Perubahan Risiko</b></p>
                <div id="averageChartContainer">${htmlAverage}</div>

                <br>
                <h5><b>2. Peristiwa Risiko</b></h5> <p>(Diisi oleh Divisi terkait)</p>
                <h5><b>3. Kejadian Luar Biasa</b></h5> <p>(Diisi oleh Divisi terkait)</p>
                <h5><b>4. Produk Aktivitas Baru</b></h5> <p>(Diisi oleh Divisi terkait)</p>

                <br><br>
                <table style="width:100%; text-align:center;">
                    <tr>
                        <td><b>Disusun oleh,</b></td>
                        <td><b>Disetujui oleh,</b></td>
                    </tr>
                    <tr><td style="height:60px"></td><td></td></tr>
                    <tr>
                        <td><u>Kepala ${ORG_NAME}</u></td>
                        <td><u>Kepala Divisi Manajemen Risiko</u></td>
                    </tr>
                </table>
            </div>
        `;

            modal.modal("show");
        });

        // ======================================================
        // 2. DOWNLOAD DOCX via HIDDEN FORM (ANTI 403 SERVER)
        // ======================================================
        btnDownload.addEventListener("click", async () => {

            btnDownload.disabled = true;
            btnDownload.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

            try {
                // Capture image blobs
                const riskRegisterBlob = await captureBlob("riskRegisterContainer");
                const heatmapExpectedBlob = await captureBlob("heatmapExpectedWrapper");
                const heatmapRealisasiBlob = await captureBlob("heatmapRealisasiWrapper");
                const averageBlob = await captureBlob("averageChartContainer");

                const triwulanText = document.querySelector('select[name="tw"] option:checked')?.textContent;
                const tahunText = document.querySelector('select[name="tahun"]')?.value;

                const form = document.getElementById("formExportDocx");

                // Set text fields
                form.organization.value = ORG_NAME;
                form.periode.value = triwulanText;
                form.tahun.value = tahunText;

                // Convert blob → File untuk input file
                function assignFile(input, blob, name) {
                    const dt = new DataTransfer();
                    dt.items.add(new File([blob], name, {
                        type: "image/png"
                    }));
                    input.files = dt.files;
                }

                assignFile(form.riskRegisterImg, riskRegisterBlob, "risk.png");
                assignFile(form.heatmapExpected, heatmapExpectedBlob, "expected.png");
                assignFile(form.heatmapRealisasi, heatmapRealisasiBlob, "realisasi.png");
                assignFile(form.averageChart, averageBlob, "average.png");

                // Submit → Browser auto-download (AMAN DI SERVER)
                form.submit();

            } catch (e) {
                console.error(e);
                alert("Gagal membuat file DOCX.");
            }

            btnDownload.disabled = false;
            btnDownload.innerHTML = '<i class="fa fa-file-word"></i> Download DOCX';
        });

        // ======================================================
        // 3. PRINT
        // ======================================================
        btnPrintNow.addEventListener("click", () => {
            const area = document.getElementById("laporanPrintArea");
            const win = window.open("", "_blank");

            win.document.write(`
            <html>
            <head><title>Print</title><style>body{font-family:Arial}</style></head>
            <body>${area.innerHTML}</body>
            </html>
        `);

            win.document.close();
            win.print();
        });

    });
</script>

@endpush