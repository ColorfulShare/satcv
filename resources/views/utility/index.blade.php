@extends('layouts/contentLayoutMaster')

@section('title', 'Utilidades')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                <div class="card-title">
                    <h3>Utilidades</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100 text-center"
                        id="informeUtility">
                        <thead class="">

                            <tr class="">
                                <th>Id</th>
                                <th>Contrato</th>
                                <th>Correo</th>
                                <th>Monto</th>
                                <th>Porcentaje</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>

                        </thead>
                        <tbody>
                    
                        </tbody class="text-center">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom_js')
    <script>
        $('#informeUtility').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("utilidad.dataUtilityServerSide") }}',
            columns: [
                        { data: 'id', name: 'id', orderable: true, searchable: true },
                        { data: 'contract_id', name: 'contract_id', orderable: true, searchable: true },
                        { data: 'Correo', name: 'user.email', orderable: true, searchable: true },
                        { data: 'cantidad', name: 'amount', orderable: true, searchable: true},
                        { data: 'porcentaje', name: 'porcentaje', orderable: true, searchable: true },
                        { data: 'estado', name: 'estado', orderable: true, searchable: true },
                        { data: 'fecha', name: 'created_at', orderable: true, searchable: true }
                    ],
            responsive: true,
            order: [[ 0, "desc" ]],
            searching: true,
            bLengthChange: true,
            pageLength: 10,
            language: {
                processing:     "Procesando...",
                search:         "",
                searchPlaceholder: "Buscar",
                info:           "",
                lengthMenu:     "Mostrar _MENU_ Utilidades",
                infoEmpty:      "Vacío",
                infoFiltered:   "Información refinada",
                infoPostFix:    "",
                loadingRecords: "Procesando...",
                zeroRecords:    "Vacio",
                emptyTable:     "Vacio",
                paginate: {
                    first:      "Primero",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Último"
                },
                aria: {
                    sortAscending:  ": Ordenar ascendente",
                    sortDescending: ": Ordenar descendente"
                }
            },
        })
    </script>    
@endpush