@extends('layouts/contentLayoutMaster')

@section('title', 'Crear ticket')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Creacion de Ticket</h6>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="{{route('ticket.store')}}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label h4" for="issue"><b>Asunto del ticket</b></label>
                                        <input class="form-control border border-primary rounded" required type="text" name="issue" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label h4" for="priority">Prioridad del Ticket</label>
                                        <select name="priority" class="custom-select border border-primary rounded" required>
                                            <option value="0">Alto</option>
                                            <option value="1">Medio</option>
                                            <option value="2">Bajo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label h4" for="message"><b>Chat con el administrador</b></label>
                                        <section class="chat-app-window border border-primary rounded">
                                            <div class="active-chat">
                                                <div class="user-chats ps ps--active-y bg-lp">
                                                    <div class="chats chat-thread">
                                                        {{-- admin --}}
                                                        <div class="chat chat-left">
                                                            <div class="chat-avatar">
                                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                                    <img src="" alt="avatar" height="36" width="36">
                                                                </span>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-content">
                                                                    <p>Hola!. ¿Cómo podemos ayudar? 😄</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                        <span class="text-danger text-bold-600">Aqui podra escribir el mensaje para el admin</span>
                                        <textarea class="form-control border border-primary rounded chat-window-message" type="text" name="message" required rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light ml-1">Enviar Ticket</button>
                                    <a href="{{ route('ticket.list-user') }}" class="btn btn-outline-danger waves-effect waves-light mr-1">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
