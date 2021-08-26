
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
                <form action="{{route('shop.procces')}}" method="POST">
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
        
      </div>
    </div>
  </div>
</div>
    
@endsection
