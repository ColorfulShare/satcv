@extends('layouts/contentLayoutMaster')

@section('title', 'Revisar ticket')

<link rel="stylesheet" href="{{ asset('custom/ticket/css/chat-ticket.css') }}" />

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">Atendiendo el Ticket #{{ $ticket->id }}</h2>
                        <h2 class="card-title d-none">Usuario: <span
                                class="text-primary">{{ $ticket->getUser->name}}</span></h2>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="issue"><b>Asuto del Ticket</b></label>
                                <input class="form-control border border-primary rounded" type="text" name="issue"
                                    value="{{ $ticket->issue }}" readonly />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="status">Estado del Ticket</label>
                                <select name="status" id="status" class="custom-select border border-primary rounded">
                                    <option value="0" @if($ticket->status == '0') selected @endif>Abierto</option>
                                    <option value="1" @if($ticket->status == '1') selected @endif>Cerrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="priority">Prioridad del Ticket</label>
                                <select name="priority" id="priority" class="custom-select border border-primary rounded">
                                    <option value="0" @if($ticket->priority == '0') selected @endif>Alto</option>
                                    <option value="1" @if($ticket->priority == '1') selected @endif>Medio</option>
                                    <option value="2" @if($ticket->priority == '2') selected @endif>Bajo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12" id="load_chat">
                            <div class="form-group">
                                <label class="form-label" for="note"><b>Chat con el usuario</b></label>
                                <section class="chat-app-window border border-primary rounded">

                                    <div class="chat-navbar">
                                        <header class="chat-header">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                    <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                        alt="avatar" height="36" width="36">
                                                    <span class="avatar-status-busy"></span>
                                                    @if (Auth::user()->status == 1)
                                                    <span class="avatar-status-online"></span>
                                                    @elseif (Auth::user()->status == 2)
                                                    <span class="avatar-status-busy">ssssssss</span>
                                                    @endif
                                                </div>
                                                <h6 class="ml-1 mb-0">{{ $ticket->getUser->name}} -
                                                    {{ $ticket->getUser->email}}</h6>
                                            </div>
                                        </header>
                                    </div>

                                    <div class="active-chat">
                                        <div class="user-chats ps ps--active-y">
                                            <div class="chats chat-thread">
                                                <div class="chat">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                                alt="avatar" height="36" width="36">
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach ( $message as $item )
                                                {{-- user --}}
                                                @if ($item->type == 0)
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            @if (Auth::user()->photoDB != NULL)
                                                            <img src="{{asset('storage/photo/'.Auth::user()->photoDB)}}"
                                                                alt="avatar" height="36" width="36">
                                                            @else
                                                            <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                                alt="avatar" height="36" width="36">
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>{{ $item->message }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- admin --}}
                                                @elseif ($item->type == 1)
                                                <div class="chat">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                                alt="avatar" height="36" width="36">
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>{{ $item->message }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <br>
                                <span class="text-danger text-bold-600">Aqui podra escribir el mensaje para el
                                    usuario</span>
                                <textarea class="form-control border border-primary rounded chat-window-message"
                                    type="text" name="message" id="message" required rows="3"></textarea>
                            </div>
                            <div class="col-12 d-flex flex-row-reverse">
                                <button type="submit"
                                    class="btn btn-primary waves-effect waves-light btn_msj ml-1">Actualizar
                                    Ticket</button>
                                <a href="{{ route('ticket.list-admin') }}"
                                    class="btn btn-outline-danger waves-effect waves-light mr-1">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('custom/ticket/js/jquery-3.6.0.min.js') }}"></script>

<script>
    var token = $('meta[name="csrf-token"]').attr('content')

    $(document).on('click', '.btn_msj', function () {

        // if ($('#message').val() == null || $('#message').val() == '') {
        //     toastr.error("El mensaje es requerido", '', {
        //         "timeOut": 3000
        //     })
        // } else {

            let item = {}
            var this_button = $(this)
            item['_method'] = 'PATCH';
            $.ajax({
                method: "POST",
                url: "{{ route('ticket.update-admin', $ticket->id) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    status: $('#status').val(),
                    priority: $('#priority').val(),
                    message: $('#message').val(),
                    "_method": 'PATCH'
                }
            }).done(function (data) {
                // console.log(data);
                this_button.addClass('disabled').addClass('is-loading');
                $("#load_chat").load("{{ route('ticket.edit-admin', $ticket->id) }} #load_chat");
                setTimeout(() => {
                    toastr.success("El mensaje a sido enviado", '', {
                        "timeOut": 3000
                    })
                    this_button.removeAttr('disabled');
                    this_button.removeClass('disabled').removeClass('is-loading');
                }, 1000)
            }).fail(function (xhr, status, error) {
                toastr.error("Hubo un error al enviar el mensaje", '', {
                    "timeOut": 3000
                })
            });

        // }
    });

</script>
