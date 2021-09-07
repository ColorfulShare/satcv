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
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped comuntable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Saldo Capital</th>
                                <th>Productividad</th>
                                <th>Retirado</th>
                                <th>Vencimiento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contratos as $contrato)
                            <tr class="text-center">
                                <td>{{$contrato->id}}</td>
                                <td>{{$contrato->created_at->format('Y/m/d')}}</td>
                                <td>{{$contrato->getOrden->amount}}</td>
                                <td>{{$contrato->capital}} %</td>
                                <td>{{$contrato->productividad()}} %</td>
                                <td>{{$contrato->retirado()}} %</td>
                                <td>{{$contrato->ContractExpiration()->format('Y/m/d')}} %</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('dashboard')}}/?id={{$contrato->id}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Detalles">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-info mx-1" data-toggle="tooltip" data-placement="top" title="Ver Contrato">
                                            <i class="fa fa-file-pdf"></i>
                                        </a>
                                    </div>
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

<!-- Modal -->
<div class="modal fade" id="form-pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
    document.addEventListener('DOMContentLoaded', function () {
        $('#form-pdf').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data().id;
            $("#idContract").val(id);
        })
    })

</script>
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')
