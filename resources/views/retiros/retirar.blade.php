@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<div class="row">
    <div class="col-sm-4 col-12 mt-1">
        <div class="card h-80 p-2 art-2"> 
            <div class="row no-gutters">
                <div class="col-6">
                    <h6 class="float-right"><b>Saldo disponible: </b></h6>
                </div>
                <div class="col-6">
                    <h6 class=""><b > &nbsp $ {{$user->saldoDisponible()}}</b></h6>
                </div>
            </div>
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
                            <form action="" method="POST" target="_blank">
                                @csrf
                                <div class="modal-body">

                                    <div class="mb-1">
                                        <label for="wallet" class="form-label">Billetera:</label>
                                        <input type="text" min="500" class="form-control" id="wallet" name="wallet">
                                    </div>

                                    <div class="mb-1">
                                        <label for="codigo_correo" class="form-label">Código de correo:</label>
                                        <input type="text" min="500" class="form-control" id="codigo_correo" name="codigo_correo">
                                    </div>

                                    <div class="mb-1">
                                        <label for="authenticator" class="form-label">Código de google Authenticator:</label>
                                        <input type="text" min="500" class="form-control" id="authenticator" name="authenticator">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Accept</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical modal end-->

            
        </div>
    </div>
    
    <div class="col-sm-8 col-12 mt-1">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard p-0">
                    <div class="table-responsive">
                    <h3 class="text-white p-1">Billetera</h3>
                        <table class="table nowrap scroll-horizontal-vertical myTable2">
                            <thead>

                                <tr class="text-center text-dark text-uppercase pl-2">                                
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Email</th>
                                    <th>Monto</th>    
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
</div>
@endsection

@push('custom_js')
    <script>

    </script>
@endpush
