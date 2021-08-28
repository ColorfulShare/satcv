@extends('layouts/contentLayoutMaster')

@section('title', 'Inversiones')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                    <div class="card-title">
                        <h3>Inversiones</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                            <thead class="">
                                <tr class="text-center bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Saldo Capital</th>
                                    <th>Productividad</th>
                                    <th>Retirado</th>
                                    <th>Vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contratos as $contrato)
                                <tr class="text-center bg-purple-alt2">
                                    <td>{{$contrato->id}}</td>
                                    <td>{{date_format($contrato->created_at,"Y/m/d");}}</td>
                                    <td>{{$contrato->getOrden->amount}}</td>
                                    <td>{{$contrato->capital}}</td>
                                    <td>{{$contrato->gain}}</td>
                                    <td>0</td>
                                    <td>{{date_format($contrato->contractExpiration(), 'Y/m/d')}}</td>
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
