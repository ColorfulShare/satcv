@section('content')

@extends('layouts/contentLayoutMaster')

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
                                            <input type="email" readonly id="email" class="form-control" value="{{ $user->name }}" name="email">
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
                                            <label>Email</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->email }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>telefono</label>
                                            <input type="text" readonly id="whatsapp" class="form-control"
                                                value="{{ $user->phone }}" name="whatsapp">
                                        </div>
                                    </div>
                                       <div class="col-12">
                                        <div class="form-group">
                                            <label>telefono movil</label>
                                            <input type="text" readonly id="whatsapp" class="form-control"
                                                value="{{ $user->mobile_phone }}" name="whatsapp">
                                        </div>
                                    </div>
                                       <div class="col-12">
                                        <div class="form-group">
                                            <label>localizacion</label>
                                            <input type="text" readonly id="whatsapp" class="form-control"
                                                value="{{ $user->location_id }}" name="whatsapp">
                                        </div>
                                    </div>
                                        <div class="col-12">
                                        <div class="form-group">
                                            <label>estado</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->status }}" name="email">
                                        </div>
                                    </div>

                                    <div class="col-12">

                                        <div class="form-group">
                                            <div class="controls">
                                                <h2 class="font-weight-bold text-center">DNI del usuario</h2>
                                            </div>
                                        </div>

                                        <div class="row mb-4 mt-1 d-none" id="photo_preview_wrapper">
                                            <div class="col"></div>
                                            <div class="col-auto">
                                                <img id="photo_preview" class="img-fluid rounded" />
                                            </div>
                                            <div class="col"></div>
                                        </div>

                                    </div>


                                    <div class="col-12 mt-1 d-flex flex-row-reverse">

                                        <a href="{{ route('users.list-user') }}"
                                            class="btn btn-primary mr-1 mb-1 waves-effect waves-light">aceptar</a>

                                        <button type="submit"
                                            class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Verificar</button>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
