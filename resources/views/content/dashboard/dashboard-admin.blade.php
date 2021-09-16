@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    @if(Request::get('id'))
    <a class="btn btn-danger" href="{{ URL::previous() }}">
        <i class="fa fa-arrow-left"></i>
        Regresar
    </a>
    @endif

    <div class="row match-height">

        <!-- Line Chart - Profit -->
        <div class="col-12">
            <div class="card card-revenue-budget">
                    <div class="row mx-0">
                        <div class="col-md-9 col-12 revenue-report-wrapper">
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-50 mb-sm-0">Total Saldo Capital</h4>
                                <h2 class="mb-1" id="totalCapital">0</h2>
                            </div>
                            <div id="statistics-profit-chart"></div>
                        </div>
                        <div class="col-md-3 col-12 budget-wrapper d-flex flex-column justify-content-center">
                            <div id="earnings-chart"></div>
                        </div>
                    </div>

            </div>
        </div>
        <!--/ Line Chart - Profit -->

    </div>

    <div class="row match-height justify-content-center">
        <!-- Line Chart Starts -->
        <div class="col-6">
            <div class="card">
                <div
                    class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Medición STCV</h4>
                </div>
                <div class="card-body">
                    <div id="line-chart"></div>
                </div>
            </div>
        </div>
        <!-- Line Chart Ends -->

        <!-- Revenue Report Card -->
        <div class="col-6">
            <div class="card card-revenue-budget">
                <div
                    class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Porcentaje Lineal | Compuesto</h4>
                </div>
                <div class="card-body">
                    <div id="revenue-report-chart"></div>
                </div>
            </div>
            <!--/ Revenue Report Card -->
        </div>
    </div>

    <div class="row match-height justify-content-center">
        <!-- Line Chart Starts -->
        <div class="col-6">
            <div class="card">
                <div
                    class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Inversiones</h4>
                </div>
                <div class="card-body">
                    <div id="line-chart2"></div>
                </div>
            </div>
        </div>
        <!-- Line Chart Ends -->

        <!-- Revenue Report Card -->
        <div class="col-6">
            <div class="card card-revenue-budget">
                <div
                    class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Utilidades</h4>
                </div>
                <div class="card-body">
                    <div id="UtilidadesChart"></div>
                </div>
            </div>
            <!--/ Revenue Report Card -->
        </div>
    </div>

</section>
@endsection

@section('vendor-script')
<!-- vendor files -->
@endsection

