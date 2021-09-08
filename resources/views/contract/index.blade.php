@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                <div class="card-title">
                    <h3>Inversión</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped myTable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Correo</th>
                                <th>Monto</th>
                                <th>Saldo Capital</th>
                                <th>Productividad</th>
                                <th>Retirado</th>
                                <th>Vencimiento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contratos as $contrato)
                            <tr class="text-center">
                                <td>{{$contrato->id}}</td>
                                <td>{{$contrato->created_at->format('Y/m/d')}}</td>
                                <td>{{$contrato->getOrden->user->email}}</td>
                                <td>{{$contrato->getOrden->amount}}</td>
                                <td>{{$contrato->capital}}</td>
                                <td>{{$contrato->productividad()}}</td>
                                <td>{{$contrato->retirado()}}</td>
                                <td>{{$contrato->ContractExpiration()->format('Y/m/d')}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('dashboard', ['id' => $contrato->id])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Detalles">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a target="_blank" href="{{route('contract.generatePdf', ['id' => $contrato->id])}}" class="btn btn-info mx-1" data-toggle="tooltip" data-placement="top" title="Ver Contrato">
                                            <i class="fa fa-file-pdf"></i>
                                        </a>
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

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')
