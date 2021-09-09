@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    {{-- @if(Request::get('id')) --}}
        <a class="btn btn-danger mb-2" href="{{ URL::previous() }}">
            <i class="fa fa-arrow-left"></i>
            Regresar
        </a>
    {{-- @endif --}}

    <div class="row match-height justify-content-center">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card card-light">
                <div class="card-body text-left">
                    <div class="row">
                        <div class="col-8 d-flex flex-column">
                            <h4 class="mb-1 text-dark texto-card-1">Bienvenido {{$user->name}}</h4>
                            <h1 class="mb-1 text-primary texto-card-2 font-weight-bolder">N°. 
                                
                                <span id="idContrato">@if(Request::get('id')){{Request::get('id')}}@endif</span></h1>
                                
                            <div class="text-left">
                                <div class="form-group">
                                    <label for="selectContract" class="d-flex justify-content-center">Cambiar
                                        contrato</label>
                                        <select class="form-control text-center" id="selectContract">
                                            <option>-- Seleccione --</option>
                                            @foreach($contratos as $contrato)
                                            <option 
                                                @if(Request::get('id') == $contrato->id)
                                                selected
                                                @endif value="{{$contrato->id}}">Contrato #: {{$contrato->id}} /
                                                {{$contrato->created_at->format('Y/m/d')}}</option>
                                            @endforeach
                                        </select>
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
                                    <h3 class="my-0">$<span class="contratoInversion">0</span> </h3>
                                    <p><small class="small">Inversión</small></p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div>
                                    <i class="fa fa-2x fa-dollar-sign bg-light rounded-circle p-1 text-success"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0">$<span id="contratoSaldoCapital">0</span> </h3>
                                    <p><small class="small">Saldo Capital</small></p>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <div>
                                    <i class="fa fa-2x fa-chart-bar bg-light rounded-circle p-1 text-warning"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0"><span class="contratoProductividad">0</span>%</h3>
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
                            <h3 class="font-weight-bolder mb-0">$<span class="contratoInversion">0</span></h3>
                        </div>
                        <div class="col-6 py-1">
                            <p class="card-text text-muted mb-0">Ganancia</p>
                            <h3 class="font-weight-bolder mb-0">$<span class="contratoGanancia">0</span></h3>
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
                            <h2 class="h1 mb-50 mb-sm-0">$<span class="contratoGanancia">0</span></h2>
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
                                class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped" id="datatableUtility">
                                <thead class="">
                                </thead>
                                <tbody class="text-center">
                                    @php
                                    setlocale(LC_ALL, 'es');
                                    @endphp
                                   
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

@section('vendor-script')
<!-- vendor files -->
@endsection

@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        //-------------- SELECT DINÁMICO --------------
        //----------------------------------------------
        let selectContract = document.querySelector("#selectContract")
        let idContrato = document.querySelector('#idContrato')
        let contratoInversion = document.querySelectorAll(".contratoInversion")
        let contratoSaldoCapital = document.querySelector("#contratoSaldoCapital")
        let contratoProductividad = document.querySelectorAll(".contratoProductividad")
        let contratoGanancia = document.querySelectorAll(".contratoGanancia")
        let contratoRetirado = document.querySelector("#contratoRetirado")

        let url = 'api/getContrato/'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        let mesActual;
        if (selectContract != null) {
            
            if (selectContract.value > 0) {
                execute();
            } 
                
        }
        let monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];



        selectContract.addEventListener('change', function () {
            if (selectContract.value > 0) {
                execute();
            } else {

                datatable.clear(),
                datatable.draw(),

                goalOverviewChart.updateOptions({
                    series: [(0).toFixed(2)],
                }),
                revenueReportChart.updateOptions({
                    series: [{
                            data: [0,0,0,0,0,0],
                        },
                        {
                            data: [0,0,0,0,0,0],
                        }
                    ],
                    xaxis: {
                        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                    },
                }),
                
                budgetChart.updateOptions({
                    series: [{
                            data: [0,0,0,0,0,0],
                        },
                        {
                            data: [0,0,0,0,0,0],
                        }
                    ],
                }),

                
                idContrato.innerHTML = "";
                contratoInversion.forEach(i => i.innerHTML = 0),
                contratoSaldoCapital.innerHTML = 0;
                contratoProductividad.forEach(i => i.innerHTML = 0),
                contratoGanancia.forEach(i => i.innerHTML = 0),
                contratoRetirado.innerHTML = 0;
            }
        });

        function execute(){
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
                //DATOS DEL DATATABLE//
                datosTable = data.utility.map(i => i = Object.values(i)),
                        datosTable.map(i => i[1] = monthNames[new Date(i[1]).getMonth()]),
                        datosTable.map(i => i[3] = i[3]*100),
                        datosTable.map(i => i[3] = i[3].toFixed(2)),
                        datosTable.map(i => i[2] = i[2].toFixed(2)),
                dataSet = datosTable,
                datatable.clear(),
                datatable.rows.add(dataSet),
                datatable.draw(),
                
                //GRÁFICA DE INVERSIÓN//
                goalOverviewChart.updateOptions({
                    series: [(data.dias).toFixed(2)],
                }),
                //GRÁFICA DE RENDIMIENTO//
                revenueReportChart.updateOptions({
                    series: [{
                            data: data.positivo.map(num => (num * 100).toFixed(2)),
                        },
                        {
                            data: data.negativo.map(num => (num * 100).toFixed(2)),
                        }
                    ],
                    xaxis: {
                        categories: data.mes.map(i => i = monthNames[i]),
                    },
                }),

                //GRÁFICA DE GANANCIA//
                budgetChart.updateOptions({
                    series: [{
                            data: data.amount,
                        },
                        {
                            data: data.amount.map(num => num - 30),
                        }
                    ],
                }),
                
                //ESTADÍSTICAS//
                idContrato.innerHTML = data.contrato.id,
                contratoInversion.forEach(i => i.innerHTML = data.contrato.invested.toFixed(2)),
                contratoSaldoCapital.innerHTML = data.contrato.capital.toFixed(2),
                contratoProductividad.forEach(i => i.innerHTML = data.productividad.toFixed(2)),
                contratoGanancia.forEach(i => i.innerHTML = data.contrato.gain.toFixed(2)),
                contratoRetirado.innerHTML = data.retirado.toFixed(2)
            ))
            .catch(function (error) {
                console.log(error);
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


                //------------ Goal Overview Chart (INVERSION) ------------
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
                series: [(0).toFixed(2)],
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
                        name: '%',
                        data: [0, 0, 0, 0, 0, 0]
                    },
                    {
                        name: '%',
                        data: [-0, -0, -0, -0, -0, -0]
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
                    categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
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
                        data: [0, 0, 0, 0, 0, 0]
                    },
                    {
                        data: [0, 0, 0, 0, 0, 0]
                    }
                ],
                tooltip: {
                    enabled: false
                }
            };
            budgetChart = new ApexCharts($budgetChart, budgetChartOptions);
            budgetChart.render();

        //---------------- DataTable ----------------
        //----------------------------------------------
            var dataSet = '';

            var datatable = $('#datatableUtility').DataTable({
                order: [[ 0, "desc" ]],
                responsive: true,
                searching: true,
                bLengthChange: true,
                pageLength: 10,
                columnDefs: [
                        {className: "dt-center text-center", "targets": "_all"}
                    ],
                data: dataSet,
                columns: [
                    { title: "ID" },
                    { title: "Mes" },
                    { title: "Monto" },
                    { title: "%" }
                ]


            });

    });

    
</script>
@endsection
