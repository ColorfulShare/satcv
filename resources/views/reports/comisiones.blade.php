@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de comisiones')

@section('content')
    <div id="logs-list">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                                <thead class="">

                                    <tr class="text-center">                                
                                        <th>ID</th>
                                        <th>Correo</th>
                                        <th>Contrato</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    @foreach ($comisiones as $comision)
                                        <tr class="text-center">
                                            <td>{{$comision->id}}</td>
                                            <td>{{$comision->user->email}}</td>
                                            <td>{{$comision->contract_id}}</td>
                                            <td>{{number_format($comision->amount, 2)}} $</td>
                                            <td>
                                                @if($comision->status == 0) <span class="btn btn-warning">En espera</span>
                                                @elseif($comision->status == 1) <span class="btn btn-success">Pagado (liquidado)</span>
                                                @elseif($comision->status == 2) <span class="btn btn-danger">Cancelado</span>
                                                @elseif($comision->status == 3) <span class="btn btn-info">Reinvertido</span>
                                                @endif
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
    </div>
@endsection


{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')