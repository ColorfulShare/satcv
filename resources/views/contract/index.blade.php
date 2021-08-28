@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                    <div class="card-title">
                        <h3>Contratos</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                            <thead class="">
                                <tr class="text-center bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>N° Documento</th>
                                    <th>Correo</th>
                                    <th>Fecha</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contratos as $contrato)
                                <tr class="text-center bg-purple-alt2">
                                    <td>{{$contrato->id}}</td>
                                    <td>{{$contrato->getOrden->user->name}}</td>
                                    <td>3125</td>
                                    <td>{{$contrato->getOrden->user->email}}</td>
                                    <td>{{date_format($contrato->created_at, "Y/m/d")}}</td>
                                    <td>
                                      <div class="d-flex">
                                        
                                        <a href="{{ route('users.show-user', $contrato->getOrden->user->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Ver Perfil"><i class="fa fa-eye"></i></a>
                                        <button class="btn btn-info mx-1" data-toggle="tooltip" data-placement="top" title="Reenviar Contrato"><i class="fa fa-paper-plane"></i></button>
                                        <button class="btn btn-success"  data-toggle="tooltip" data-placement="right" title="Aprobar"><i class="fa fa-check-square"></i></button>
                                      </div>
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

@endsection
