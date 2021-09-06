
@extends('layouts/contentLayoutMaster')

@section('title', 'Detalle de Contrato')

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
                               <h5>Detalles de Contrato</h5>
                                           
                                <div class="col-12">
                                    <div class="form-group">
                                       <label>Inversion</label>
                                       <input type="email" readonly id="email" class="form-control"
                                       value="{{ $contrato->invested }}" name="email">
                                     </div>
                                </div>
                                <div class="col-12">
                                   <div class="form-group">
                                       <label>Ganancia</label>
                                       <input type="email" readonly id="email" class="form-control"
                                       value="{{ $contrato->gain }}" name="email">
                                    </div>
                                </div>
                                <div class="col-12">
                                   <div class="form-group">
                                       <label>Capital</label>
                                       <input type="email" readonly id="email" class="form-control"
                                       value="{{ $contrato->capital }}" name="email">
                                  </div>
                                </div>
                                <div class="col-12">
                                   <div class="form-group">
                                       <label>Estado</label>
                                       <input type="text" readonly id="whatsapp" class="form-control"
                                       value="{{ $contrato->status }}" name="whatsapp">
                                    </div>
                                </div>
                                <div class="col-12">
                                   <div class="form-group">
                                       <label>Tipo de Interes</label>
                                       <input type="text" readonly id="locatizacion" class="form-control"
                                       value="{{ $contrato->type_interes }}" name="localizacion">
                                    </div>
                                </div>
                                <div class="col-12">
                                   <div class="form-group">
                                       <label>Fecha de Creacion</label>
                                       <input type="email" readonly id="email" class="form-control"
                                       value="{{$contrato->created_at->format('Y/m/d') }}" name="email">
                                    </div>
                                </div>
                                <div class="col-12 mt-1 d-flex flex-row-reverse">
                                   <a href="{{ url()->previous() }}"
                                     class="btn btn-primary mr-1 mb-1 waves-effect waves-light">regresar</a>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection