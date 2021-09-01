@extends('layouts/contentLayoutMaster')

@section('title', 'Detalle de usuario')

@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height d-flex justify-content-center">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->name }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Apellido</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->lastname }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Fecha de nacimiento</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->birth }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->email }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" readonly id="whatsapp" class="form-control"
                                                value="{{ $user->phone }}" name="whatsapp">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Telefono movil</label>
                                            <input type="text" readonly id="whatsapp" class="form-control"
                                                value="{{ $user->mobile_phone }}" name="whatsapp">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Localizacion</label>
                                            <input type="text" readonly id="locatizacion" class="form-control"
                                                value="{{ $user->location_id }}" name="localizacion">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Dni</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->dni }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Foto del DNI</label>
                                            <img src="{{asset('storage/'.$user->photo_dni)}}" alt="{{ $user->dni }}"
                                            class="h-100 w-200 object-cover">
                                                            </div>
                                    </div>

                                    @if ($user->verify != '1' && $user->dni != NULL)
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
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection
