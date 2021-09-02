@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<div class="row">
    <div class="col-sm-4 col-12 mt-1">
        <div class="card h-80 p-2 art-2"> 
            <div class="row no-gutters">
                <div class="col-6">
                    <h6 class="float-right"><b>Saldo disponible: </b></h6>
                </div>
                <div class="col-6">
                    <h6 class=""><b > &nbsp $ {{$user->saldoDisponible()}}</b></h6>
                </div>
            </div>
            <!-- Vertical modal -->
            <div class="vertical-modal-ex">
                <button type="button" class="btn btn-outline-primary float-right" id="invertir">
                    Retirar
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Retirar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body">
                                    
                                    <div class="mb-1">
                                        <label for="wallet" class="form-label">Billetera:</label>
                                        <input type="text" min="500" class="form-control" id="wallet" name="wallet" required>
                                    </div>
        
                                    <div class="mb-1">
                                        <label for="codigo_correo" class="form-label">Código de correo:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="código de correo" name="codigo_correo" id="codigo_correo" required>
                                            <button class="btn btn-outline-primary" style="width: 30%; padding-top: 5px; padding-bottom: 5px;" type="button" id="btn_enviar_mail">
                                                <span id="text_enviar">Enviar</span>
                                                <div class="d-inline" >
                                                    <div class="d-none spinner-border text-primary" role="status" id="spinner_enviar"></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-1">
                                        <label for="authenticator" class="form-label">Código del autenticador:</label>
                                        <input type="text" min="500" class="form-control" id="authenticator" name="authenticator" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Retirar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical modal end-->

            
        </div>
    </div>
    
    <div class="col-sm-8 col-12 mt-1">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard p-0">
                    <div class="table-responsive">
                    <h3 class="text-white p-1">Billetera</h3>
                        <table class="table nowrap scroll-horizontal-vertical myTable2">
                            <thead>

                                <tr class="text-center text-dark text-uppercase pl-2">                                
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Email</th>
                                    <th>Monto</th>    
                                </tr>

                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom_js')
    <script>
        let invertir = document.querySelector('#invertir');

        invertir.addEventListener("click", function( event ) {

            @if($user->activar_2fact == 0)
                toastr['error']('Necessita la verificación de dos factores para poder retirar', 'Error', {
                    closeButton: true,
                    tapToDismiss: false
                })
            @else    
                let myModal = new bootstrap.Modal(document.getElementById('exampleModalCenter'), {
                    keyboard: false
                })

                myModal.show();
            @endif
            
        }, false);

        let btnMail = document.querySelector('#btn_enviar_mail');

        btnMail.addEventListener("click", function( event ) {
            //colocamos el spinner y ocultamos el texto
            let texBtnEnviar = document.querySelector('#text_enviar');
            let spinnerBtnEnbiar = document.querySelector('#spinner_enviar');

            texBtnEnviar.classList.add('d-none');
            spinnerBtnEnbiar.classList.remove('d-none');
            //
            let data = {'user': "{{Auth::id()}}"}
            fetch(`{{route("sendMailFactorCode")}}`, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify(data), // data can be `string` or {object}!
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            })   
            .then(response => {
                if (!response.ok) {
                    toastr['error'](response.statusText, 'Error', {
                        closeButton: true,
                        tapToDismiss: false
                    });
                    //removemos el spinner y colocamos el texto
                    spinnerBtnEnbiar.classList.add('d-none');
                    texBtnEnviar.classList.remove('d-none');
                    //
                    throw new Error(response.statusText)
            
                }else{
                    //removemos el spinner y colocamos el texto
                    spinnerBtnEnbiar.classList.add('d-none');
                    texBtnEnviar.classList.remove('d-none');
                    //
                    return response.json()
                }
            })
            .then(data => {
                toastr['info'](data.message, 'Email enviado', {
                    closeButton: true,
                    tapToDismiss: false
                 });
                 
            })
            .catch(error => {
                console.log(error);
                //removemos el spinner y colocamos el texto
                spinnerBtnEnbiar.classList.add('d-none');
                texBtnEnviar.classList.remove('d-none');
                //
            })
        });
    </script>
@endpush
