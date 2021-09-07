@extends('layouts/contentLayoutMaster')

@section('title', 'Contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Vertical modal -->
                <div class="vertical-modal-ex">
                    <button type="button" class="btn btn-outline-primary float-right" id="btnFormulario">
                        Invertir
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="modalContrato" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Invertir</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('shop.procces')}}" method="POST" target="_blank" id="shop.procces" name="procces">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="mb-1">
                                            <label for="monto" class="form-label" style="font-size: 1em;">Cantidad a invertir:</label>
                                            <input type="number" min="500" class="form-control" id="monto" name="monto">
                                        </div>
                                        <input type="hidden" id="imagen64" name="imagen64">
                                        <div class="mb-1">
                                            <label class="d-block">Interes:</label>
                                            <div class="form-check form-check-inline">
                                                <input required class="form-check-input" type="radio"
                                                    id="inlineCheckbox1" name="interes" value="lineal">
                                                <label class="form-check-label" for="inlineCheckbox1">Lineal (12
                                                    meses)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input required class="form-check-input" type="radio"
                                                    id="inlineCheckbox2" name="interes" value="compuesto">
                                                <label class="form-check-label" for="inlineCheckbox2">Compuesto (12
                                                    meses)</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="invertir" class="btn btn-primary invertir"> Invertir</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Vertical modal end-->

                <div class="table-responsive">
                    <table class="table w-100 nowrap scroll-horizontal-vertical table-striped comuntable">
                        <thead class="">
                            <tr class="text-center bg-purple-alt2">
                                <th>ID</th>
                                <th>Invertido</th>
                                <th>Saldo Capital</th>
                                <th>Ganancia</th>
                                <th>Productividad</th>
                                <th>Retirado</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Vencimiento</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos as $contrato)
                            <tr class="text-center bg-purple-alt2">
                                <td>{{$contrato->id}}</td>
                                <td>{{$contrato->invested}}</td>
                                <td>{{$contrato->capital}}</td>
                                <td>{{$contrato->gain}}</td>
                                <td>{{$contrato->productividad()}}</td>
                                <td>{{$contrato->retirado()}}</td>
                                <td>{!!$contrato->estado()!!}</td>
                                <td>{{$contrato->created_at->format('Y/m/d')}}</td>
                                <td>{{$contrato->contractExpiration()->format('Y/m/d')}}</td>
                                <td>
                                    <a href="{{ route('dashboard', ['id' => $contrato->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Ver Contrato"><i class="fa fa-eye"></i></a>
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

    <!-- Vertical modal -->
    <!-- Modal FIRMA-->
    <div
      class="modal fade"
      id="modal"
      tabindex="-1"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Firma</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="signature-pad" class="signature-pad" style="margin: 0px auto;">
              <div class="signature-pad--body">
                <p>Colocar tu firma aqui</p>
                <canvas style="border: 1px solid #000; width: 100%;"></canvas>
        
              </div>
              <div class="signature-pad--footer">
                <div class="text-center">Accion</div>
                <div class="text-center">
                    <button type="button" class="button clear btn btn-info btn-round" data-action="clear" id="limpiar">Limpiar</button>
                    <button type="button" class="button btn btn-info btn-round" data-action="undo" id="btnGuardar">Firmar</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('page-script')

@endsection
{{-- CONFIGURACIÓN DE DATATABLE --}}
@include('panels.datatables-config')


@push('custom_js')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
<script>
    let btnInvertir = document.getElementById('invertir');
    let btnFormulario = document.getElementById('btnFormulario');
    let modalFirma = document.getElementById('modal');
    let modalContrato = document.getElementById('modalContrato');
    let formProccess = document.querySelector('#shop.procces');

    let myModalFirma = new bootstrap.Modal(modalFirma);
    let myModalContrato = new bootstrap.Modal(modalContrato);
    //MODAL DE LA FIRMA
    btnInvertir.addEventListener("click", function( event ) {
        
        myModalContrato.hide();
        myModalFirma.show();
    });

    //MODAL DEL FORMULARIO
    btnFormulario.addEventListener("click", function( event ) {
        
        
        
        myModalContrato.show();
        
    });

    modalFirma.addEventListener('shown.bs.modal', function (event) {

        let wrapper = document.getElementById("signature-pad");
    
        let canvas = wrapper.querySelector("canvas");
        let signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
        });
        
        function resizeCanvas() {
        
        let ratio =  Math.max(window.devicePixelRatio || 1, 1);
        
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        
        signaturePad.clear();
        }
        
        window.onresize = resizeCanvas;
        resizeCanvas();
        
        $('#limpiar').click(function(){
        signaturePad.clear();
        })

        $('#btnGuardar').click(function(){
    
        event.preventDefault();
        if (signaturePad.isEmpty()) {
            const swalWithBootstrapButtons = Swal.fire({
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Debe realizar la firma!"
            });
        } else {
            document.getElementById('imagen64').value = signaturePad.toDataURL();

            document.procces.submit();
         
        }
        });
    });

</script>
@endpush
