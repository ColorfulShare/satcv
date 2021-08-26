@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<div id="logs-list">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped w-100">
                            <thead class="">

                                <tr class="text-center">                                
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Tipo de interes</th>
                                    <th>Capital</th>
                                    <th>Acción</th>
                                </tr>

                            </thead>
                            <tbody>
                                @forelse($contratos as $contrato)
                                <tr class="text-center">
                                    <td>{{$contrato->id}}</td>
                                    <td>{{$contrato->created_at->format('Y-m-d')}}</td>
                                    <td>{{$contrato->type_interes}}</td>
                                    <td>{{$contrato->capital}}</td>
                                    <td>
                                        <button type="button" data-toggle="modal" class="btn btn-danger" data-target="#ModalRetirar{{$contrato->id}}">
                                            Retirar
                                        </button>

                                        <button type="button" class="btn btn-danger retirar" contrato_id="{{$contrato->id}}">
                                            Retirar
                                        </button>
                                    </td>
                            
                                    <!-- Modal -->
                                    <div class="modal fade" id="ModalRetirar{{$contrato->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Retirar contrato</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('contract.remove')}}" method="POST">
                                            @csrf
                                            <div class="modal-body">

                                                <input type="hidden" name="id" value="{{$contrato->id}}">
                                                
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Guardar</button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                
                                    </td>
                                </tr>
                                @empty 
                                <tr>
                                    <td colspan="5">Sn Contratos</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

    <input type="hidden" id="contrato_id" name="contrato_id">
@endsection

@push('custom_js')
    <script>

        let btnRetirar = document.querySelector('.retirar');
        
        if(btnRetirar != null){
            btnRetirar.addEventListener("click", function( event ) {
                
                let contratoId = event.target.attributes.contrato_id.value;
                data= {'contratoId': contratoId}
                //llamamos la alerta
                Swal.fire({
                title: '¿Estas seguro?',
                text: "Como penalizacion se le quitara un 25% de lo invertido.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Retirar',
                preConfirm: (login) => {
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
                }).then((result) => {
                
                if (result.isConfirmed) {
                    Swal.fire(
                    'Retirado',
                    'Contrato retirado con exito.',
                    'success'
                    )
                    location.reload(true);
                }
                })
            }, false)
        }
    </script>
@endpush
