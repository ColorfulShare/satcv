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

                            <form action="{{ route('users.verify-user',$user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

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
                                            <label>Email</label>
                                            <input type="email" readonly id="email" class="form-control"
                                                value="{{ $user->email }}" name="email">
                                        </div>
                                    </div>
 

                                    <div class="col-12 mt-1 d-flex flex-row-reverse">

                                        <a href="{{ route('users.list-user') }}"
                                            class="btn btn-danger mr-1 mb-1 waves-effect waves-light">Cancelar</a>

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