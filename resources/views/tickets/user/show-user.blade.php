@extends('layouts/contentLayoutMaster')

@section('title', 'Revisar ticket')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Revisando el Ticket #{{ $ticket->id}}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="issue"><b>Asunto del ticket</b></label>
                                <input class="form-control rounded border-primary" type="text" value="{{ $ticket->issue }}" readonly />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="priority">Prioridad del Ticket</label>
                                @if($ticket->priority == '0')
                                <input class="form-control rounded border-primary" type="text" value="Alto" readonly />
                                @elseif($ticket->priority == '1')
                                <input class="form-control rounded border-primary" type="text" value="Medio" readonly />
                                @elseif($ticket->priority == '2')
                                <input class="form-control rounded border-primary" type="text" value="Bajo" readonly />
                                @endif
                            </div>
                        </div>
                        <div class="col-12" id="load_chat">
                            <div class="form-group">
                                <label class="form-label" for="message"><b>Chat con el administrador</b></label>
                                <section class="chat-app-window rounded border-primary">
                                    <div class="active-chat">
                                        <div class="user-chats ps ps--active-y">

                                            <div class="chats chat-thread p-2">
                                                {{-- admin --}}
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}"
                                                                alt="avatar" height="36" width="36">
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                            <small class=" text-secondary">admin@btc.com</small>
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
                                                            <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}"
                                                                alt="avatar" height="36" width="36">
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>{{ $item->message }}</p>
                                                            <small
                                                                class=" text-secondary">{{ $item->getUser->email}}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- admin --}}
                                                @elseif ($item->type == 1)
                                                <div class="chat chat-left">
                                                    <div class="chat-avatar">
                                                        <span class="avatar box-shadow-1 cursor-pointer">
                                                            <img src="{{ asset('assets/img/royal_green/logos/logo.svg') }}"
                                                                alt="avatar" height="36" width="36">
                                                        </span>
                                                    </div>
                                                    <div class="chat-body">
                                                        <div class="chat-content">
                                                            <p>{{ $item->message }}</p>
                                                            <small class=" text-secondary">admin@btc.com</small>
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
                            </div>
                            <div class="col-12 d-flex flex-row-reverse">
                                <a href="{{ route('ticket.list-user') }}" class="btn btn-outline-danger waves-effect waves-light">Volver a la lista</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection