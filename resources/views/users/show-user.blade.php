@extends('layouts/contentLayoutMaster')

@section('title', 'Detalle de usuario')

@section('content')
<div class="row match-height d-flex justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->lastname }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha de nacimiento</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->birth }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Tipo de documento</label>
                                    @if(Auth::user()->document_type == '0')
                                    <input type="text" readonly class="form-control" value="DNI">
                                    @else
                                    <input type="text" readonly class="form-control" value="Pasaporte">
                                    @endif
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>N° de documento</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->dni }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha de expedicion del documento</label>
                                    <input type="text" readonly class="form-control"
                                        value="{{ $user->dni_expedition }}">
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
                                    <label class="h1 justify-content-center">Foto del Documento frontal</label>
                                    <img src="{{asset('storage/'.$user->photo_dni_front)}}"
                                        alt="{{ $user->photo_dni_front }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <div class="form-group">
                                    <label class="h1 justify-content-center">Foto del Documento trasera</label>
                                    <img src="{{asset('storage/'.$user->photo_dni_back)}}"
                                        alt="{{ $user->photo_dni_back }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <div class="form-group">
                                    <label class="h1 justify-content-center">Selfie con el documento</label>
                                    <img src="{{asset('storage/'.$user->selfie_document)}}"
                                        alt="{{ $user->selfie_document }}" class="img-fluid">
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
                                    <input type="text" readonly class="form-control" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Telefono movil</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->mobile_phone }}">
                                </div>
                            </div>
                            <h3 class="mt-3 mb-2 font-bold col-12 text-center">Información de Vivienda</h3>


                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" readonly class="form-control" value="{{ $country->name }}">
                                </div>
                            </div>


                            <div class="col-3">
                                <div class="form-group">
                                    <label>Barrio</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->district }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Ciudad</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->city }}">
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label>Departamento</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->department }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" readonly class="form-control" value="{{ $user->address }}">
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-center mt-3">
                                <div class="form-group">
                                    <label class="h1 justify-content-center">Recibo de servicios / Extracto bancario
                                        / Recibo de teléfono</label>
                                    <img src="{{asset('storage/'.$user->photo_document)}}" alt="{{ $user->dni }}"
                                        class="img-fluid">
                                </div>
                            </div>

                            <div class="col-12 mt-1 d-flex justify-content-around ">
                                <a href="{{ url()->previous() }}"
                                    class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Regresar
                                </a>
                                @if($user->verify == '0')
                                <a href="{{ route('verify-user', $user->id) }}"
                                    class="btn btn-success mr-1 mb-1 waves-effect waves-light">Verificar
                                </a>
                                <a class="btn btn-danger mr-1 mb-1 waves-effect waves-light" data-toggle="modal"
                                    data-target="#exampleModal">Rechazar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mensaje para el usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('deny-user', $user->id) }}" method="PATCH">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <textarea name="msj_admin" cols="45%" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
