<?php

namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Services\EventRecommendationService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function __construct(
        private EventRecommendationService $service
    ) {}

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $events = $this->service->recommend($userId, limit: 10);

        return response()->json(
            EventResource::collection($events)->collection
        );
    }
}