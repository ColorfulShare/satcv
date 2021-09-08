@extends('layouts/contentLayoutMaster')

@section('title', 'Inversiones')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                    <div class="card-title">
                        <h3>Inversiones</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 nowrap scroll-horizontal-vertical table-striped comuntable">
                            <thead class="">
                                <tr class="text-center bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Invertido</th>
                                    <th>Saldo Capital</th>
                                    <th>Productividad</th>
                                    <th>Retirado</th>
                                    <th>Tipo</th>
                                    <th>Vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contratos as $contrato)
                                <tr class="text-center bg-purple-alt2">
                                    <td>{{$contrato->id}}</td>
                                    <td>{{$contrato->created_at->format('Y/m/d')}}</td>
                                    <td>{{$contrato->invested}}</td>
                                    <td>{{$contrato->capital}}</td>
                                    <td>{{$contrato->productividad()}}</td>
                                    <td>{{$contrato->retirado()}}</td>
                                    <td>{{ucwords($contrato->type_interes)}}</td>
                                    <td>{{$contrato->contractExpiration()->format('Y/m/d')}}</td>
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
