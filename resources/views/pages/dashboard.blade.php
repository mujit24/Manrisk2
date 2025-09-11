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
    /* Sticky Columns */
    .sticky-col {
        position: sticky;
        background-color: white;
        z-index: 2;
    }

    .left-col-0 {
        left: 0;
        z-index: 3;
    }

    .left-col-1 {
        left: 180px;
    }

    .left-col-2 {
        left: 360px;
    }

    .left-col-3 {
        left: 540px;
    }

    /* Sticky TH fix */
    thead .sticky-col {
        background-color: rgb(87, 91, 96) !important;
        color: white !important;
        z-index: 4;
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
            <h2><b>DASHBOARD MANAJEMEN RESIKO MUJ</b></h2>
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
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h6 class="mb-0"><b>MONITORING RESIKO</b></h6>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form method="GET" action="{{ route('dashboard') }}" class="d-flex justify-content-end align-items-center">
                                    <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                    <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                        @foreach(range(date('Y'), 2020) as $year)
                                        <option value="{{ $year }}" {{ $year == $tahun_dash ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
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

                <!-- Widget Laba Kotor -->
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

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><b>RISK REGISTER DIVISI</b></h2>
                        </div>
                        <div class="body">
                            <div id="chart-bar-divisi" style="height: 24rem"></div>
                        </div>
                    </div>
                </div>
            </div>

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

<div class="row clearfix">
    <div class="card">
        <div class="col-md-12 col-sm-12 ">

            <body data-theme="light" class="font-nunito">
                <div id="wrapper" class="theme-cyan">
                    <div class="block-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h6 class="mb-0"><b>LIST RESIKO TERBESAR</b></h6>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <form method="GET" action="{{ route('dashboard-list-divisi') }}" class="d-flex justify-content-end align-items-center">
                                    <label for="tahun" class="mb-0 mr-2"><b>Tahun</b></label>
                                    <select name="tahun" id="tahun" class="form-control" style="width: 100px;" onchange="this.form.submit()">
                                        @foreach(range(date('Y'), 2020) as $year)
                                        <option value="{{ $year }}" {{ $year == $tahun_dash ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
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
                                            <th class="align-middle text-center" style="width: 15%;">Divisi</th>
                                            <th class="align-middle text-center" style="width: 75%;">Daftar Monitoring Resiko</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedDataResiko_monitoring as $key => $listResiko)

                                        @php
                                        [$tahun, $divisi] = explode('|', $key);
                                        @endphp

                                        <tr>
                                            <td class="align-middle text-center">{{ $tahun }}</td>
                                            <td class="align-middle text-center">{{ $divisi }}</td>
                                            <td>
                                                <table class="table table-bordered m-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center sticky-col left-col-0">Nama Resiko</th>
                                                            <th class="text-center sticky-col left-col-1">Kategori Resiko</th>
                                                            <th class="text-center">Nilai Inhern</th>
                                                            <th class="text-center">Kategori Inhern</th>
                                                            <th class="text-center">Penngendalian Resiko</th>
                                                            <th class="text-center">Nilai Expected</th>
                                                            <th class="text-center">Kategori Expected</th>
                                                            <th class="text-center">Status</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($listResiko->filter(function ($resiko) use ($listpengukuran) {
                                                        $item_pengukuran = $listpengukuran->get($resiko->id);
                                                        return $item_pengukuran && $item_pengukuran->inhern_nilai >= 10;
                                                        }) as $resiko)

                                                        @php
                                                        $item = $listmonitoring->get($resiko->id);
                                                        $item_pengendalian = $listpengendalian->get($resiko->id);
                                                        $item_pengukuran = $listpengukuran->get($resiko->id);
                                                        @endphp

                                                        <tr>
                                                            <td>{{ $resiko->resiko_nama }}</td>
                                                            <td>{{ $resiko->namaKategori->kategori_nama ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengukuran->inhern_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $item_pengukuran->namaBobotInhern->bobot_kategori ?? '-' }}</td>
                                                            <td class="text-left">{{ $item_pengendalian->rencana ?? '-' }}</td>
                                                            <td class="text-right">{{ $item_pengendalian->exp_nilai ?? '-' }}</td>
                                                            <td class="text-center">{{ $item_pengendalian->namaBobotExp->bobot_kategori ?? '-' }}</td>
                                                            <td class="text-center">{{ $item->status_mitigasi ?? '-' }}</td>

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
        fetch("{{ route('chart.divisi', ['tahun' => request('tahun', date('Y'))]) }}")
            .then(response => response.json())
            .then(data => {
                var options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        stacked: false
                    },
                    series: [{
                        name: 'Nilai Inhern',
                        data: data.inhern
                    }, {
                        name: 'Nilai Exp',
                        data: data.exp
                    }],
                    xaxis: {
                        categories: data.labels
                    },
                    tooltip: {
                        y: {
                            formatter: function(val, opts) {
                                var seriesIndex = opts.seriesIndex;
                                var dataIndex = opts.dataPointIndex;
                                if (seriesIndex === 0) {
                                    return val + " (" + data.kategoriInhern[dataIndex] + ")";
                                } else if (seriesIndex === 1) {
                                    return val + " (" + data.kategoriExp[dataIndex] + ")";
                                }
                                return val;
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart-bar-divisi"), options);
                chart.render();
            });
    });
</script>


<!-- Bar Chart Heat Map Inhern-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($data_inhern ?? []);
        const el = document.querySelector("#heatmap-inhern-risk");
        if (!el) return;

        // --- helper ---
        const clamp15 = n => Math.max(1, Math.min(5, n));
        const toInt = (v, fb = 0) => Number.isFinite(+v) ? parseInt(v, 10) : fb;
        const toFloat = (v, fb = 0) => {
            const f = parseFloat(v);
            return Number.isFinite(f) ? f : fb;
        };

        // --- mapper singkatan kategori ---
        const kategoriMap = {
            "Keuangan": "K",
            "Operasional": "O",
            "Reputasi": "R",
            "Lingkungan Sosial": "L",
            "Hukum": "H"
        };

        // --- Bangun peta label per sel: key "D-K" -> array label ---
        const cellLabelMap = {};
        data.forEach(row => {
            const d = clamp15(toInt(row.dampak_avg_rounded, Math.round(toFloat(row.rata_dampak_inhern, 0))));
            const k = clamp15(toInt(row.kemungkinan_avg_rounded, Math.round(toFloat(row.rata_kemungkinan_inhern, 0))));
            const key = `${d}-${k}`;

            let kategori = String(row.kategori ?? '').trim();
            if (!kategori) return;

            const short = kategoriMap[kategori] || kategori;
            const rataInhern = Number.isFinite(+row.rata_inhern) ? Math.round(+row.rata_inhern) : (d * k);

            if (!cellLabelMap[key]) cellLabelMap[key] = [];
            cellLabelMap[key].push(`${short} (${rataInhern})`);
        });

        // --- Grid heatmap 5x5 ---
        function generateHeatmapData() {
            const series = [];
            for (let i = 1; i <= 5; i++) {
                const dataPoints = [];
                for (let j = 1; j <= 5; j++) {
                    dataPoints.push({
                        x: `K ${j}`,
                        y: i * j
                    });
                }
                series.push({
                    name: `D ${i}`,
                    data: dataPoints
                });
            }
            return series.reverse(); // Dampak 5 di atas
        }

        const options = {
            series: generateHeatmapData(),
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
                            }
                        ]
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    const sIdx = opts.seriesIndex;
                    const dpIdx = opts.dataPointIndex;
                    const dampak = 5 - sIdx;
                    const kemungkinan = dpIdx + 1;
                    const key = `${dampak}-${kemungkinan}`;

                    const labels = cellLabelMap[key];
                    if (!labels || labels.length === 0) return "";

                    labels.sort((a, b) => a.localeCompare(b));

                    // pakai simbol " | " antar kategori
                    return labels.join(" | ");
                },
                style: {
                    colors: ['#1f2937'],
                    fontSize: '10px',
                    fontWeight: 300
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
                enabled: true
            }
        };

        new ApexCharts(el, options).render();
    });
