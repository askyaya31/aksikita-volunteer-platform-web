<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SavedEvent;
use Illuminate\Http\Request;

class SavedEventController extends Controller
{
    public function index(Request $request)
    {
        $saved = SavedEvent::with(['event.organization', 'event.categories'])
            ->where('user_id', session('user_id'))
            ->latest('saved_at')
            ->get();

        return view('volunteer.saved', compact('saved'));
    }

    public function toggle(Request $request, int $id)
    {
        $event  = Event::findOrFail($id);
        $userId = session('user_id');

        $existing = SavedEvent::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'saved'   => false,
                'message' => 'Kegiatan dihapus dari simpanan.',
            ]);
        }

        SavedEvent::create([
            'user_id'  => $userId,
            'event_id' => $event->id,
        ]);

        return response()->json([
            'saved'   => true,
            'message' => 'Kegiatan berhasil disimpan.',
        ]);
    }
}
