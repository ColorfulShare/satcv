@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
@include('contract.index-tablet')
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')
