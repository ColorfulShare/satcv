@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
@endsection

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/custom-dashboard.css')}}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">

    <div class="row match-height justify-content-center">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card card-light">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-8 d-flex flex-column">
                            <h4 class="mb-1 text-dark texto-card-1">Bienvenido {{Auth::user()->name}}</h4>
                            <h1 class="mb-1 text-primary texto-card-2 font-weight-bolder">N°. <span
                                    id="idContrato">{{$contract->id}}</span></h1>

                            <div class="text-left">
                                <div class="form-group">
                                    {{--
                                    <label for="selectContract" class="d-flex justify-content-center">Cambiar
                                        contrato</label>
                                    <select class="form-control text-center" id="selectContract">
                                        <option>-- Seleccione --</option>
                                        @foreach($contratos as $contrato)
                                        <option value="{{$contrato->id}}">Contrato #: {{$contrato->id}} /
                                            {{$contrato->created_at->format('Y/m/d')}}</option>
                                        @endforeach
                                    </select>
                                    --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="img-card text-center">
                                <i class="fa fa-file-alt fa-5x text-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card card-light">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-1 text-dark texto-card-1">Estadísticas</h4>
                        </div>
                        <div class="col-12 d-flex justify-content-between flex-wrap">
                            <div class="d-flex mt-2">
                                <div>
                                    <i class="fa fa-2x fa-chart-line bg-light rounded-circle p-1 text-info"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0">$<span id="contratoInversion">{{$contract->invested}}</span> </h3>
                                    <p><small class="small">Inversión</small></p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div>
                                    <i class="fa fa-2x fa-dollar-sign bg-light rounded-circle p-1 text-success"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0">$<span id="contratoSaldoCapital">{{$contract->capital}}</span> </h3>
                                    <p><small class="small">Saldo Capital</small></p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div>
                                    <i class="fa fa-2x fa-chart-bar bg-light rounded-circle p-1 text-warning"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0"><span id="contratoProductividad">0</span>%</h3>
                                    <p><small class="small">Productividad</small></p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div>
                                    <i class="fa fa-2x fa-wallet bg-light rounded-circle p-1 text-info"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0">$<span id="contratoRetirado">0</span> </h3>
                                    <p><small class="small">Retirado</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row match-height justify-content-center">

        <!-- Goal Overview Card -->
        <div class="col-lg-4 col-md-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Inversión</h4>
                </div>
                <div class="card-body p-0">
                    <div id="goal-overview-radial-bar-chart" class="my-2"></div>
                    <div class="row border-top text-center mx-0">
                        <div class="col-6 border-right py-1">
                            <p class="card-text text-muted mb-0">Saldo Invertido</p>
                            <h3 class="font-weight-bolder mb-0">${{$contract->invested}}</h3>
                        </div>
                        <div class="col-6 py-1">
                            <p class="card-text text-muted mb-0">Ganancia</p>
                            <h3 class="font-weight-bolder mb-0">${{$contract->gain}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Goal Overview Card -->

        <!-- Revenue Report Card -->
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card card-revenue-budget">
                <div class="row mx-0">
                    <div class="col-md-7 col-12 revenue-report-wrapper">
                        <div class="d-sm-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-50 mb-sm-0">Rendimiento</h4>
                        </div>
                        <div id="revenue-report-chart"></div>
                    </div>
                    <div class="col-md-5 col-12 budget-wrapper d-flex flex-column justify-content-center">
                        <div class="mb-1">
                            <h2 class="h1 mb-50 mb-sm-0">$567</h2>
                            <h5>Ganancia</h5>
                        </div>
                        <div id="budget-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Revenue Report Card -->

    </div>



    <div class="row match-height justify-content-center">

        <div class="col-12">
            <div class="card">
                <div class="card-header p-1">
                    <div class="head-label">
                        <h6 class="mb-0 h2">Historico de porcentaje de Rendimiento</h6>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table
                                class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped comuntable">
                                <thead class="">

                                    <tr class="text-center bg-purple-alt2">
                                        <th>Id</th>
                                        <th>Mes</th>
                                        <th>%</th>
                                    </tr>

                                </thead>
                                <tbody class="text-center">
                                    @php
                                    setlocale(LC_ALL, 'es');
                                    @endphp
                                    @foreach ($utilities as $utility)

                                    <tr class="text-center">
                                        <td>{{$utility->id}}</td>
                                        <td class="text-capitalize">
                                            {{strftime("%B", \Carbon\Carbon::createFromFormat('!m',$utility->month)->getTimestamp())}}
                                        </td>
                                        <td>{{$utility->percentage * 100}} %</td>
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

</section>
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config');

@section('vendor-script')
<!-- vendor files -->
@endsection

@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        //-------------- SELECT DINÁMICO --------------
        //----------------------------------------------
        let selectContract = document.querySelector("#selectContract");
        let idContrato = document.querySelector('#idContrato');
        let contratoInversion = document.querySelector("#contratoInversion");
        let contratoSaldoCapital = document.querySelector("#contratoSaldoCapital");
        let contratoProductividad = document.querySelector("#contratoProductividad");
        let contratoRetirado = document.querySelector("#contratoRetirado");

        let url = 'api/getContrato/';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (selectContract != null) {
            selectContract.addEventListener('change', function () {
                if (selectContract.value > 0) {
                    fetch(url + selectContract.value, {
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
                            idContrato.innerHTML = data.id,
                            contratoInversion.innerHTML = data.invested,
                            contratoSaldoCapital.innerHTML = data.capital,
                            contratoProductividad.innerHTML = data.gain,
                            contratoRetirado.innerHTML = data.gain
                        ))
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    idContrato.innerHTML = "";
                    contratoInversion.innerHTML = 0;
                    contratoSaldoCapital.innerHTML = 0;
                    contratoProductividad.innerHTML = 0;
                    contratoRetirado.innerHTML = 0;
                }
            });
        }




        var $revenueReportChart = document.querySelector('#revenue-report-chart');
        var $budgetChart = document.querySelector('#budget-chart');
        var $goalOverviewChart = document.querySelector('#goal-overview-radial-bar-chart');

        var revenueReportChartOptions;
        var budgetChartOptions;
        var goalOverviewChartOptions;

        var revenueReportChart;
        var budgetChart;
        var goalOverviewChart;

        //------------ Revenue Report Chart ------------
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
                    name: 'Earning',
                    data: [95, 177, 284, 256, 105, 63, 102, 320]
                },
                {
                    name: 'Expense',
                    data: [-145, -80, -60, -180, -100, -60, -75, -80]
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
                categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem',
                    },
                    show: false
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#b9b9c3',
                        fontSize: '0.86rem'
                    },
                    show: false
                }
            }
        };
        revenueReportChart = new ApexCharts($revenueReportChart, revenueReportChartOptions);
        revenueReportChart.render();


        //---------------- Budget Chart ----------------
        //----------------------------------------------
        budgetChartOptions = {
            chart: {
                width: '100%',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                type: 'line',
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'smooth',
                dashArray: [0, 5],
                width: [2]
            },
            colors: ['#00e600', '#00e600'],
            series: [{
                    data: [61, 48, 69, 52, 60, 40, 79, 60, 59, 43, 62]
                },
                {
                    data: [20, 10, 30, 15, 23, 0, 25, 15, 20, 5, 27]
                }
            ],
            tooltip: {
                enabled: false
            }
        };
        budgetChart = new ApexCharts($budgetChart, budgetChartOptions);
        budgetChart.render();

        let porcentaje = ({{$contract->gain}} / {{$contract->invested}}) * 100 
        //------------ Goal Overview Chart ------------
        //---------------------------------------------
        goalOverviewChartOptions = {
            chart: {
                width: '100%',
                type: 'radialBar',
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                }
            },
            colors: ['#00e600'],
            plotOptions: {
                radialBar: {
                    offsetY: -10,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%'
                    },
                    track: {
                        background: '#8a8a8a61',
                        strokeWidth: '50%'
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            color: '#5e5873',
                            fontSize: '2.86rem',
                            fontWeight: '600'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [window.colors.solid.success],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            series: [porcentaje],
            stroke: {
                lineCap: 'round'
            },
            grid: {
                padding: {
                    bottom: 30
                }
            }
        };
        goalOverviewChart = new ApexCharts($goalOverviewChart, goalOverviewChartOptions);
        goalOverviewChart.render();
    });

</script>
@endsection
