@extends('layouts/contentLayoutMaster')

@section('title', 'Sostenibilidad')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="d-flex justify-content-around">
                <div class="col-4 bg-light py-2 mt-2 text-center rounded">
                    <div class="card-title">
                        <h3 class="mb-2">Solicitud de retiros por Efectivo</h3>
                        <span class="rounded bg-primary px-2 py-1 text-white">{{count($solicitudes->where('wallet_used', '=', 'Efectivo'))}}</span>
                    </div>
                </div>
                <div class="col-4 bg-light py-2 mt-2 text-center rounded">
                    <div class="card-title">
                        <h3 class="mb-2">Solicitud de retiros por Wallet</h3>
                        <span class="rounded bg-primary px-2 py-1 text-white">{{count($solicitudes->where('wallet_used', '!=', 'Efectivo'))}}</span>
                    </div>
                </div>
            </div>
            <div class="card-body card-dashboard">
                <div class="card-title">
                    <h3>Sostenibilidad</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped myTable">
                        <thead class="">
                            <tr class="text-center text-dark text-uppercase pl-2">
                                <th>ID</th>
                                <th>Email</th>
                                <th>Monto</th>
                                <th>Tipo Retiro</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitudes as $solicitud)
                                <tr class="text-center">
                                    <th>{{$solicitud->id}}</th>
                                    <th>{{$solicitud->user->email}}</th>
                                    <th>{{$solicitud->amount}}</th>
                                    @if($solicitud->wallet_used == 'Efectivo')
                                    <th>Por {{$solicitud->wallet_used}}</th>
                                    @else
                                    <th>
                                        <p>Por Wallet: {{$solicitud->wallet_used}}</p>
                                        
                                    </th>
                                    @endif
                                    <th>{{$solicitud->created_at->format('d/m/Y')}}</th>
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
