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
                            <h1 class="mb-1 text-primary texto-card-2 font-weight-bolder">N°.3541</h1>

                            <div class="text-left">
                                <div class="form-group">
                                    <label for="selectContract" class="d-flex justify-content-center">Cambiar contrato</label>
                                      <select class="form-control text-center" id="selectContract">
                                          <option>-- Seleccione --</option>
                                        @foreach($contratos as $contrato)
                                        <option value="{{$contrato->id}}">Contrato #: {{$contrato->id}} / {{$contrato->created_at->format('Y/m/d')}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="img-card text-center">
                                <i class="fa fa-file-alt fa-5x text-info"></i>
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
                        <div class="col-12 d-flex justify-content-between mt-2">
                            <div class="d-flex">
                                <div>
                                    <i class="fa fa-2x fa-chart-line bg-light rounded-circle p-1"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0">$<span id="contratoInversion">0</span> </h3>
                                    <p><small class="small">Inversión</small></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <i class="fa fa-2x fa-dollar-sign bg-light rounded-circle p-1"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0">$<span id="contratoSaldoCapital">0</span> </h3>
                                    <p><small class="small">Saldo Capital</small></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <i class="fa fa-2x fa-chart-bar bg-light rounded-circle p-1"></i>
                                </div>
                                <div class="pl-1">
                                    <h3 class="my-0"><span id="contratoProductividad">0</span>%</h3>
                                    <p><small class="small">Productividad</small></p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <i class="fa fa-2x fa-wallet bg-light rounded-circle p-1"></i>
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
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="card card-light">

                <div class="d-flex flex-column">
                    <div class="card-header card-title">
                        <h4 class="mb-1 text-dark texto-card-1">Inversión</h4>
                    </div>
                    
                    <div class="card-sub d-flex align-items-center">
                        <div class="progresscircle blue" data-value='70'>
                            <span class="progress-left">
                                <span class="progress-circle"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-circle"></span>
                            </span>
                            <div class="progress-value">50%</div>
                        </div>
                    </div>

                    <div class="border-top mt-2 row text-center font-weight-bold">
                        <div class="col border-right py-2">
                            <p class="m-0">Saldo Invertido</p>
                            <h3 class="m-0 text-dark">$200</h3>
                        </div>
                        <div class="col border-left py-2">
                            <p class="m-0">Ganancia</p>
                            <h3 class="m-0 text-dark">$600</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 col-sm-12">
            <div class="card card-light">

                <div class="d-flex flex-column">
                    <div class="card-header card-title">
                        <h4 class="mb-1 text-dark texto-card-1">Rendimiento</h4>
                    </div>
                    <div id="bar-negative"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12">
           
        </div>
    </div>

    

    <div class="row match-height justify-content-center">
        {{-- <div class="col-12">
            <div class="card-body">
                <div class="profile-image-wrapper">
                    <div class="profile-image text-center">
                        <div class="avatar my-2">
                            @if (Auth::user()->profile_photo_path != NULL)
                                <img width="110px" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img width="110px" src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->name }}" alt="{{ Auth::user()->name }}">                                
                            @endif
                        </div>
                    </div>
                </div>
                <h3 class="text-center">{{Auth::user()->name}}</h3>
                <h6 class="text-muted font-weight-bolder text-center">Bitcoin Ecuador ID #<span>{{ Auth::user()->id }}</span></h6>
                @if(Auth::user()->email_verified_at != null)
                <h5 class="text-success font-weight-bolder text-center">Usuario Verificado</h5>
                @else
                <h5 class="text-danger font-weight-bolder text-center">Usuario No Verificado</h5>
                @endif
                @if(count($contratos)>0)
				<div class="row justify-content-center my-2">
					<div class="form-group col-8">
						<label for="selectContract" class="d-flex justify-content-center">Seleccione un contrato para su información</label>
                          <select class="form-control fa" id="selectContract">
                              <option>-- Seleccione un contrato --</option>
							@foreach($contratos as $contrato)
                            <option value="{{$contrato->id}}">Contrato #: {{$contrato->id}} / {{$contrato->created_at->format('Y/m/d')}}</option>
                            @endforeach
						</select>
					</div>
				</div>
				

                <hr class="mb-2">

                <div class="d-flex justify-content-around align-items-center">
                    <div class="text-center">
                        <i class="fa fa-briefcase fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Inversión</h6>
                        <h3 class="mb-0" id="contratoInversion">0</h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-wallet fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Saldo Capital</h6>
                        <h3 class="mb-0" id="contratoSaldoCapital">0</h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-chart-line fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Productividad</h6>
                        <h3 class="mb-0" id="contratoProductividad">0</h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-money-bill fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Retirado</h6>
                        <h3 class="mb-0" id="contratoRetirado">0</h3>
                    </div>
                </div>
                @else
                <div class="row justify-content-center my-2">
					<div class="form-group col-8">
                        <h6 class="mb-0 h2 text-center">Aún no hay contratos</h6>
					</div>
				</div>
                @endif
            </div>
        </div> --}}

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
                            <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                                <thead class="">
    
                                    <tr class="text-center bg-purple-alt2">                                
                                        <th>Fecha</th>
                                        <th>Mes</th>
                                        <th>Monto</th>
                                        <th>%</th>
                                    </tr>
    
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>2021-08-26</td>
                                        <td>Abril</td>
                                        <td>200</td>
                                        <td>10%</td>
                                    </tr>
                                    <tr>
                                        <td>2021-08-26</td>
                                        <td>Mayo</td>
                                        <td>200</td>
                                        <td>10%</td>
                                    </tr>
                                    <tr>
                                        <td>2021-08-26</td>
                                        <td>Junio</td>
                                        <td>200</td>
                                        <td>10%</td>
                                    </tr>
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

