{{-- Vendor Scripts --}}
    <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}

    <script src="{{ asset(mix('js/app.js')) }}" defer></script> 
    <script src="{{ asset('js/core/app.js') }}"></script>
    <script src="{{ asset('js/core/app-menu.js') }}"></script>
    @if($configData['blankPage'] === false)
    <script src="{{ asset('js/scripts/customizer.js') }}"></script>
    @endif

    
{{-- page script --}}
    @yield('page-script')
    <script defer>
            let container = document.querySelector('#content');
            let sidebar = document.querySelector('.main-menu');
            sidebar.addEventListener('mouseenter', function(){
                container.classList.remove('contenedorwidth');
            })
            sidebar.addEventListener('mouseleave', function(){
                container.classList.add('contenedorwidth');
            })
        
    </script>
    @stack('custom_js')
    
{{-- page script --}}
