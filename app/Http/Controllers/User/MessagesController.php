<?php

namespace App\Http\Controllers\User;

use App\Events\MessageNotification;
use App\Events\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    //
    public function messages(Request $request)
    {
        # code...
        $user = Auth::user();
        $user_id = $user->id;
        $messages = Message::whereNull('deleted_at')
            ->where(function ($q1) use ($user_id) {
                $q1->where('user_sender_id', $user_id)->orWhere('user_receiver_id', $user_id);
            })
            ->select(
                'id',
                DB::raw('CONCAT(substr(message, 1, 20), "...") as message_sub'),
                'title',
                'user_sender_id',
                'user_receiver_id',
                'created_at',
                DB::Raw("IF(user_sender_id=$user_id, CONCAT(user_sender_id, '_', user_receiver_id), CONCAT(user_receiver_id, '_', user_sender_id)) as 2col")
                // DB::raw('select id, count(*) from messages as m join message_user as mu on m.id=mu.message_id and m.user_sender_id=mu.user_id')
                // , DB::raw('count(*) as countread where status_id=0')//DB::raw("SELECT count(id) as countread from messages where user_receiver_id=$user_id AND status_id=1")
            )
            ->whereIn('id', function ($q) use ($user_id) {
                $q->select(DB::raw("MAX(id) FROM messages GROUP BY IF(user_sender_id=$user_id, CONCAT(user_sender_id, '_', user_receiver_id), CONCAT(user_receiver_id, '_', user_sender_id))"));
                // $q->select(DB::raw('MAX(id) FROM messages GROUP BY user_sender_id,user_receiver_id'));
            })
            ->with([
                'sender' => function ($qSender) {
                    $qSender->select(
                        'id',
                        DB::raw('CONCAT(firstname, lastname) as full_name'),
                        DB::raw('CONCAT("09*****", substr(phone, -4)) as phone_sub')
                    )->with('image');
                },
                'receiver' => function ($qSender) {
                    $qSender->select(
                        'id',
                        DB::raw('CONCAT(firstname, lastname) as full_name'),
                        DB::raw('CONCAT("09*****", substr(phone, -4)) as phone_sub')
                    )->with('image');
                },
                'read'
            ])
            ->orderBy('id', 'desc')
            ->groupBy('user_sender_id', 'user_receiver_id')
            ->get();

        // return $messages;//[0]->users->isNotEmpty();
        return view('user.messages.list-chats', [
            'title' => 'پیام ها',
            'messages' => $messages,
            'load_chats' => '',//$this->loadChat($user->id)['view_chat'],
            'load_header' => '',//$this->loadChat($user->id)['view_header'],
            'load_form' => '',//$this->loadChat($user->id)['view_form'],
        ]);
    }

    public function loadChat($sender_id)
    {
        # code...
        // return [
        //     'view_chat' =>  $sender_id,
        //     'view_header' =>  $sender_id,
        //     'view_form' =>  $sender_id,
        // ];
        $user = Auth::user();


        $contact = User::where('id', $sender_id)->select(
            'id',
            DB::raw('CONCAT(firstname, lastname) as full_name'),
            DB::raw('CONCAT("09*****", substr(phone, -4)) as phone_sub')
        )->with('image')->first();

        $messages = Message::select('*')->whereNull('deleted_at')
            ->where(function ($q1) use ($user, $sender_id) {
                $q1->where('user_sender_id', $user->id)
                    ->where('user_receiver_id', $sender_id);
            })
            ->orWhere(function ($q2) use ($user, $sender_id) {
                $q2->where('user_sender_id', $sender_id)
                    ->where('user_receiver_id', $user->id);
            })
            ->with([
                'sender' => function ($qSender) {
                    $qSender->select(
                        'id',
                        DB::raw('CONCAT(firstname, lastname) as full_name'),
                        DB::raw('CONCAT("09*****", substr(phone, -4)) as phone_sub')
                    )->with('image');
                },
                'receiver' => function ($qSender) {
                    $qSender->select(
                        'id',
                        DB::raw('CONCAT(firstname, lastname) as full_name'),
                        DB::raw('CONCAT("09*****", substr(phone, -4)) as phone_sub')
                    )->with('image');
                },
                'read'
            ])
            // ->orderBy('id', 'desc')
            ->groupBy('id')
            ->paginate(70);

        $listMessages = Message::where(['user_receiver_id'=> $user->id, 'user_sender_id'=> $sender_id, 'status_id' => 0]);
        $user->readAttach()->attach($listMessages->pluck('id'));
        $listMessages->update(['status_id'=> 1]);
        // return $listMessages->pluck('id');



        return [
            'view_chat' =>  view('user.messages.load-chat', ['messages' => $messages,])->render(),
            'view_header' =>  view('user.messages.load-header', ['contact' => $contact,])->render(),
            'view_form' =>  view('user.messages.load-form', ['sender_id' => $sender_id,])->render(),
        ];
        return $contact; //->count();
    }

    public function sendMessage(Request $request, $user_id)
    {
        # code...
        // return $request->all();
        $request->validate([
            'message' => 'required',
            'sender_id' => 'required',
        ]);

        $message = Message::create([
            'user_sender_id'        => Auth::id(),
            'user_receiver_id'      => (int)$request->sender_id,
            'user_receiver_type'    => '',
            'status_id'             => '0',
            'title'                 => substr(strip_tags($request->message), 0, 50),
            'message'               => $request->message,
        ]);

        event(new MessageNotification($message));

        return response()->json([
            'status' => 'success',
            'title' => 'success',
            'message' => 'ارسال شد',
            'data' => $message,

        ], 200);
    }
}
