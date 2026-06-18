<?php

namespace App\Http\Controllers\Api\Volunteer;  

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LikedEvent;            
use App\Models\Event;               
 
class LikedEventController extends Controller
{
   
    public function index(Request $request)
    {
        $liked = LikedEvent::with('event.categories', 'event.organization')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
        
        return response()->json(['data' => $liked]);
    }
    
    public function toggle(Request $request, Event $event)
    {
        $userId  = $request->user()->id;
        $existing = LikedEvent::where('user_id', $userId)
                               ->where('event_id', $event->id)
                               ->first();
        
        if ($existing) {
            $existing->delete();
            $count = LikedEvent::where('event_id', $event->id)->count();
            return response()->json([
                'message'     => 'Dihapus dari suka',
                'liked'       => false,
                'likes_count' => $count
            ]);
        }
        
        LikedEvent::create(['user_id' => $userId, 'event_id' => $event->id]);
        $count = LikedEvent::where('event_id', $event->id)->count();
        return response()->json([
            'message'     => 'Berhasil disukai',
            'liked'       => true,
            'likes_count' => $count
        ]);
    }
}