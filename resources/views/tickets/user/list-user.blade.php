@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de tickets')

@section('content')
<div class="col-12">
    <div class="card bg-lp">
        <div class="card-content">
            <div class="card-body card-dashboard">
                <div class="table-responsive">
                    <h1>Historial de Tickets</h1>
                    <a href="{{ route('ticket.create')}}" class="btn btn-primary mb-2 waves-effect waves-light"><i
                            class="feather icon-plus"></i>&nbsp; Crear Ticket</a>
                    <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                        <thead>

                            <tr class="text-center bg-purple-alt2">
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
                            <tr class="text-center ">
                                <td>{{ $item->id}}</td>
                                <td>{{ $item->getUser->name}}</td>
                                <td>{{ $item->getUser->email}}</td>

                                @if ($item->status == '0')
                                <td> <a class="btn btn-success  text-bold-600">Abierto</a></td>
                                @elseif($item->status == '1')
                                <td> <a class="btn btn-danger  text-bold-600">Cerrado</a></td>
                                @endif

                                @if ($item->priority == '0')
                                <td> <a class="text-uppercase">Alto</a></td>
                                @elseif($item->priority == '1')
                                <td> <a class="text-uppercase">Medio</a></td>
                                @elseif($item->priority == '2')
                                <td> <a class="text-uppercase">Bajo</a></td>
                                @endif

                                {{-- @if ($time_msj != 'NULL')
                                    <td>{{$time_msj}}</td>
                                @else
                                <td>Esperando Respuesta</td>
                                @endif --}}

                                <td>{{date('d-M-Y', strtotime($item->created_at))}}</td>

                                @if ($item->status == '0')
                                <td><a href="{{ route('ticket.edit-user',$item->id) }}"
                                        class="btn btn-primary text-bold-600">Editar</a></td>
                                @else
                                <td><a href="{{ route('ticket.show-user',$item->id) }}"
                                        class="btn btn-primary text-bold-600">Revisar</a></td>
                                @endif
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
