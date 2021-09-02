<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\DB;
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
        // try {

            $ticket = Ticket::where('user', Auth::id())->get();

            $ticket =  DB::select('select * from tickets where user = :id', ['id' => Auth::id()]);

            // $time_msj =  TicketMessage::all()->where('user', Auth::id());

            // $mo = [];
            // // dd($time_msj);
            // foreach($time_msj as $item){
            // array_push($mo, $item->user);
            // }

            return view('tickets.user.list-user')
            ->with('ticket', $ticket);
        
        // } catch (\Throwable $th) {
        //     Log::error('indexUser -> Error: '.$th);
        //     abort(403, "Ocurrio un error, contacte con el administrador");
        // }
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
        try {

            // crea el ticket
            Ticket::create([
                'user' => Auth::id(),
                'issue' => $request->issue,
                'priority' => $request->priority,
             ]);

            // toma el ultimo ticket creado
            $ticket_create = Ticket::where('user', Auth::id())->orderby('created_at','DESC')->take(1)->get();
            $id_ticket = $ticket_create[0]->id;

            // crea el mensaje para el admin
            TicketMessage::create([
                'user' => Auth::id(),
                'admin' => '1',
                'ticket' => $id_ticket,
                'type' => '0',
                'message' => $request->message,
            ]);

            return redirect()->route('ticket.list-user')->with('success', 'Ticket Creado');

        } catch (\Throwable $th) {
            Log::error('store -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }    
    }

    /**
     * Muestra la vista para ver un ticket
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function showUser($id)
    {
        try {

            $ticket = Ticket::find($id);
            $message = TicketMessage::where('ticket', $id)->orderby('created_at','ASC')->get();

            return view('tickets.user.show-user')
            ->with('ticket', $ticket)
            ->with('message', $message);

        } catch (\Throwable $th) {
            Log::error('showUser -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }    
    }

    /**
     * Muestra la vista para editar un ticket del user
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function editUser($id)
    {
        try {

            $ticket = Ticket::find($id);
            $message = TicketMessage::where('ticket', $id)->orderby('created_at','ASC')->get();
      
            return view('tickets.user.edit-user')
            ->with('ticket', $ticket)
            ->with('message', $message)
            ->with('success', 'Ticket Editado');
      
        } catch (\Throwable $th) {
            Log::error('editUser -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        } 
    }

    /**
     * Funcion para editar el ticket y el mensaje del user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        try {

            // busca el ticket
            $ticket = Ticket::find($id);

            // actualiza todo
            $ticket->update($request->all());
            $ticket->save();

            // crea un nuevo mensaje para el admin
            if($request->message == true){
                TicketMessage::create([
                    'user' => Auth::id(),
                    'admin' => '1',
                    'ticket' => $ticket->id,
                    'type' => '0',
                    'message' => $request->message,
                ]);
            }

            return redirect()->back()->with('success', 'Ticket Editado');

        } catch (\Throwable $th) {
            Log::error('updateUser -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        } 
    }

        /**
     * Muestra la vista para editar un ticket del admin
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function editAdmin($id)
    {
        try {

            $ticket = Ticket::find($id);
            $message = TicketMessage::where('ticket', $id)->orderby('created_at','ASC')->get();
      
            return view('tickets.admin.edit-admin')
            ->with('ticket', $ticket)
            ->with('message', $message)
            ->with('success', 'Ticket Editado');
      
        } catch (\Throwable $th) {
            Log::error('editAdmin -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        } 
    }

    /**
     * Funcion para editar el ticket y el mensaje del admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function updateAdmin(Request $request, $id)
    {
        try {

            // busca el ticket
            $ticket = Ticket::find($id);

            // actualiza todo
            $ticket->update($request->all());
            $ticket->save();

            // crea un nuevo mensaje para el user
            if($request->message == true){
            TicketMessage::create([
                'user' => $ticket->user,
                'admin' => Auth::id(),
                'ticket' => $ticket->id,
                'type' => '1',
                'message' => $request->message,
            ]);
            }

            return redirect()->back()->with('success', 'Ticket Editado');

        } catch (\Throwable $th) {
            Log::error('updateAdmin -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        } 
    }

    /**
     * Funcion para eliminar el ticket
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            // busca el ticket
            $ticket = Ticket::find($id);
            
            // elimina el ticket
            $ticket->delete();
            
            return redirect()->back()->with('warning', 'Ticket Eliminado');

        } catch (\Throwable $th) {
            Log::error('destroy -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        } 
    }
}
