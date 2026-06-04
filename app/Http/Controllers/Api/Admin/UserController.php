<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return UserResource::collection($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with(['volunteerProfile', 'organizationProfile'])->findOrFail($id);
        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    public function toggleActive(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        if ($user->isAdmin()) {
            return response()->json(['message' => 'Akun admin tidak bisa dinonaktifkan.'], 422);
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json(['message' => "Akun berhasil {$status}."]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return response()->json(['message' => 'Akun admin tidak bisa dihapus.'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Akun berhasil dihapus.']);
    }
}