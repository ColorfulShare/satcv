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
                                    <td>{{$referido->invested}}</td>
                                    <td>{{$referido->gain}}</td>
                                    <td>{{$referido->capital}}</td>
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

@endsection