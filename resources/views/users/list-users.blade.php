
@extends('layouts/contentLayoutMaster')


@section('title', 'Lista de Usuarios')

@section('content')
<!-- Basic Tables start -->
<div id="record">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <h1>Lista de Usuarios</h1>
                        <p> <img src="{{asset('assets/img/sistema/btn-plus.png')}}" alt=""></p>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                            
                            <thead class="">
                                <tr class="text-center text-dark bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>KYC</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($user as $item)
                                   <tr class="text-center">
                                        <td>{{ $item->id}}</td>
                                        <td>{{ $item->email}}</td>

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
                                   
                                        <td>
                                            <a href="{{route('dashboard2', ['id' => $item->id])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Detalles">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            {{-- @if ($item->verify == '0' && $item->dni != NULL)
                                                <a href="{{ route('users.show-user',$item->id) }}" class="btn btn-warning text-bold-600"><i data-feather='pencil'></i></a>
                                                <a href="{{ route('users.show-user',$item->id) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Verificar KYC"><i data-feather='edit'></i></a>
                                            @else
                                                <a href="{{ route('users.show-user',$item->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Ver todos los datos del usuario"><i data-feather='eye'></i></a>
                                            @endif --}}
                                        </td>
                                        </button>
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

