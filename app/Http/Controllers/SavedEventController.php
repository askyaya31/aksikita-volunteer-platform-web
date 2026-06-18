<?php

namespace App\Http\Controllers\Api\Volunteer;  

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SavedEvent;            
use App\Models\Event;                  

class SavedEventController extends Controller
{
    public function index(Request $request)
    {
        $saved = SavedEvent::with('event.categories', 'event.organization')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
        
        return response()->json(['data' => $saved]);
    }
    
    public function toggle(Request $request, Event $event)
    {
        $userId = $request->user()->id;
        $existing = SavedEvent::where('user_id', $userId)
                              ->where('event_id', $event->id)
                              ->first();
        
        if ($existing) {
            $existing->delete();
            return response()->json(['message' => 'Dihapus dari simpanan', 'saved' => false]);
        }
        
        SavedEvent::create(['user_id' => $userId, 'event_id' => $event->id]);
        return response()->json(['message' => 'Berhasil disimpan', 'saved' => true]);
    }
    
    public function unsave(Request $request, Event $event)
    {
        SavedEvent::where('user_id', $request->user()->id)
                  ->where('event_id', $event->id)
                  ->delete();
        
        return response()->json(['message' => 'Dihapus dari simpanan', 'saved' => false]);
    }
}

