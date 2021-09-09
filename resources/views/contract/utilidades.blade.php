@extends('layouts/contentLayoutMaster')

@section('title', 'Utilidades')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
<<<<<<< HEAD
                <div class="float-right">
                    <button class="btn btn-danger" id="btnModalCartera">Pagar administrador de cartera</button>
                    <button class="btn btn-danger" id="btnModalUtilidad">Pagar utilidad</button>
                </div>
                
=======
                <button class="btn btn-danger float-right" data-toggle="modal" data-target="#ModalUtilidad">Pagar
                    utilidad</button>
>>>>>>> f35607151b5c0e79a74521576cf3e54375e1b863
                <div class="card-title">
                    <h3>Utilidades</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100"
                        id="tableUtility">
                        <thead class="">

                            <tr class="text-center">
                                <th>Id</th>
                                <th>Fecha de pago</th>
                                <th>Porcentaje de rendimiento</th>
                                <th>Pagado</th>
                                <th>Lineal</th>
                                <th>Compuesto</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php
                            setlocale(LC_ALL, 'es');
                            @endphp
                            @foreach ($utilities as $utility)

                            <tr class="text-center">
                                <td>{{$utility->id}}</td>
                                <td>{{\Carbon\Carbon::parse($utility->payment_date)->format('Y-m-d')}}</td>
                                <td>{{number_format($utility->percentage, 2) }} %</td>
                                <td>{{$utility->gain}} $</td>
                                <td>{{$utility->amount_lineal()}} $</td>
                                <td>{{$utility->amount_compuesto()}} $</td>
                                {{--
                                <td>{{strftime("%B", \Carbon\Carbon::createFromFormat('!m',$utility->month)->getTimestamp())}}
                                </td>
                                --}}
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
{{--
<div class="modal fade" id="ModalCartera" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pagar Administrador de cartera</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="porcentaje_administrador" class="form-label">Porcentaje de administrador </label>
                        <input type="number" class="form-control" id="porcentaje_administrador" aria-describedby="porcentaje_administrador"
                            name="porcentaje_administrador" step="any">

                        <label for="porcentaje_cartera" class="form-label">Porcentaje de cartera </label>
                        <input type="number" class="form-control" id="porcentaje_cartera" aria-describedby="porcentaje_cartera"
                            name="porcentaje_cartera" step="any">
                        
                        <div class="mb-3">
                            <label for="mes" class="form-label">Mes</label>

                            <input class="form-control" type="date" name="mes" id="mes" min="{{$utilities->first() ? \Carbon\Carbon::parse($utilities->first()->payment_date)->addDay(1)->format('Y-m-d') : ''}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
            </form>
        </div>
    </div>
</div>
--}}

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
    
                            <label for="porcentaje_cartera" class="form-label">Porcentaje de cartera </label>
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
<!-- Vertical modal end-->
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
                            name="porcentaje" step="any">
                        <div class="mb-3">
                            <label for="mes" class="form-label">Mes</label>

                            <input class="form-control" type="date" name="mes" id="mes" min="{{$utilities->where('type', 0)->first() ? \Carbon\Carbon::parse($utilities->where('type', 0)->first()->payment_date)->addDay(1)->format('Y-m-d') : ''}}">
                            {{--
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
                            --}}
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

@push('custom_js')
    <script>
        let btnModalCartera = document.querySelector('#btnModalCartera');

        btnModalCartera.addEventListener("click", function( event ) {

            let myModal = new bootstrap.Modal(document.getElementById('ModalCartera'), {
                keyboard: false
            })

            myModal.show();
            
        }, false);

        let btnModalUtilidad = document.querySelector('#btnModalUtilidad');

        btnModalUtilidad.addEventListener("click", function( event ) {

            let myModalUtilidad = new bootstrap.Modal(document.getElementById('ModalUtilidad'), {
                keyboard: false
            })

            myModalUtilidad.show();
            
        }, false);

    </script>
@endpush