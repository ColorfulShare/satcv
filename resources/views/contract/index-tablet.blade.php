
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                <div class="card-title">
                    <h3>Inversión</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped myTable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Correo</th>
                                <th>Invertido</th>
                                <th>Saldo Capital</th>
                                <th>Ganancia</th>
                                <th>Retirado</th>
                                <th>Tipo</th>
                                <th>Vencimiento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contratos as $contrato)
                            <tr class="text-center">
                                <td>{{$contrato->id}}</td>
                                <td>{{$contrato->created_at->format('Y/m/d')}}</td>
                                <td>{{$contrato->user()->email}}</td>
                                <td>{{number_format($contrato->invested, 2, '.', '')}}</td>
                                <td>{{number_format($contrato->capital, 2, '.', '')}}</td>
                                <td>{{number_format($contrato->gain, 2, '.', '')}}</td>
                                <td>{{number_format($contrato->retirado(), 2, '.', '')}}</td>
                                <td>{{ucwords($contrato->type_interes)}}</td>
                                <td>{{$contrato->ContractExpiration()->format('Y/m/d')}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('dashboard', ['id' => $contrato->id])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Detalles">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a target="_blank" href="{{route('contract.generatePdf', ['id' => $contrato->id])}}" class="btn btn-info mx-1" data-toggle="tooltip" data-placement="top" title="Ver Contrato">
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
