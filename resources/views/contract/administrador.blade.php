@extends('layouts/contentLayoutMaster')

@section('title', 'Inversiones')

@section('content')
<div id="payments">
    <div class="card">
        <div class="card-content">
            <div class="card-body card-dashboard">
                <div class="table-responsive">
                    <h1>Contratos</h1>
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped">
                        <thead class="">
                            <tr class="text-center text-darck bg-purple-alt2">
                                <th>ID</th>
                                <th>Correo</th>
                                <th>Invertido</th>
                                <th>ganancia</th>
                                <th>Capital</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $referido)
                            <tr class="text-center">
                                <td>{{$referido->id}}</td>
                                <td>{{$referido->user()->email}}</td>
                                <td>{{$referido->invested}}</td>
                                <td>{{number_format($referido->gain, 2, '.', '')}}</td>
                                <td>{{number_format($referido->capital, 2, '.', '')}}</td>
                                <td>{{$referido->type_interes}}</td>
                                @if ($referido->status == '1')
                                <td>Activo</td>
                                @elseif($referido->status == '2')
                                <td>Culminado</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <br>
        <br>
        <br> 
        
        @include('contract.index-tablet')
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')
