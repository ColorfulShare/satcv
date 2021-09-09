@extends('layouts/contentLayoutMaster')

@section('title', 'Administradores  de Carteras')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Vertical modal -->
                <div class="vertical-modal-ex">
                    <button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#ModalAdministrador">
                       nuevo adminitrador de cartera
                    </button>
            
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped comuntable mt-5">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>correo</th>
                                <th>Estado</th>
                                <th>portafolio</th>
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
                                   </tr>
                                     <!-- Modal -->
                          
                            <div class="modal fade" id="ModalAdministrador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Seleccionar Nuevo Administrador</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('cambiarTipo') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="type" class="form-label">Usuario</label>
                                                   <select name="id" required class="form-control">
                                                   @foreach($alluser as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                   @endforeach
                                                   </select>   
                                             
                                                <div class="mt-5 float-right">
                                                    <button type="button" class="btn btn-secondary">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
          
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection