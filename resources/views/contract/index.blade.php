@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                    <div class="card-title">
                        <h3>Contratos</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 nowrap scroll-horizontal-vertical table-striped" id="dataInversion">
                            <thead class="">
                                <tr class="text-center bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>N° Documento</th>
                                    <th>Correo</th>
                                    <th>Fecha</th>
                                    <th>Accion</th>
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
<div class="modal fade" id="form-pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Subir PDF</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('contract.pdf') }}" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
                @csrf
                <input type="hidden" id="idContract" name="idContract">
                <input type="file" name="urlpdf" accept="application/pdf" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Subir archivo</button>
            </div>
        </form>
        </div>
    </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function(){
          $('#form-pdf').on('show.bs.modal', function(e) {    
              var id = $(e.relatedTarget).data().id;
              $("#idContract").val(id);
          })
      })
  </script>
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config'); 