<script>
    document.addEventListener('DOMContentLoaded', function(){

        let selectContract = document.querySelector("#selectContract");
        let contratoInversion = document.querySelector("#contratoInversion");
        let contratoSaldoCapital = document.querySelector("#contratoSaldoCapital");
        let contratoProductividad = document.querySelector("#contratoProductividad");
        let contratoRetirado = document.querySelector("#contratoRetirado");

        let url = 'api/getContrato/';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if(selectContract != null){
            selectContract.addEventListener('change', function(){
                if(selectContract.value > 0){
                    fetch(url+selectContract.value, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                            },
                        method: 'get',
                    })
                    .then( response => response.text() )
                    .then( resultText => (
                        data = JSON.parse(resultText),
                        contratoInversion.innerHTML = data.invested,
                        contratoSaldoCapital.innerHTML = data.capital,
                        contratoProductividad.innerHTML = data.gain,
                        contratoRetirado.innerHTML = data.gain
                    ))
                    .catch(function(error) {
                        console.log(error);
                    });
                }else{
                    contratoInversion.innerHTML = 0;
                    contratoSaldoCapital.innerHTML = 0;
                    contratoProductividad.innerHTML = 0;
                    contratoRetirado.innerHTML = 0;
                }
            });
        }

    });

</script>

@section('vendor-script')
<!-- vendor files -->
@endsection

@section('page-script')
{{-- <!-- Page js files -->
<script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-invoice-list.js') }}"></script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function(){

        $(".progresscircle").each(function() {
            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-left .progress-circle');
            var right = $(this).find('.progress-right .progress-circle');

            if (value > 0) {
                if (value <= 50) {
                    right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                    right.css('transform', 'rotate(180deg)')
                    left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
            }
        })

        function percentageToDegrees(percentage) {
            return percentage / 100 * 360
        }
    })









    
      
    var options = {
          series: [{
          name: 'Ganancia',
          data: [0.4, 0.65, 0.76, 0.88, 1.5, 0.65, 0.76, 0.88]
        },
        {
          name: 'Inversión',
          data: [-0.8, -1.05, -1.06, -1.18, -1.4, -1.05, -1.06, -1.18]
        }
        ],
          chart: {
          type: 'bar',
          height: 300,
          stacked: true
        },
        colors: ['#00e600', '#ffa361'],
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '20%',
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: 1,
          colors: ["#fff"]
        },
        
        grid: {
          xaxis: {
            lines: {
              show: false
            }
          }
        },
        yaxis: {
          min: -2,
          max: 2,
          title: {
            // text: 'Age',
          },
        },
        tooltip: {
          shared: false,
          x: {
            formatter: function (val) {
              return val
            }
          },
          y: {
            formatter: function (val) {
              return Math.abs(val) + "%"
            }
          }
        },
        title: {
          text: ''
        },
        xaxis: {
          title: {
            text: 'Percent'
          },
          labels: {
            formatter: function (val) {
              return Math.abs(Math.round(val)) + "%"
            }
          }
        },
        };

        var chart = new ApexCharts(document.querySelector("#bar-negative"), options);
        chart.render();
    
</script>
@endsection
