@extends('layouts/contentLayoutMaster')

@section('title', 'Utilidades')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">

                <div class="float-right">
                    <button class="btn btn-danger" id="btnModalCartera">Pagar utilidad</button>
                </div>
                

                <div class="card-title">
                    <h3>Utilidades Cartera</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100"
                        id="tableUtility">
                        <thead class="">

                            <tr class="text-center">
                                <th>Id</th>
                                <th>Fecha de pago</th>
                                <th>% Administrador</th>
                                <th>% Cartera</th>
                                <th>Pagado</th>
                                <th>Lineal</th>
                                <th>Compuesto</th>
                                <th>Comisión</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($utilities as $utility)

                            <tr class="text-center">
                                <td>{{$utility->id}}</td>
                                <td>{{\Carbon\Carbon::parse($utility->payment_date)->format('Y-m-d')}}</td>
                                <td>{{number_format($utility->percentage, 2) }} %</td>
                                <td>{{number_format($utility->percentage_cartera, 2)}} $</td>
                                <td>{{number_format($utility->gain + $utility->gain_cartera , 2)}} $</td>
                                <td>{{number_format($utility->amount_lineal(), 2)}} $</td>
                                <td>{{number_format($utility->amount_compuesto(), 2)}} $</td>
                                <td>{{number_format($utility->comision(), 2)}} $</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Administrador de cartera-->

<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="ModalCartera" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Retirar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('payUtilityCartera')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="porcentaje_administrador" class="form-label">Porcentaje de administrador </label>
                            <input type="number" class="form-control" id="porcentaje_administrador" aria-describedby="porcentaje_administrador"
                                name="porcentaje_administrador" step="any">
    
                            <label for="porcentaje_cartera" class="form-label">Porcentaje de inversión </label>
                            <input type="number" class="form-control" id="porcentaje_cartera" aria-describedby="porcentaje_cartera"
                                name="porcentaje_cartera" step="any">
                            
                            <div class="mb-3">
                                <label for="mes" class="form-label">Mes</label>
    
                                <input class="form-control" type="date" name="mes" id="mes" min="{{$utilities->where('type', 1)->first() ? \Carbon\Carbon::parse($utilities->where('type', 1)->first()->payment_date)->addDay(1)->format('Y-m-d') : ''}}">
                            </div>
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
</div>

@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')

@push('custom_js')
    <script>
        let btnModalCartera = document.querySelector('#btnModalCartera');

        btnModalCartera.addEventListener("click", function( event ) {

            let myModal = new bootstrap.Modal(document.getElementById('ModalCartera'), {
                keyboard: false
            })

            myModal.show();
            
        }, false);

    </script>
@endpush