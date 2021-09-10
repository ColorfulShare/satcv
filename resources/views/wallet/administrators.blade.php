@extends('layouts/contentLayoutMaster')

@section('title', 'Administradores  de Carteras')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">

  <style>
      b{
          display: none;
      }
  </style>
@endsection

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
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped comuntable myTable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>correo</th>
                                <th>Estado</th>
                                <th>portafolio</th>
                                <th>Monto</th>
                                <th>Ganancia</th>
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
                                        <td>Eliminado</td>
                                        @endif

                                        <td>{{number_format($item->portafolio(), 2)}} $</td>
                                        <td>{{number_format($item->invertido(), 2)}} $</td>
                                        <td>{{number_format($item->ganancia(), 2)}} $</td>
                                        
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
                                                <div class="">
                                                    <label for="id" class="form-label">Id de usuario:</label>

                                                    <div class="input-group">
                                                        <input type="number" class="form-control" placeholder="Id de usuario" name="id" id="id" required>
                                                        <button class="btn btn-outline-primary" style="width: 30%; padding-top: 5px; padding-bottom: 5px;" type="button" id="btn_enviar">
                                                            <span id="text_btn_consultar">consultar</span>
                                                            <div class="d-inline" >
                                                                <div class="d-none spinner-border text-primary" role="status" id="spinner_enviar"></div>
                                                            </div>
                                                        </button>
                                                    </div>    

                                                    <label for="">Usuario</label>

                                                    <input type="text" readonly="true" name="user" id="user" required class="form-control">
                                                </div>
                                                
                                        
                                                <div class="mt-5 float-right">
                                                    <button type="button" class="btn btn-secondary">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                                </div>
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

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')

@section('vendor-script')
  <!-- vendor files -->
  {{--<script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>--}}
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
    <script src="{{ asset('js/scripts/forms/form-select2.js') }}"></script>
    <script>
        let btnUser = document.querySelector('#btn_enviar');
        let id = document.querySelector('#id');

        btnUser.addEventListener("click", function( event ) {
            //colocamos el spinner y ocultamos el texto
            let texBtnConsultar = document.querySelector('#text_btn_consultar');
            let spinnerBtnEnbiar = document.querySelector('#spinner_enviar');

            texBtnConsultar.classList.add('d-none');
            spinnerBtnEnbiar.classList.remove('d-none');
            //
            let data = {'id': id.value}
            console.log(data);
            
            fetch(`{{route("user.find")}}`, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify(data), // data can be `string` or {object}!
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            })   
            .then(response => {
                if (!response.ok) {
                    toastr['error'](response.statusText, 'Error', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    //removemos el spinner y colocamos el texto
                    spinnerBtnEnbiar.classList.add('d-none');
                    texBtnConsultar.classList.remove('d-none');
                    //
                    throw new Error(response.statusText)
            
                }else{
                    //removemos el spinner y colocamos el texto
                    spinnerBtnEnbiar.classList.add('d-none');
                    texBtnConsultar.classList.remove('d-none');
                    //
                    return response.json()
                }
            })
            .then(data => {
                console.log(data);
                let user = document.querySelector('#user');
                if(data.email != undefined){
                    user.value = data.email;
                }else{
                    user.value = '';
                }

                toastr['success'](data.message, 'Usuario consultado', {
                    closeButton: true,
                    tapToDismiss: false
                });
                
            })
            .catch(error => {
                console.log(error);
                //removemos el spinner y colocamos el texto
                spinnerBtnEnbiar.classList.add('d-none');
                texBtnConsultar.classList.remove('d-none');
                //
            })
        });
    </script>
@endsection