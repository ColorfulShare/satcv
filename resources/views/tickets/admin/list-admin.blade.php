@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de tickets')

@section('content')
<div class="col-12 pb-1">
    <div class="card">
        <div class="card-content">
            <div class="card-body card-dashboard">
                <div class="table-responsive">
                    <div class="d-flex justify-content-between mb-2">
                        <h1>Historial de Tickets</h1>
                    </div>
                    <table class="table scroll-horizontal-vertical myTable text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Prioridad</th>
                                {{-- <th>tiempo</th> --}}
                                <th>Fecha de creacion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket as $item)
                            <tr>
                                <td>{{ $item->id}}</td>
                                <td>{{ $item->getUser->name}}</td>
                                <td>{{ $item->getUser->email}}</td>

                                @if ($item->status == '0')
                                <td> <a class="btn btn-success">Abierto</a></td>
                                @elseif($item->status == '1')
                                <td> <a class="btn btn-danger">Cerrado</a></td>
                                @endif

                                @if ($item->priority == '0')
                                <td><h4>Alto</h4></td>
                                @elseif($item->priority == '1')
                                <td><h4>Medio</h4></td>
                                @elseif($item->priority == '2')
                                <td><h4>Bajo</h4></td>
                                @endif

                                {{-- @if ($time_msj != 'NULL') 
                                    <td>{{$time_msj}}</td>
                                @else
                                <td>Esperando Respuesta</td>
                                @endif --}}
                                <td>{{date('d-M-Y', strtotime($item->created_at))}}</td>

                                <td><a href="{{ route('ticket.edit-admin',$item->id) }}" class="btn btn-primary">Revisar</a></td>
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
