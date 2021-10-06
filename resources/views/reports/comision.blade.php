@extends('layouts/contentLayoutMaster')

@section('title', 'Comision')

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
                                        <th>Id</th>
                                        <th>Para</th>
                                        <th>Contrato</th>
                                        <th>Monto</th>
                                        <th>Porcentaje</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    @foreach ($wallets as $wallet)
                                        <tr class="text-center">
                                            <td>{{$wallet->id}}</td>
                                            <td>{{$wallet->user->email}}</td>
                                            <td>{{$wallet->contract_id}}</td>
                                            <th>{{number_format($wallet->amount, 2)}} $</th>
                                            <td>{{$wallet->percentage * 100}} %</td>
                                            <td>
                                                @if($wallet->status == 0) En espera
                                                @elseif($wallet->status == 1) Pagado
                                                @elseif($wallet->status == 2) Cancelado
                                                @endif
                                            </td>
                                            <td>{{$wallet->created_at->format('Y-m-d')}}</td>
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