</script>

<!-- Bar Chart Heat Map Expected-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const data = @json($data_expected ?? []);
        const el = document.querySelector("#heatmap-exp-risk");
        if (!el) return;

        // --- helper ---
        const clamp15 = n => Math.max(1, Math.min(5, n));
        const toInt = (v, fb = 0) => Number.isFinite(+v) ? parseInt(v, 10) : fb;
        const toFloat = (v, fb = 0) => {
            const f = parseFloat(v);
            return Number.isFinite(f) ? f : fb;
        };

        // --- mapper singkatan kategori ---
        const kategoriMap = {
            "Keuangan": "K",
            "Operasional": "O",
            "Reputasi": "R",
            "Lingkungan Sosial": "L",
            "Hukum": "H"
        };

        // --- Bangun peta label per sel: key "D-K" -> array label ---
        const cellLabelMap = {};
        data.forEach(row => {
            const d = clamp15(
                toInt(row.dampak_exp_rounded, Math.round(toFloat(row.rata_dampak_exp, 0)))
            );
            const k = clamp15(
                toInt(row.kemungkinan_exp_rounded, Math.round(toFloat(row.rata_kemungkinan_exp, 0)))
            );
            const key = `${d}-${k}`;

            let kategori = String(row.kategori ?? '').trim();
            if (!kategori) return;

            const short = kategoriMap[kategori] || kategori;
            // rata_exp dari backend; fallback ke d*k jika belum ada
            const rataExp = Number.isFinite(+row.rata_exp) ?
                Math.round(+row.rata_exp) :
                (d * k);

            if (!cellLabelMap[key]) cellLabelMap[key] = [];
            cellLabelMap[key].push(`${short} (${rataExp})`);
        });

        // --- Grid heatmap 5x5 ---
        function generateHeatmapData() {
            const series = [];
            for (let i = 1; i <= 5; i++) {
                const dataPoints = [];
                for (let j = 1; j <= 5; j++) {
                    dataPoints.push({
                        x: `K ${j}`,
                        y: i * j
                    });
                }
                series.push({
                    name: `D ${i}`,
                    data: dataPoints
                });
            }
            return series.reverse(); // Dampak 5 di atas
        }

        const options = {
            series: generateHeatmapData(),
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
                            }
                        ]
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    const sIdx = opts.seriesIndex;
                    const dpIdx = opts.dataPointIndex;
                    const dampak = 5 - sIdx;
                    const kemungkinan = dpIdx + 1;
                    const key = `${dampak}-${kemungkinan}`;

                    const labels = cellLabelMap[key];
                    if (!labels || labels.length === 0) return "";

                    labels.sort((a, b) => a.localeCompare(b));
                    // pakai simbol " | " antar kategori
                    return labels.join(" | ");
                },
                style: {
                    colors: ['#1f2937'],
                    fontSize: '10px',
                    fontWeight: 300
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
                enabled: true
            }
        };

        new ApexCharts(el, options).render();
    });
</script>






@endpush