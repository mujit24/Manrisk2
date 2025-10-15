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

<div class="block-header">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- Nama Divisi mengikuti dari divisi user saat login -->
            <h2><b>Dashboard {{$organization_name}}</b></h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                <li class="breadcrumb-item">Dashboard</li>

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
                                <h6 class="mb-0 font-weight-bold text-uppercase text-success">DASHBOARD</h6>
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
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>INHERN MUJ</b></h2>
                        </div>
                        <div class="body">
                            <div id="heatmap-inhern-risk" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Risk Register Expected  -->
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>EXPECTED MUJ</b></h2>
                        </div>
                        <div class="body">
                            <div id="heatmap-exp-risk" style="height: 500px"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Risk Register Top 20  -->
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
                                <table id="datatable" class="table table-bordered table-hover js-basic-example dataTable table-custom" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                        <tr>
                                            <th class="align-middle text-center" style="width: 10%;">Tahun</th>
                                            <th class="align-middle text-center" style="width: 75%;">Daftar Monitoring Resiko</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedDataResiko_monitoring as $key => $listResiko)
                                        @php
                                        $parts = explode('|', $key);
                                        [$tahunRow, $divisi_nama, $divisi_id, $app_name] = array_pad($parts, 4, null);
                                        @endphp
                                        <tr>
                                            <td class="align-middle text-center">{{ $tahunRow }}</td>

                                            <td>
                                                <table class="table table-bordered m-0">
                                                    <thead>
                                                        <tr>

                                                            <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                            <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                            <th class="text-center">Penyebab Resiko</th>
                                                            <th class="text-center">Dampak</th>
                                                            <th class="text-center">Strategi</th>
                                                            <th class="text-center">Prosedur</th>
                                                            <th class="text-center">Level Inh</th>
                                                            <th class="text-center">Dampak Inh</th>
                                                            <th class="text-center">Nilai Inh</th>
                                                            <th class="text-center">Kategori Inh</th>
                                                            <th class="text-center">Pengendalian Risiko</th>
                                                            <th class="text-center">Level Exp</th>
                                                            <th class="text-center">Dampak Exp</th>
                                                            <th class="text-center">Nilai Exp</th>
                                                            <th class="text-center">Kategori Exp</th>
                                                            <th class="text-center">PIC</th>
                                                            <th class="text-center">Jangka Waktu</th>
                                                            <th class="text-center">Peluang perbaikan</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Evidence</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($listResiko as $d)
                                                        <tr>
                                                            <td class="text-left">{{ $d->resiko_nama }}</td>
                                                            <td class="text-left">{{ $d->kategori_nama ?? '-' }}</td>

                                                            <td class="text-left">{{ $d->resiko_penyebab }}</td>
                                                            <td class="text-left">{{ $d->dampak ?? '-' }}</td>
                                                            <td class="text-left">{{ $d->strategi }}</td>
                                                            <td class="text-left">{{ $d->prosedur ?? '-' }}</td>

                                                            <td class="text-right">{{ $d->inhern_dampak ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->inhern_kemungkinan ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->inhern_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $d->inhern_bobot ?? '-' }}</td>

                                                            <td class="text-left">{{ $d->rencana ?? '-' }}</td>

                                                            <td class="text-right">{{ $d->exp_dampak ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->exp_kemungkinan ?? '-' }}</td>
                                                            <td class="text-right">{{ $d->exp_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $d->exp_bobot ?? '-' }}</td>

                                                            <td class="text-left">{{ $d->pic ?? '-' }}</td>
                                                            <td class="text-left">{{ $d->jangka_waktu }}</td>
                                                            <td class="text-left">{{ $d->peluang_perbaikan ?? '-' }}</td>
                                                            <td class="text-left">{{ $d->status_mitigasi }}</td>
                                                            <td class="text-left">{{ $d->keterangan ?? '-' }}</td>
                                                            <td class="text-left">{{ $d->evidence ?? '-' }}</td>

                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center text-muted">Tidak ada data.</td>
                                                        </tr>
                                                        @endforelse
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

@endpush