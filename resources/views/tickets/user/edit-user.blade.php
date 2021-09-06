@extends('layouts/contentLayoutMaster')

@section('title', 'Editar ticket')

<link rel="stylesheet" href="{{ asset('custom/ticket/css/chat-ticket.css') }}" />

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Editando el Ticket #{{ $ticket->id}}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="issue"><b>Asunto del ticket</b></label>
                                <input class="form-control rounded border-primary" id="issue" type="text" name="issue"
                                    value="{{ $ticket->issue }}" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="priority">Prioridad del Ticket</label>
                                <select name="priority" class="custom-select rounded border-primary" id="priority">
                                    <option value="0" @if($ticket->priority == '0') selected @endif>Alto</option>
                                    <option value="1" @if($ticket->priority == '1') selected @endif>Medio</option>
                                    <option value="2" @if($ticket->priority == '2') selected @endif>Bajo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12" id="load_chat">
                            <div class="form-group">
                                <label class="form-label" for="message"><b>Chat con el administrador</b></label>
                                <section class="chat-app-window rounded border-primary">

                                    <div class="chat-navbar">
                                        <header class="chat-header">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                                    <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                        alt="avatar" height="36" width="36">
                                                    <span class="avatar-status-online"></span>
                                                </div>
                                                <h6 class="ml-1 mb-0">Equipo de Bitcoin Ecuador</h6>
                                            </div>
                                        </header>
                                    </div>

                                    <div class="active-chat">
                                        <div class="user-chats ps ps--active-y">

                                            <div class="chats chat-thread p-2">
                                                {{-- admin --}}
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                                alt="avatar" height="36" width="36">
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                            <small>{{date('d-M-Y - h:i:s', strtotime($ticket->created_at))}}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach ( $message as $item )
                                                {{-- user --}}
                                                @if ($item->type == 0)
                                                <div class="chat">
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
                                                            <small>{{date('d-M-Y - h:i:s', strtotime($item->created_at))}}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- admin --}}
                                                @elseif ($item->type == 1)
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            <img src="{{ asset('custom/ticket/img/user.png') }}"
                                                                alt="avatar" height="36" width="36">
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>{{ $item->message }}</p>
                                                            <small>{{ $item->created_at }}</small>
                                                            <small>{{date('d-M-Y - h:i:s', strtotime($item->created_at))}}</small>
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
                                    admin</span>
                                <textarea class="form-control border border-primary rounded chat-window-message"
                                    type="text" name="message" id="message" rows="3"></textarea>
                            </div>
                            <div class="col-12 d-flex flex-row-reverse">
                                <button type="submit"
                                    class="btn btn-primary waves-effect waves-light btn_msj ml-1">Actualizar
                                    Ticket</button>
                                <a href="{{ route('ticket.list-user') }}"
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

        if ($('#message').val() == null || $('#message').val() == '') {
            toastr.error("El mensaje es requerido", '', {
                "timeOut": 3000
            })
        } else {

            let item = {}
            var this_button = $(this)
            item['_method'] = 'PATCH';
            $.ajax({
                method: "POST",
                url: "{{ route('ticket.update-user', $ticket->id) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    issue: $('#issue').val(),
                    priority: $('#priority').val(),
                    message: $('#message').val(),
                    "_method": 'PATCH'
                }
            }).done(function (data) {
                // console.log(data);
                this_button.addClass('disabled').addClass('is-loading');
                $("#load_chat").load("{{ route('ticket.edit-user', $ticket->id) }} #load_chat");
                setTimeout(() => {
                    toastr.success("El ticket a sido actualizado", '', {
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

        }
    });
</script>
