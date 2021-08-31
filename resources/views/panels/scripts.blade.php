{{-- Vendor Scripts --}}
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.3.1/dt-1.11.0/datatables.min.js"></script>

<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
@if($configData['blankPage'] === false)
<script src="{{ asset('js/scripts/customizer.js') }}"></script>
@endif
{{-- page script --}}
@yield('page-script')
@stack('custom_js')
{{-- page script --}}
