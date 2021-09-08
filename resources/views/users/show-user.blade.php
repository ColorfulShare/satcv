@extends('layouts/contentLayoutMaster')

@section('title', 'Detalle de usuario')

@section('content')
<div class="row match-height d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="form-body">

                        <form action="">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Apellido</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->lastname }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Fecha de nacimiento</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->birth }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Número de documento de identidad o pasaporte</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->dni }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Fecha de expedicion del documento</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->dni_expedition }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Ciudad de expedición del documento</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->city_dni }}">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center mt-3">
                                    <div class="form-group">
                                        <label class="h1 justify-content-center">Foto del Documento</label>
                                        <img src="{{asset('storage/'.$user->photo_dni)}}" alt="{{ $user->dni }}"
                                            class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Telefono Fijo</label>
                                        <input type="text" readonly class="form-control" value="{{ $user->phone }}"
                                            >
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Telefono movil</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $user->mobile_phone }}" >
                                    </div>
                                </div>
                                <h3 class="mt-3 mb-2 font-bold col-12 text-center">Información de Vivienda</h3>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $user->address }}">
                                    </div>
                                </div>
       
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Barrio</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $user->district }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Ciudad</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $user->city }}">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $user->department }}">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center mt-3">
                                    <div class="form-group">
                                        <label class="h1 justify-content-center">Recibo de servicios / Extracto bancario / Recibo de teléfono</label>
                                        <img src="{{asset('storage/'.$user->photo_document)}}" alt="{{ $user->dni }}"
                                            class="img-fluid">
                                    </div>
                                </div>


              
                                <div class="col-12 mt-1 d-flex justify-content-around ">
                                    <a href="{{ url()->previous() }}"
                                        class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Regresar
                                    </a>
                                    <a href="{{ route('verify-user', $user->id) }}"
                                        class="btn btn-success mr-1 mb-1 waves-effect waves-light">Verificar
                                    </a>
                                    <a href="{{ route('deny-user', $user->id) }}"
                                        class="btn btn-danger mr-1 mb-1 waves-effect waves-light">Rechazar
                                    </a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
