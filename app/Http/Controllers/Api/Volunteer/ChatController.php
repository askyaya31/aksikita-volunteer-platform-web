<?php

namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
   
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $rooms = ChatRoom::with([
                'event',
                'organizer.organizationProfile',
                'latestMessage',
            ])
            ->where('volunteer_id', $userId)
            ->latest('updated_at')
            ->get()
            ->map(fn($room) => [
                'id'                => $room->id,
                'eventTitle'        => $room->event?->title ?? '',
                'eventSlug'         => $room->event?->slug ?? '',
                'organizerName'     => $room->organizer?->organizationProfile?->organization_name
                                        ?? $room->organizer?->name ?? '',
                'organizerLogo'     => $room->organizer?->organizationProfile?->logo
                                        ? Storage::url($room->organizer->organizationProfile->logo)
                                        : null,
                'lastMessage'       => $room->latestMessage?->message,
                'lastMessageTime'   => $room->latestMessage?->created_at?->format('H:i'),
                'unreadCount'       => $room->unreadCountFor($userId),
                'isOpen'            => $room->is_open,
            ]);

        return response()->json($rooms);
    }

    public function messages(Request $request, int $roomId)
    {
        $userId = $request->user()->id;
        $room   = ChatRoom::findOrFail($roomId);

        abort_if($room->volunteer_id !== $userId, 403);

        $room->messages()
             ->where('sender_id', '!=', $userId)
             ->whereNull('read_at')
             ->update(['read_at' => now()]);

        $messages = $room->messages()
            ->with('sender')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'senderName' => $m->sender?->name ?? '',
                'isMe'       => $m->sender_id === $userId,
                'createdAt'  => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }

    public function send(Request $request, int $roomId)
    {
        $userId = $request->user()->id;
        $room   = ChatRoom::findOrFail($roomId);

        abort_if($room->volunteer_id !== $userId, 403);
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
            'senderName' => $request->user()->name,
            'isMe'       => true,
            'createdAt'  => $msg->created_at->format('H:i'),
        ], 201);
    }

    public function poll(Request $request, int $roomId)
    {
        $userId = $request->user()->id;
        $room   = ChatRoom::findOrFail($roomId);

        abort_if($room->volunteer_id !== $userId, 403);

        $after    = $request->integer('after', 0);
        $messages = $room->messages()
            ->with('sender')
            ->where('id', '>', $after)
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'message'    => $m->message,
                'senderName' => $m->sender?->name ?? '',
                'isMe'       => $m->sender_id === $userId,
                'createdAt'  => $m->created_at->format('H:i'),
            ]);

        $room->messages()
             ->where('sender_id', '!=', $userId)
             ->whereNull('read_at')
             ->update(['read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    public function unreadCount(Request $request)
    {
        $userId = $request->user()->id;

        $count = ChatRoom::where('volunteer_id', $userId)
            ->get()
            ->sum(fn($room) => $room->unreadCountFor($userId));

        return response()->json(['unread_count' => $count]);
    }
}