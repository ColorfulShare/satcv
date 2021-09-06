@push('custom_js')
<script>
    $('.comuntable').DataTable({
        order: [[ 0, "desc" ]],
        responsive: true,
        searching: false,
        bLengthChange: true,
        pageLength: 10
    })

    $('#dataInversion').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('data.inversion') }}',
        columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fecha', name: 'fecha' },
                    { data: 'monto', name: 'monto' },
                    { data: 'capital', name: 'capital' },
                    { data: 'productividad', name: 'productividad' },
                    { data: 'retirado', name: 'retirado' },
                    { data: 'vencimiento', name: 'vencimiento' },
                    { data: 'accion', name: 'accion', orderable: false, searchable: false},
                ],
        columnDefs: [
                        {className: "dt-center text-center", "targets": "_all"}
                    ],
        responsive: true,
        order: [[ 0, "desc" ]],
        searching: true,
        bLengthChange: true,
        pageLength: 10,
    })

    $('#tableUtility').DataTable({
        order: [[ 0, "desc" ]],
        responsive: true,
        searching: true,
        bLengthChange: true,
        pageLength: 10
    })
</script>
@endpush