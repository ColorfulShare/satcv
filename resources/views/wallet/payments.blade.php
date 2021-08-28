@extends('layouts/contentLayoutMaster')

@section('title', 'Retiros Realizados')

@section('content')
<div id="payments">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                          <h1>Retiros Realizados</h1>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-darck bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Fecha</th> 
                                    <th>Billetera</th>
                                    <th>Monto</th>
                                    <th>Hash</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach ($payments as $item)
                                <tr class="text-center">
                                    <td>{{$item->id}}</td>
                                    <td>{{date('Y-M-d', strtotime($item->created_at))}}</td>
                                    <td>{{$item->wallet_used}}</td>
                                    <td>{{$item->total_amount}}</td>
                                    <td>{{$item->hash}}</td>
                                    @if ($item->status == '0')
                                    <td>En espera</td>
                                    @elseif($item->status == '1')
                                    <td>Pagado</td>
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

@endsection