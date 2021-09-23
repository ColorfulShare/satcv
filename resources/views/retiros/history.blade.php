@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                <div class="card-title">
                    <h3>Historial de Retiros</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped myTable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>Email</th>
                                <th>Contrato</th>
                                <th>Cantidad</th>
                                <th>fee</th>
                                <th>Monto</th>
                                <th>Billetera</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liquidaciones as $retiro)
                            <tr class="text-center">
                                <td>{{$retiro->id}}</td>
                                <td>{{$retiro->user->email}}</td>
                                <td>N°. {{$retiro->contract_id}}</td>
                                <td>{{number_format($retiro->amount, 2)}} $</td>
                                <td>{{number_format($retiro->feed, 2)}} $</td>
                                <td>{{number_format($retiro->total_amount, 2)}} $</td>
                                <td>{{$retiro->wallet_used}}</td>
                                <td>
                                    @if($retiro->type == 0)
                                    Solicitud
                                    @else
                                    Rendimiento
                                    @endif
                                </td>
                                <td>{{$retiro->created_at->format('Y/m/d')}}</td>
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
