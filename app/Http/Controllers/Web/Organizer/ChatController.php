<?php

namespace App\Http\Controllers\Web\Organizer;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\Registration;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userId = (int) session('user_id');

        $rooms = ChatRoom::with(['event', 'volunteer.volunteerProfile', 'latestMessage'])
            ->where('organizer_id', $userId)
            ->where('is_open', true)
            ->latest('updated_at')
            ->get();

        return view('organizer.chat.index', compact('rooms', 'userId'));
    }

    public function show(Request $request, ChatRoom $room)
    {
        $userId = (int) session('user_id');

        abort_if($room->organizer_id !== $userId, 403);

        $room->messages()
             ->where('sender_id', '!=', $userId)
             ->whereNull('read_at')
             ->update(['read_at' => now()]);

        $messages = $room->messages()->with('sender')->get();

        $room->load('volunteer.volunteerProfile');

        return view('organizer.chat.show', compact('room', 'messages'));
    }

    public function send(Request $request, ChatRoom $room)
    {
        $userId = (int) session('user_id');

        abort_if($room->organizer_id !== $userId, 403);
        abort_if(! $room->is_open, 403, 'Ruang chat sudah ditutup.');

        $request->validate(['message' => 'required|string|max:2000']);

        $msg = ChatMessage::create([
            'chat_room_id' => $room->id,
            'sender_id'    => $userId,
            'message'      => $request->message,
        ]);

        $room->touch();

        return response()->json([
            'id'         => $msg->id,
            'message'    => $msg->message,
            'sender'     => session('user_name'),
            'is_me'      => true,
            'created_at' => $msg->created_at->format('H:i'),
        ]);
    }

    public function poll(Request $request, ChatRoom $room)
    {
        $userId = (int) session('user_id');

        abort_if($room->organizer_id !== $userId, 403);

        $after    = $request->integer('after', 0);
        $messages = $room->messages()
            ->with('sender')
            ->where('id', '>', $after)
            ->get()
            ->map(fn ($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'sender'     => $m->sender->name,
                'is_me'      => $m->sender_id === $userId,
                'created_at' => $m->created_at->format('H:i'),
            ]);

        $room->messages()
             ->where('sender_id', '!=', $userId)
             ->whereNull('read_at')
             ->update(['read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }
}