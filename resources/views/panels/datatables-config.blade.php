@push('custom_js')
<script>
    $('.comuntable').DataTable({
        order: [[ 0, "desc" ]],
        responsive: true,
        searching: true,
        bLengthChange: true,
        pageLength: 10
    })

    $('#dataInversion').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('data.inversion') }}',
        columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'documento', name: 'documento' },
                    { data: 'correo', name: 'correo' },
                    { data: 'fecha', name: 'fecha' },
                    { data: 'accion', name: 'accion', orderable: false, searchable: false},
                ],
            responsive: true,
            order: [[ 0, "desc" ]],
            searching: true,
            bLengthChange: true,
            pageLength: 10,
    });

    $('#tableUtility').DataTable({
        order: [[ 0, "desc" ]],
        responsive: true,
        searching: true,
        bLengthChange: true,
        pageLength: 10
    })
</script>
@endpush