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
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
            <form action="" method="">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="porcentaje" class="form-label">Usuario</label>
                        <input type="number" class="form-control" id="porcentaje" aria-describedby="porcentaje"
                            name="porcentaje" step="any">
                      
                 
                    <div class="mt-5 float-right">
                        <button type="button" class="btn btn-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection


 