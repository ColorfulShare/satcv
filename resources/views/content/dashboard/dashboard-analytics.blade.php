@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('/fonts/font-awesome/css/font-awesome.min.css')}}">
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
                        <div class="avatar">
                            <img src="http://127.0.0.1:8000/images/portrait/small/avatar-s-9.jpg" alt="Profile Picture">
                        </div>
                    </div>
                </div>
                <h3 class="text-center">Curtis Stone</h3>
                <h6 class="text-muted font-weight-bolder text-center">Bitcoin Ecuador ID <span>3683</span></h6>
                <h5 class="text-success font-weight-bolder text-center">Usuario Verificado</h5>

				<div class="row justify-content-center my-2">
					<div class="form-group col-8">
						<label for="selectContract" class="d-flex justify-content-center">Seleccione un contrato para su información</label>
                          <select class="form-control fa" id="selectContract">
                              <option>-- Seleccione un contrato --</option>
							@foreach($ordenes as $orden)
                            <option value="{{$orden->id}}">Contrato #: {{$orden->id}} / {{date_format($orden->created_at,"Y/m/d")}}</option>
                            @endforeach
						</select>
					</div>
				</div>
				

                <hr class="mb-2">

                <div class="d-flex justify-content-around align-items-center">
                    <div class="text-center">
                        <i class="fa fa-briefcase fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Inversión</h6>
                        <h3 class="mb-0" id="contratoInversion"></h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-wallet fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Saldo Capital</h6>
                        <h3 class="mb-0" id="contratoSaldoCapital"></h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-chart-line fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Productividad</h6>
                        <h3 class="mb-0" id="contratoProductividad"></h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-money-bill fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Retirado</h6>
                        <h3 class="mb-0" id="contratoRetirado"></h3>
                    </div>
                </div>
            </div>
        </div>

        <div id="logs-list">
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
        
                                        <tr class="text-center text-white bg-purple-alt2">                                
                                            <th>ID</th>
                                            <th>Correo</th>
                                            <th>Transaccion</th>
                                            <th>Tipo de interes</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Fecha de Creación</th>
                                        </tr>
        
                                    </thead>
                                    <tbody>
        
                                        @foreach ($ordenes as $orden)
                                        <tr class="text-center">
                                            <td>{{$orden->id}}</td>
                                            <td>{{$orden->user->email}}</td>
                                            <td>{{$orden->transaction_id}}</td>
                                            <td>{{$orden->type_interes}}</td>
                                            <td>{{$orden->amount}}</td>
                                            <td>
                                                <button type="button"
                                                @if (Auth::user()->admin == 1 && $orden->status == '0')
                                                data-toggle="modal"
                                                data-target="#ModalStatus{{$orden->id}}"
                                                @endif
                                                class="@if ($orden->status == '0') btn btn-info text-white text-bold-600  @elseif($orden->status == '1') btn btn-success text-white text-bold-600 @elseif($orden->status >= '2') btn btn-danger text-white text-bold-600 @endif">{{$orden->status()}}
                                                </button>
                                            </td>
                                            <td>{{$orden->created_at->format('Y-m-d')}}</td>
        
                                        </tr>
                                        @if (Auth::user()->admin == 1 && $orden->status == '0')
                                            <!-- Modal -->
                                            <div class="modal fade" id="ModalStatus{{$orden->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Cambiar estatus</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('cambiarStatus') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
        
                                                    <input type="hidden" name="id" value="{{$orden->id}}">
                                                    ¿Desea cambiar es estatus de la orden?
                                                    <br>
                                                    <label>Seleccione el estado</label>
                                                    <select name="status" required class="form-control">
                                                        <option value="">Seleccione un estado</option>
                                                        <option value="1">Aprobado</option>
                                                        <option value="2">Rechazado</option>
                                                    </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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

</section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function(){

        let selectContract = document.querySelector("#selectContract");
        let contratoInversion = document.querySelector("#contratoInversion");
        let contratoSaldoCapital = document.querySelector("#contratoSaldoCapital");
        let contratoProductividad = document.querySelector("#contratoProductividad");
        let contratoRetirado = document.querySelector("#contratoRetirado");

        let url = '/getContrato/';
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        selectContract.addEventListener('change', function(){
            fetch("api"+url+selectContract.value, {
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

                // console.log(data)
            ))
            .catch(function(error) {
                console.log(error);
            });
        });

    });

</script>

@section('vendor-script')
<!-- vendor files -->
@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-invoice-list.js') }}"></script>
@endsection
