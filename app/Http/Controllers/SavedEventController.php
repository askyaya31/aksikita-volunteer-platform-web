<?php

namespace App\Http\Controllers\Api\Volunteer;  // ✅ konsisten dengan controller lain

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SavedEvent;             // ✅ tambahkan ini
use App\Models\Event;                  // ✅ tambahkan ini

class SavedEventController extends Controller
{
    // GET /volunteer/saved-events
    public function index(Request $request)
    {
        $saved = SavedEvent::with('event.categories', 'event.organization')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
        
        return response()->json(['data' => $saved]);
    }
    
    // POST /volunteer/events/{event}/save  → toggle
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
    
    // DELETE /volunteer/events/{event}/save → eksplisit unsave
    public function unsave(Request $request, Event $event)
    {
        SavedEvent::where('user_id', $request->user()->id)
                  ->where('event_id', $event->id)
                  ->delete();
        
        return response()->json(['message' => 'Dihapus dari simpanan', 'saved' => false]);
    }
}

