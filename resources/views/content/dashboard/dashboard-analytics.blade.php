@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
@endsection

@section('page-style')
<!-- Page css files -->
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">


    <div class="row match-height justify-content-center">
        <div class="col-12">
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
                
                @if(Auth::user()->activar_2fact == 0)
                    <div class="text-center">
                        <a class="btn btn-primary" href="{{route('2fact')}}">Activar google authenticator</a>
                    </div>
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
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header p-1">
                    <div class="head-label">
                        <h6 class="mb-0 h2">Historial de Rendimiento</h6>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                                <thead class="">
    
                                    <tr class="text-center bg-purple-alt2">                                
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                        <th>Porcentaje</th>
                                    </tr>
    
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2021-08-26</td>
                                        <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate, neque?</td>
                                        <td>200</td>
                                        <td>10%</td>
                                    </tr>
                                    <tr>
                                        <td>2021-08-26</td>
                                        <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate, neque?</td>
                                        <td>200</td>
                                        <td>10%</td>
                                    </tr>
                                    <tr>
                                        <td>2021-08-26</td>
                                        <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate, neque?</td>
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
@endsection
