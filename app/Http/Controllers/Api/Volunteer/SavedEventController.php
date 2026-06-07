<?php
namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\SavedEvent;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SavedEventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $saved = SavedEvent::with(['event.organization', 'event.categories'])
            ->where('user_id', $request->user()->id)
            ->latest('saved_at')
            ->get();

        $data = $saved->map(fn($s) => [
            'id'       => $s->id,
            'event_id' => $s->event_id,
            'saved_at' => $s->saved_at,
            'event'    => $s->event ? new EventResource($s->event) : null,
        ]);

        return response()->json(['data' => $data]);
    }

    public function toggle(Request $request, int $id): JsonResponse
    {
        $user  = $request->user();
        $saved = SavedEvent::where('user_id', $user->id)
            ->where('event_id', $id)
            ->first();

        if ($saved) {
            $saved->delete();
            return response()->json([
                'saved'   => false,
                'message' => 'Kegiatan dihapus dari simpanan.',
            ]);
        }

        SavedEvent::create(['user_id' => $user->id, 'event_id' => $id]);

        return response()->json([
            'saved'   => true,
            'message' => 'Kegiatan berhasil disimpan.',
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        SavedEvent::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->delete();

        return response()->json(['message' => 'Dihapus dari simpanan.']);
    }
}