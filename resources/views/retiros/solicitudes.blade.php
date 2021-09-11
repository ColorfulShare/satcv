@extends('layouts/contentLayoutMaster')

@section('title', 'Solicitudes de retiro')

@section('content')
  
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body card-dashboard">
                <div class="card-title">
                    <h3>Retiros de Capital</h3>
                </div>
                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
                        <thead>

                            <tr class="text-center text-dark text-uppercase pl-2">
                                <th>Id</th>                                
                                <th>Usuario</th>
                                <th>Contrato</th>
                                <th>Cantidad</th>
                                <th>Porcentaje</th>
                                <th>Estatus</th>
                                <th>Fecha</th>    
                                <th>Accion</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($solicitudes as $solicitud)
                                <tr class="text-center">
                                    <td>{{$solicitud->id}}</td>
                                    <td>{{$solicitud->user()->fullName()}}</td>
                                    <td>{{$solicitud->contracts_id}}</td>
                                    <td>{{number_format($solicitud->amount, 2, '.', '')}}</td>
                                    <td>{{number_format($solicitud->percentage, 2, '.', '')}}</td>
                                    <td>{{$solicitud->status()}}</td>
                                    <td>{{$solicitud->created_at->format('d/m/Y')}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success retirar" solicitud="{{$solicitud->id}}" contrato_id="{{$solicitud->contracts_id}}">
                                            Pagar
                                        </button>

                                        <button type="button" class="btn btn-danger cancelar" solicitud="{{$solicitud->id}}">
                                            Cancelar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')

@push('custom_js')
<script>
    //BTN DE RETIRAR
    let btnsRetirar = document.querySelectorAll('.retirar');
    
    btnsRetirar.forEach(function(btnRetirar) {
        if(btnRetirar != null){
            btnRetirar.addEventListener("click", function( event ) {
                
                let contratoId = event.target.attributes.contrato_id.value;
                let solicitudId = event.target.attributes.solicitud.value;
                //llamamos la alerta
                Swal.fire({
                title: '¿Estas seguro?',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                text: "Ingrese la billetera a la cual le pagara al usuario.",
                icon: 'warning',
                showCancelButton: true,
                inputValidator: (value) => { 
                    if(!value){
                        return 'Debe ingresar una billetera';
                    }
                },
                confirmButtonColor: '#00bb2d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Retirar',
                cancelButtonText: 'Cancelar',
                showCloseButton: true,
                preConfirm: (login) => {
                    let data= {'solicitudId': solicitudId, 'contratoId': contratoId, wallet: login};
                
                    return fetch(`{{route("contract.remove")}}`, {
                    method: 'POST', // or 'PUT'
                    body: JSON.stringify(data), // data can be `string` or {object}!
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    })   
                    .then(response => {
                        
                        if (!response.ok) {
                        throw new Error(response.statusText)
                        }
                        
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                        `Request failed: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
                })
                .then((result) => {
                console.log(result)
                if (result.isConfirmed) {
                    Swal.fire(
                    'Pagado',
                    'Contrato pagado con exito.',
                    'success'
                    )
                    location.reload(true);
                }
                })
            }, false)
        }
    });

    //BTN DE CANCELAR
    let btnsCancelar = document.querySelectorAll('.cancelar');
    
    btnsCancelar.forEach(function(btnCancelar) {
        if(btnCancelar != null){
            btnCancelar.addEventListener("click", function( event ) {
        
                let solicitudId = event.target.attributes.solicitud.value;
                //llamamos la alerta
                Swal.fire({
                title: '¿Estas seguro que deseas cancelar la solicitud de retiro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00bb2d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                showCloseButton: true,
                cancelButtonText: 'No',
                preConfirm: (login) => {
                    let data= {'solicitudId': solicitudId};
                
                    return fetch(`{{route("solicitud.cancelar")}}`, {
                    method: 'POST', // or 'PUT'
                    body: JSON.stringify(data), // data can be `string` or {object}!
                    headers:{
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    })   
                    .then(response => {
                        
                        if (!response.ok) {
                        throw new Error(response.statusText)
                        }
                        
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                        `Request failed: ${error}`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
                })
                .then((result) => {
                console.log(result)
                if (result.isConfirmed) {
                    Swal.fire(
                    'Cancelado',
                    'Solcitiud de retiro cancelado con exito.',
                    'success'
                    )
                    location.reload(true);
                }
                })
            }, false)
        }
    });
</script>
@endpush
