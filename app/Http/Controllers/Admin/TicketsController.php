<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Services\UploadService;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    //
    //
    public function index(Request $request, $ticket_id = null)
    {
        # code...
        $tickets = Ticket::with('user')->get();
        $ticket = Ticket::where('id', $ticket_id)->with(['ticket_messages' => function ($query) {
            $query->with('user');
        }])->first();

        if ($ticket) {
            $ticket->save();
            // return $ticket;
        }

        // return $tickets;

        return view('admin.tickets.list-tickets', [
            'title'     => 'تیکت های پشتیبانی',
            'tickets'   => $tickets,
            'ticket'    => $ticket,
        ]);
    }

    public function ticketAdd(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'level' => $request->level,
            'type' => 'OPEN',
            'status_id' => '',
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'autoRedirect' => route('user.tickets', ['ticket_id' => $ticket->id])
        ], 200);
    }
    

    public function ticketAddReply (Request $request, $ticket_id)
    {
        # code...
        // return $request;
        $request->validate([
            'message'=> "required"
        ]);

        $user = auth()->user();

        if($request->imageUrl != 'undefined'){
            $request->validate([
                'imageUrl'=> 'nullable|image|max:300',
            ]);
            $request->validate([
                'imageUrl' => 'image|max:300|mimes:jpeg,jpg,png',
            ]);
            $date = date('Y-m-d');
            $path = "images/uploads/tickets/$user->id/$date";
            $photos = [$request->imageUrl];
            $photos = UploadService::saveFile($path, $photos);

        }

        
        $ticket = Ticket::where('id', $ticket_id)->update([
            'status_id'=>0
        ]);

        TicketMessage::create([
            'ticket_id' =>$ticket_id,
            'user_id'   =>$user->id,
            'message'   =>$request->message,
            'paths'     => $photos ?? '',
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'autoRedirect' => route('admin.tickets', ['ticket_id' => $ticket_id])
        ], 200);
    }
}
