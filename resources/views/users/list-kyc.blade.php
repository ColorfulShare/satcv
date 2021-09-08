@extends('layouts/contentLayoutMaster')


@section('title', 'Lista de Usuarios')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-content">
            <div class="card-body card-dashboard">
                <div class="table-responsive">
                    <h1>Usuarios por verificar</h1>
                    <p> <img src="{{asset('assets/img/sistema/btn-plus.png')}}" alt=""></p>
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                        <thead>
                            <tr class="text-center text-dark bg-purple-alt2">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                                <th>KYC</th>
                                <th>Datos</th>
                                <th>Ultima Actualizacion</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                            <tr class="text-center">
                                <td>{{ $item->id}}</td>
                                <td>{{ $item->name}}</td>

                                @if ($item->status == '0')
                                <td>Inactivo</td>
                                @elseif($item->status == '1')
                                <td>Activo</td>
                                @elseif($item->status == '2')
                                <td>Suspendido</td>
                                @elseif($item->status == '3')
                                <td>Bloqueado</td>
                                @elseif($item->status == '4')
                                <td>Caducado</td>
                                @elseif($item->status == '5')
                                <td>Eliminado</td>
                                @endif

                                @if ($item->verify == '0')
                                <td>Pendiente</td>
                                @elseif($item->verify == '1')
                                <td>Verificado</td>
                                @elseif($item->verify == '2')
                                <td>Rechazado</td>
                                @endif

                                @if ($item->dni != NULL)
                                <td>Pendiente por verificar</td>
                                @else
                                <td>Falta datos</td>
                                @endif

                                <td>{{ $item->updated_at}}</td>

                                <td>
                                    <a href="{{ route('users.show-user',$item->id) }}" class="btn btn-primary"
                                        data-toggle="tooltip" data-placement="left"
                                        title="Verificar usuario"><i data-feather='eye'></i></a>
                                </td>
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
