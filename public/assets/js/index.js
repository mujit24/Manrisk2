$(function () {
    "use strict";

    $(".sparkbar").sparkline("html", { type: "bar" });

    // Total Revenue
    $(document).ready(function () {
        var options = {
            chart: {
                height: 300,
                type: "line",
                toolbar: {
                    show: false,
                },
            },
            colors: ["#59c4bc", "#637aae"],
            series: [
                {
                    name: "Pendapatan",
                    type: "column",
                    data: pendapatanArray,
                },
                {
                    name: "Target",
                    type: "line",
                    data: targetArray,
                },
            ],
            stroke: {
                width: [0, 4],
            },

            xaxis: {
                type: "category",
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
            },
            yaxis: [
                {
                    title: {
                        text: "Pendapatan",
                    },
                    labels: {
                        formatter: function (value) {
                            return formatRupiah(value);
                        },
                    },
                },
                {
                    opposite: true,
                    title: {
                        text: "Target",
                    },
                    labels: {
                        formatter: function (value) {
                            return formatRupiah(value);
                        },
                    },
                },
            ],
        };
        var chart = new ApexCharts(
            document.querySelector("#apex-chart-line-column"),
            options
        );

        chart.render();

        function formatRupiah(angka, prefix) {
            // Pastikan angka dalam bentuk string
            angka = angka.toString().replace(/[^0-9.-]/g, "");
            // Pisahkan angka menjadi integer dan decimal jika ada
            var split = angka.split(".");
            var integerPart = split[0]; // Bagian sebelum koma
            var decimalPart = split[1] ? split[1].substring(0, 2) : ""; // Bagian setelah koma, hanya ambil 2 digit

            // Format bagian integer dengan ribuan
            var sisa = integerPart.length % 3;
            var rupiah = integerPart.substr(0, sisa);
            var ribuan = integerPart.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                var separator = sisa ? "," : "";
                rupiah += separator + ribuan.join(",");
            }

            // Gabungkan bagian decimal jika ada
            rupiah = decimalPart ? rupiah + "." + decimalPart : rupiah;

            // Handle untuk angka negatif
            if (angka.includes("-")) {
                rupiah = "-" + rupiah;
            }

            return prefix === undefined
                ? rupiah
                : rupiah
                ? "Rp. " + rupiah
                : "";
        }
    });

    // Gender-Ratio
    $(document).ready(function () {
        var chart = c3.generate({
            bindto: "#Gender-Ratio", // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ["data1", 90],
                    ["data2", 10],
                ],
                type: "donut", // default type of chart
                colors: {
                    data1: Iconic.colors["theme-cyan1"],
                    data2: Iconic.colors["theme-cyan2"],
                },
                names: {
                    // name of each serie
                    data1: "Kontrak 1",
                    data2: "Kontrak 2",
                },
            },
            axis: {},
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0,
            },
        });
    });

    // Gender-Ratio2
    $(document).ready(function () {
        var chart = c3.generate({
            bindto: "#Gender-Ratio2", // id of chart wrapper
            data: {
                columns: [
                    // each columns data
                    ["data1", 90],
                    ["data2", 10],
                ],
                type: "donut", // default type of chart
                colors: {
                    data1: Iconic.colors["theme-cyan1"],
                    data2: Iconic.colors["theme-cyan2"],
                },
                names: {
                    // name of each serie
                    data1: "Kontrak 1",
                    data2: "Kontrak 2",
                },
            },
            axis: {},
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0,
            },
        });
    });
    // world map
    var mapData = {
        US: 298,
        AU: 760,
        CA: 870,
        IN: 2000000,
        GB: 120,
    };
    if ($("#world-map-markers2").length > 0) {
        $("#world-map-markers2").vectorMap({
            map: "world_mill_en",
            backgroundColor: "transparent",
            borderColor: "#fff",
            borderOpacity: 0.25,
            borderWidth: 0,
            color: "#e6e6e6",
            regionStyle: {
                initial: {
                    fill: "#ececec",
                },
            },

            markerStyle: {
                initial: {
                    r: 5,
                    fill: "#fff",
                    "fill-opacity": 1,
                    stroke: "#000",
                    "stroke-width": 1,
                    "stroke-opacity": 0.4,
                },
            },

            markers: [
                { latLng: [37.09, -95.71], name: "America" },
                { latLng: [-25.27, 133.77], name: "Australia" },
                { latLng: [56.13, -106.34], name: "Canada" },
                { latLng: [20.59, 78.96], name: "India" },
                { latLng: [55.37, -3.43], name: "United Kingdom" },
            ],

            series: {
                regions: [
                    {
                        values: {
                            US: "#339af6",
                            AU: "#02b5b2",
                            IN: "#f1a627",
                            GB: "#445771",
                            CA: "#68bb35",
                        },
                        attribute: "fill",
                    },
                ],
            },
            hoverOpacity: null,
            normalizeFunction: "linear",
            zoomOnScroll: false,
            scaleColors: ["#000000", "#000000"],
            selectedColor: "#000000",
            selectedRegions: [],
            enableZoom: false,
            hoverColor: "#fff",
        });
    }
});
