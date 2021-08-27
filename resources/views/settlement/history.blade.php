@extends('layouts/contentLayoutMaster')

@section('title', 'liquidaciones de comision')

@section('content')
<div id="settlement">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                          <h1>Historial de Liquidaciones</h1>
                        <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-darck bg-purple-alt2">
                                    <th>ID</th>
                                    <th>usuario</th>
                                    <th>Monto</th>
                                    <th>Feed</th>
                                    <th>Hash</th>
                                    <th>Billetera</th>
                                    <th>estado</th>
                                    <th>Fecha</th>
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
@endsection