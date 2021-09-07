@push('custom_js')
<script>
    $('.comuntable').DataTable({
        order: [[ 0, "desc" ]],
        responsive: true,
        searching: false,
        bLengthChange: true,
        pageLength: 10
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