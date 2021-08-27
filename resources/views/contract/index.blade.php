
@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de contratos')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <!-- Vertical modal -->
        <div class="vertical-modal-ex">
          <button
            type="button"
            class="btn btn-outline-primary"
            data-toggle="modal"
            data-target="#exampleModalCenter"
          >
            Invertir
          </button>
          <!-- Modal -->
          <div
            class="modal fade"
            id="exampleModalCenter"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Invertir</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{route('shop.procces')}}" method="POST" target="_blank">
                  @csrf
                  <div class="modal-body">

                    <div class="mb-1">
                      <label for="monto" class="form-label">Monto:</label>
                      <input type="number" min="500" class="form-control" id="monto" name="monto">
                    </div>
                    
                    <div class="mb-1">
                      <label class="d-block">Interes:</label>
                      <div class="form-check form-check-inline">
                        <input required class="form-check-input" type="radio" id="inlineCheckbox1" name="interes" value="lineal">
                        <label class="form-check-label" for="inlineCheckbox1">Lineal (12 meses)</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input required class="form-check-input" type="radio" id="inlineCheckbox2" name="interes" value="compuesto">
                        <label class="form-check-label" for="inlineCheckbox2">Compuesto (12 meses)</label>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Accept</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Vertical modal end-->
        
        <div class="card-body card-dashboard">
          <div class="card-title">
            <h3>Inversiones</h3>
          </div>
          <div class="table-responsive">
            <table class="table w-100 nowrap scroll-horizontal-vertical myTable table-striped w-100">
              <thead class="">
                  <tr class="text-center bg-purple-alt2">                                
                      <th>ID</th>
                      <th>Fecha</th>
                      <th>Monto</th>
                      <th>Saldo Capital</th>
                      <th>Productividad</th>
                      <th>Retirado</th>
                      <th>Vencimiento</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($contratos as $contrato)
                  <tr class="text-center bg-purple-alt2">
                      <td>{{$contrato->id}}</td>
                      <td>{{date_format($contrato->created_at,"Y/m/d");}}</td>
                      <td>{{$contrato->getOrden->amount}}</td>
                      <td>{{$contrato->capital}}</td>
                      <td>{{$contrato->gain}}</td>
                      <td>0</td>
                      <td>{{date_format($contrato->contractExpiration(), 'Y/m/d')}}</td>
                  </tr>
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
