<?php
namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\SavedEvent;
use Illuminate\Http\Request;

class SavedEventController extends Controller
{
    public function index(Request $request)
    {
        $saved = SavedEvent::with(['event.organization', 'event.categories'])
            ->where('user_id', auth()->user()->id)
            ->latest('saved_at')
            ->get();

        return view('volunteer.saved', compact('saved'));
    }
}