@extends('layouts/contentLayoutMaster')

@section('title', 'Liquidaciones de comision')

@section('content')
<div id="liquidations">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                          <h1>Historial de Liquidaciones</h1>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-darck bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Correo</th>
                                    <th>Monto</th>
                                    <th>tipo</th>
                                    <th>estado</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($liquidation as $item)
                                <tr class="text-center">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->user->email}}</td>
                                    <td>{{$item->total_amount}}</td>
                                    @if ($item->type == '0')
                                    <td>Solicitud</td>
                                    @elseif($item->type == '1')
                                    <td>Rendimientos</td>
                                    @endif
                                     @if ($item->status == '0')
                                    <td>En espera</td>
                                    @elseif($item->status == '1')
                                    <td>Completado</td>
                                    @elseif($item->status == '2')
                                    <td>Cancelado</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       </div>
@endsection
{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')