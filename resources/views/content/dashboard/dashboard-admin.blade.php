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


    <div class="row match-height justify-content-center">
        <!-- Line Chart Starts -->
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
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
                <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Inversiones</h4>
                </div>
                <div class="card-body">
                    <div id="revenue-report-chart"></div>
                </div>
            </div>
            <!--/ Revenue Report Card -->
        </div>
    </div>

    <div class="row match-height justify-content-center">
        <!-- Revenue Report Card -->
        <div class="col-6">
            <div class="card card-revenue-budget">
                <div
                    class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Inversiones</h4>
                </div>
                <div class="card-body">
                    <div id="revenue-report-chart2"></div>
                </div>
            </div>
        </div>
        <!--/ Revenue Report Card -->

        <!-- Line Chart Starts -->
        <div class="col-6">
            <div class="card">
                <div
                    class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                    <h4 class="card-title mb-25">Medición STCV</h4>
                </div>
                <div class="card-body">
                    <div id="line-chart2"></div>
                </div>
            </div>
        </div>
        <!-- Line Chart Ends -->
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
                    data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
                },
                {
                    name: "Compuesto",
                    data: [200, 210, 120, 200, 170, 290, 200, 30, 100, 120, 200, 100]
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
            colors: [window.colors.solid.warning, window.colors.solid.primary],
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
                        '%</span>' +
                        '</div>'
                    );
                }
            },
            xaxis: {
                categories: monthNames
            },
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
            legend: {
                show: false
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
                    data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
                },
                {
                    name: "Compuesto",
                    data: [200, 210, 120, 200, 170, 290, 200, 30, 100, 120, 200, 100]
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
            colors: [window.colors.solid.warning, window.colors.solid.primary],
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
                        '%</span>' +
                        '</div>'
                    );
                }
            },
            xaxis: {
                categories: monthNames
            },
        };
        if (typeof lineChartEl2 !== undefined && lineChartEl2 !== null) {
            var lineChart2 = new ApexCharts(lineChartEl2, lineChartConfig2);
            lineChart2.render();
        }

        //------------ Revenue Report Chart (RENDIMIENTO) ------------
        //----------------------------------------------
        revenueReportChartOptions2 = {
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
            legend: {
                show: false
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
        revenueReportChart2 = new ApexCharts(revenueReportChart2, revenueReportChartOptions2);
        revenueReportChart2.render();

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
                console.log(data)

            ))
            .catch(function (error) {
                console.log(error);
            });




    })

</script>
@endsection
