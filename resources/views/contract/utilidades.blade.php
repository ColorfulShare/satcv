@extends('layouts/contentLayoutMaster')

@section('title', 'Utilidades')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                <button class="btn btn-danger float-right" data-toggle="modal" data-target="#ModalUtilidad">Pagar
                    utilidar</button>
                <div class="card-title">
                    <h3>Utilidades</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100"
                        id="tableUtility">
                        <thead class="">

                            <tr class="text-center">
                                <th>Id</th>
                                <th>ganancia</th>
                                <th>Porcentaje</th>
                                <th>mes</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php
                            setlocale(LC_ALL, 'es');
                            @endphp
                            @foreach ($utilities as $utility)

                            <tr class="text-center">
                                <td>{{$utility->id}}</td>
                                <td>{{$utility->gain}}</td>
                                <td>{{$utility->percentage * 100}} %</td>
                                <td>{{strftime("%B", \Carbon\Carbon::createFromFormat('!m',$utility->month)->getTimestamp())}}
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
<div class="modal fade" id="ModalUtilidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pagar utilidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('payUtility')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="porcentaje" class="form-label">Porcentaje</label>
                        <input type="number" class="form-control" id="porcentaje" aria-describedby="porcentaje"
                            name="porcentaje">
                        <div class="mb-3">
                            <label for="mes" class="form-label">Mes</label>
                            <select name="mes" id="mes" required class="form-control form-select">
                                <option value="">Seleccione un mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')
