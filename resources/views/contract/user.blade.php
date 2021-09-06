@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Vertical modal -->
                <div class="vertical-modal-ex">
                    <button type="button" class="btn btn-outline-primary float-right" data-toggle="modal"
                        data-target="#exampleModalCenter">
                        Invertir
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Invertir</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('shop.procces')}}" method="POST" target="_blank">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="mb-1">
                                            <label for="monto" class="form-label" style="font-size: 1em;">Cantidad a invertir:</label>
                                            <input type="number" min="500" class="form-control" id="monto" name="monto">
                                        </div>

                                        <div class="mb-1">
                                            <label class="d-block">Interes:</label>
                                            <div class="form-check form-check-inline">
                                                <input required class="form-check-input" type="radio"
                                                    id="inlineCheckbox1" name="interes" value="lineal">
                                                <label class="form-check-label" for="inlineCheckbox1">Lineal (12
                                                    meses)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input required class="form-check-input" type="radio"
                                                    id="inlineCheckbox2" name="interes" value="compuesto">
                                                <label class="form-check-label" for="inlineCheckbox2">Compuesto (12
                                                    meses)</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"> Invertir</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Vertical modal end-->

                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped comuntable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>Invertido</th>
                                <th>Saldo Capital</th>
                                <th>Ganancia</th>
                                <th>Productividad</th>
                                <th>Retirado</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Vencimiento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos as $contrato)
                            <tr class="text-center bg-purple-alt2">
                                <td>{{$contrato->id}}</td>
                                <td>{{$contrato->invested}}</td>
                                <td>{{$contrato->capital}}</td>
                                <td>{{$contrato->gain}}</td>
                                <td>{{$contrato->productividad()}}</td>
                                <td>{{$contrato->retirado()}}</td>
                                <td>{!!$contrato->estado()!!}</td>
                                <td>{{$contrato->created_at->format('Y/m/d')}}</td>
                                <td>{{$contrato->contractExpiration()->format('Y/m/d')}}</td>
                                <td>
                                    <a href="{{ route('dashboard', ['id' => $contrato->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Ver Contrato"><i class="fa fa-eye"></i></a>
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

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')