@section('page-script')
<script>
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    let monthNames = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
    document.addEventListener('DOMContentLoaded', function () {

        // Line Chart
        // --------------------------------------------------------------------
        var lineChartEl = document.querySelector('#line-chart');
        var lineChartEl2 = document.querySelector('#line-chart2');
        var revenueReportChart = document.querySelector('#revenue-report-chart');
        var revenueReportChart2 = document.querySelector('#revenue-report-chart2');
        var earningsChart = document.querySelector('#earnings-chart');
        var statisticsProfitChart = document.querySelector('#statistics-profit-chart');
        var totalCapital = document.querySelector('#totalCapital');

        lineChartConfig = {
            chart: {
                height: 400,
                type: 'line',
                zoom: {
                    enabled: false
                },
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                }
            },
            series: [{
                    name: "Lineal",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "Compuesto",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }
            ],
            markers: {
                strokeWidth: 7,
                strokeOpacity: 1,
                strokeColors: [window.colors.solid.white],
                colors: [window.colors.solid.warning]
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'straight'
            },
            colors: ['#00e600', window.colors.solid.warning],
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: -20
                }
            },
            tooltip: {
                custom: function (data) {
                    return (
                        '<div class="px-1 py-50">' +
                        '<span>' +
                        data.series[data.seriesIndex][data.dataPointIndex] +
                        ' Contratos</span>' +
                        '</div>'
                    );
                }
            },
            legend: {
                labels: {
                    colors: '#b9b9c3',
                    useSeriesColors: false,
                },
            },
            xaxis: {
                categories: monthNames,
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
            },
            yaxis:{
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
            }
        };
        if (typeof lineChartEl !== undefined && lineChartEl !== null) {
            var lineChart = new ApexCharts(lineChartEl, lineChartConfig);
            lineChart.render();
        }


        //------------ Revenue Report Chart (RENDIMIENTO) ------------
        //----------------------------------------------
        revenueReportChartOptions = {
            chart: {
                width: '100%',
                stacked: true,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '12%',
                    endingShape: 'rounded'
                },
                distributed: true
            },
            colors: ['#00e600', window.colors.solid.warning],
            series: [{
                    name: "Lineal",
                    data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50]
                },
                {
                    name: "Compuesto",
                    data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50]
                }
            ],
            dataLabels: {
                enabled: false
            },
            grid: {
                padding: {
                    top: -20,
                    bottom: -10
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                }
            },
            legend: {
                itemMargin: {
                    vertical: 20
                },
                labels: {
                    colors: '#b9b9c3',
                    useSeriesColors: false,
                },
            },
            xaxis: {
                categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
                    'Dic'
                ],
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                min: 0,
                max: 100,
                labels: {
                    formatter: function (y) {
                        return y.toFixed(2) + "%";
                    },
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem'
                    },
                    show: true
                }
            }
        };
        revenueReportChart = new ApexCharts(revenueReportChart, revenueReportChartOptions);
        revenueReportChart.render();


        // Line Chart
        // --------------------------------------------------------------------
        lineChartConfig2 = {
            chart: {
                height: 400,
                type: 'line',
                zoom: {
                    enabled: false
                },
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                }
            },
            series: [{
                    name: "Lineal",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "Compuesto",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }
            ],
            markers: {
                strokeWidth: 7,
                strokeOpacity: 1,
                strokeColors: [window.colors.solid.white],
                colors: [window.colors.solid.warning]
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            colors: ['#00e600', window.colors.solid.warning],
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: -20
                }
            },
            tooltip: {
                custom: function (data) {
                    return (
                        '<div class="px-1 py-50">' +
                        '<span>' +
                        data.series[data.seriesIndex][data.dataPointIndex] +
                        ' $</span>' +
                        '</div>'
                    );
                }
            },
            legend: {
                labels: {
                    colors: '#b9b9c3',
                    useSeriesColors: false,
                },
            },
            xaxis: {
                categories: monthNames,
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
            },
            yaxis:{
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
            }
        };
        if (typeof lineChartEl2 !== undefined && lineChartEl2 !== null) {
            var lineChart2 = new ApexCharts(lineChartEl2, lineChartConfig2);
            lineChart2.render();
        }


        UtilidadesChartOptions = {
            series: [{
                name: 'Total Utilidades',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }, {
                name: 'Lineal',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }, {
                name: 'Compuesto',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            legend: {
                itemMargin: {
                    horizontal: 10,
                    vertical: 10
                },
                labels: {
                    colors: '#b9b9c3',
                    useSeriesColors: false,
                },
            },
            colors: [window.colors.solid.primary, '#00e600', window.colors.solid.warning],
            xaxis: {
                categories: monthNames,
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
            },
            yaxis:{
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: true
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val
                    }
                }
            }
        };

        UtilidadesChart = new ApexCharts(document.querySelector("#UtilidadesChart"),
            UtilidadesChartOptions);
        UtilidadesChart.render();


        earningsChartOptions = {
            chart: {
                type: 'donut',
                height: 120,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false,
                formatter: function (val) {
                    return val + "%"
                },
            },
            series: [50, 50],
            legend: {
                show: false
            },
            labels: ['lineal', 'compuesto'],
            stroke: {
                width: 0
            },
            colors: ['#00c600', '#00d600', '#00e600'],
            grid: {
                padding: {
                    right: -20,
                    bottom: -8,
                    left: -20
                }
            },
            plotOptions: {
                pie: {
                    startAngle: -10,
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                offsetY: 15,
                                formatter: function (val) {
                                    return val;
                                }
                            },
                            value: {
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '%';
                                }
                            },
                            total: {
                                show: true,
                                offsetY: 15,
                                label: '',
                                formatter: function (w) {
                                    return '100%';
                                }
                            }
                        }
                    }
                }
            },
            responsive: [{
                    breakpoint: 1325,
                    options: {
                        chart: {
                            height: 100
                        }
                    }
                },
                {
                    breakpoint: 1200,
                    options: {
                        chart: {
                            height: 120
                        }
                    }
                },
                {
                    breakpoint: 1045,
                    options: {
                        chart: {
                            height: 100
                        }
                    }
                },
                {
                    breakpoint: 992,
                    options: {
                        chart: {
                            height: 120
                        }
                    }
                }
            ]
        };
        earningsChart = new ApexCharts(earningsChart, earningsChartOptions);
        earningsChart.render();

        //------------ Statistics Line Chart ------------
        //-----------------------------------------------

        statisticsProfitChartOptions = {
            chart: {
                height: 70,
                type: 'line',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            legend: {
                show: false,
            },
            labels: {
                colors: '#000000',
                useSeriesColors: false,
            },
            grid: {
                borderColor: '#00e600',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: -30,
                    bottom: -10
                }
            },
            stroke: {
                width: 3
            },
            colors: ['#00e600', window.colors.solid.warning],
            series: [{
                name: "Lineal",
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
            {
                name: "Compuesto",
                data:  [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            markers: {
                size: 2,
                colors: '#00e600',
                strokeColors: '#00e600',
                strokeWidth: 2,
                strokeOpacity: 1,
                strokeDashArray: 0,
                fillOpacity: 1,
                discrete: [{
                    seriesIndex: 0,
                    dataPointIndex: 5,
                    fillColor: '#ffffff',
                    strokeColor: '#00e600',
                    size: 5
                }],
                shape: 'circle',
                radius: 2,
                hover: {
                    size: 3
                }
            },
            xaxis: {
                categories: monthNames,
                labels: {
                    show: true,
                    style: {
                        fontSize: '0px'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                show: false
            },
            tooltip: {
                x: {
                    show: false
                }
            }
        };
        statisticsProfitChart = new ApexCharts(statisticsProfitChart, statisticsProfitChartOptions);
        statisticsProfitChart.render();



        //------------PETICIÓN ASINCRONA  ------------
        //-----------------------------------------------
        fetch(`{{route("get.contracts.admin")}}`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'get',
            })
            .then(response => response.text())
            .then(resultText => (
                data = JSON.parse(resultText),
                console.log(data),
                lineChart.updateOptions({
                    series: [{
                            data: data.lineal
                        },
                        {
                            data: data.compuesto
                        }
                    ],
                }),
                revenueReportChart.updateOptions({
                    series: [{
                            data: data.linealPorcentaje
                        },
                        {
                            data: data.compuestoPorcentaje
                        }
                    ],
                }),
                lineChart2.updateOptions({
                    series: [{
                            data: data.linealEntradas
                        },
                        {
                            data: data.compuestoEntradas
                        }
                    ],
                }),
                UtilidadesChart.updateOptions({
                    series: [{
                        data: data.utilidadesTotales
                    }, {
                        data: data.utilidadesLineales
                    }, {
                        data: data.utilidadesCompuestas
                    }],
                }),
                total = data.capitalesLineal + data.capitalesCompuesto,
                capitalesLineal = ((data.capitalesLineal / total) * 100).toFixed(2),
                capitalesCompuesto = ((data.capitalesCompuesto / total) * 100).toFixed(2),
                totalCapital.innerHTML = '$' + total,
                earningsChart.updateOptions({
                    series: [parseFloat(capitalesLineal), parseFloat(capitalesCompuesto)],
                }),
                statisticsProfitChart.updateOptions({
                    series: [{
                        data: data.capitalesMesesLineal
                    },{
                        data: data.capitalesMesesCompuesto
                    }
                    ],
                })
            ))
            .catch(function (error) {
                console.log(error);
            });




    })

</script>
@endsection
