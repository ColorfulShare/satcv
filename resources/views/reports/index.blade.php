@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de ordenes')

@section('content')
    <div id="logs-list">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                                <thead class="">

                                    <tr class="text-center">                                
                                        <th>ID</th>
                                        <th>Correo</th>
                                        <th>Transaccion</th>
                                        <th>Tipo de interes</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                        <th>Fecha de Creación</th>
                                        @if(Auth::user()->admin == 1) 
                                        <th>Accion</th>
                                       @endif
                                    </tr>

                                </thead>
                                <tbody>

                                    @foreach ($ordenes as $orden)
                                        <tr class="text-center">
                                            <td>{{$orden->id}}</td>
                                            <td>{{$orden->user->email}}</td>
                                            <td>{{$orden->transaction_id}}</td>
                                            <td>{{$orden->type_interes}}</td>
                                            <td>{{$orden->amount}}</td>
                                            <td>
                                                <button type="button"
                                                    @if (Auth::user()->admin == 1 && $orden->status == '0')
                                                    data-toggle="modal"
                                                    data-target="#ModalStatus{{$orden->id}}"
                                                    @endif

                                                    class="@if ($orden->status == '0') btn btn-info text-white text-bold-600  @elseif($orden->status == '1') btn btn-success text-white text-bold-600 @elseif($orden->status >= '2') btn btn-danger text-white text-bold-600 @endif">{{$orden->status()}}
                                              </button>
                                            </td>
                                            <td>{{$orden->created_at->format('Y-m-d')}}</td>
                                             <td> @if(Auth::user()->admin == 1) 
                                                  <div class="d-flex">

                                                    <a href="{{ route('reports.show-contrato', $orden) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Ver Contrato"><i class="fa fa-eye"></i></a>
                                                    <button class="btn btn-info mx-1" data-toggle="tooltip" data-placement="top" title="Reenviar Contrato"><i class="fa fa-paper-plane"></i></button>
                                                  </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @if (Auth::user()->admin == 1 && $orden->status == '0')
                                            <!-- Modal -->
                                            <div class="modal fade" id="ModalStatus{{$orden->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Cambiar estatus</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('cambiarStatus') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">

                                                    <input type="hidden" name="id" value="{{$orden->id}}">
                                                    ¿Desea cambiar es estatus de la orden?
                                                    <br>
                                                    <label>Seleccione el estado</label>
                                                    <select name="status" required class="form-control">
                                                        <option value="">Seleccione un estado</option>
                                                        <option value="1">Aprobado</option>
                                                        <option value="2">Rechazado</option>
                                                    </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                       @endif
                                    @endforeach                      
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


