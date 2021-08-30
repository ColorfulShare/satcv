@extends('layouts/contentLayoutMaster')

@section('title', 'Liquidaciones de Capital')

@section('content')
<div id="settlement">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                          <h1>Historial de Liquidaciones</h1>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-darck bg-purple-alt2">
                                    <th>ID</th>
                                    <th>usuario</th>
                                    <th>Monto</th>
                                    <th>Feed</th>
                                    <th>Hash</th>
                                    <th>Billetera</th>
                                    <th>estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($liquidation as $item)
                                <tr class="text-center">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->user_id}}</td>
                                    <td>{{$item->total_amount}}</td>
                                    <td>{{$item->feed}}</td>
                                    <td>{{$item->hash}}</td>
                                    <td>{{$item->wallet_used}}</td>
                                     @if ($item->status == '0')
                                    <td>En espera</td>
                                    @elseif($item->status == '1')
                                    <td>Pagado</td>
                                    @elseif($item->status == '2')
                                    <td>Cancelado</td>
                                    @endif
                                    <td>{{date('Y-M-d', strtotime($item->created_at))}}</td>
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