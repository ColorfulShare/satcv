<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Muestra la lista de tickets del usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
    try {
      $ticket = Ticket::where('user', Auth::id())->get();

      return view('tickets.user.list-user')->with('ticket', $ticket);
        
    } catch (\Throwable $th) {
        Log::error('indexUser -> Error: '.$th);
        abort(403, "Ocurrio un error, contacte con el administrador");
    }
    }

    /**
     * Muestra la lista de todos los tickets para el admin
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
    try {
      $ticket = Ticket::all();

      return view('tickets.admin.list-admin')->with('ticket', $ticket);
       
    } catch (\Throwable $th) {
        Log::error('indexAdmin -> Error: '.$th);
        abort(403, "Ocurrio un error, contacte con el administrador");
    }
    }

    /**
     * Muestra la vista para crear un ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    try {
      return view('tickets.user.create');
   
    } catch (\Throwable $th) {
        Log::error('create -> Error: '.$th);
        abort(403, "Ocurrio un error, contacte con el administrador");
    }
    }

    /**
     * Funcion para crear el ticket y el mensaje
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // try {
      // crea el ticket
      Ticket::create([
          'user' => Auth::id(),
          'issue' => $request->issue,
          'priority' => $request->priority,
       ]);

      // toma el ultimo ticket creado
      $ticket_create = Ticket::where('user', Auth::id())->orderby('created_at','DESC')->take(1)->get();
      $id_ticket = $ticket_create[0]->id;

      // crea el mensaje
      TicketMessage::create([
          'user' => Auth::id(),
          'admin' => '1',
          'ticket' => $id_ticket,
          'type' => '0',
          'message' => $request->message,
      ]);

      return redirect()->route('ticket.list-user');
    // } catch (\Throwable $th) {
    //     Log::error('store -> Error: '.$th);
    //     abort(403, "Ocurrio un error, contacte con el administrador");
    // }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
