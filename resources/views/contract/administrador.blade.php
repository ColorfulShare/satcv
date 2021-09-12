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
                                  @foreach ($inversion as $item)
                                <tr class="text-center">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->invested}}</td>
                                    <td>{{$item->gain}}</td>
                                    <td>{{$item->capital}}</td>
                                    <td>{{$item->type_interes}}</td>
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