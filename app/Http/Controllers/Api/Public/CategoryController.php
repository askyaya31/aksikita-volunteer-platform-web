<?php
namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json(['categories' => $categories]);
    }

    public function events(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $events = $category->events()
            ->with('organization')
            ->where('status', 'published')
            ->latest('start_date')
            ->paginate(12);

        return response()->json($events);
    }
}