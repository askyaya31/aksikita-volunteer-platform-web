<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $reports = Report::with(['reporter', 'resolvedBy'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('reportable_type', $request->type))
            ->latest()
            ->paginate(15);

        return response()->json($reports);
    }

    public function show(int $id): JsonResponse
    {
        $report = Report::with(['reporter', 'resolvedBy', 'reportable'])->findOrFail($id);

        return response()->json(['report' => $report]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'reportable_type' => 'required|in:event,user',
            'reportable_id'   => 'required|integer',
            'reason'          => 'required|string|max:255',
            'description'     => 'nullable|string|max:2000',
        ]);

        $typeMap = [
            'event' => \App\Models\Event::class,
            'user'  => \App\Models\User::class,
        ];

        $reportableClass = $typeMap[$request->reportable_type];

        if (!$reportableClass::find($request->reportable_id)) {
            return response()->json([
                'message' => ucfirst($request->reportable_type) . ' yang dilaporkan tidak ditemukan.',
            ], 404);
        }

        if ($request->reportable_type === 'user' && $request->reportable_id == $request->user()->id) {
            return response()->json([
                'message' => 'Tidak bisa melaporkan akun sendiri.',
            ], 422);
        }
        
        $duplikat = Report::where('reporter_id', $request->user()->id)
            ->where('reportable_type', $reportableClass)
            ->where('reportable_id', $request->reportable_id)
            ->whereIn('status', ['open', 'under_review'])
            ->exists();

        if ($duplikat) {
            return response()->json([
                'message' => 'Anda sudah memiliki laporan yang sedang diproses untuk item ini.',
            ], 422);
        }

        $report = Report::create([
            'reporter_id'     => $request->user()->id,
            'reportable_type' => $reportableClass,
            'reportable_id'   => $request->reportable_id,
            'reason'          => $request->reason,
            'description'     => $request->description,
            'status'          => 'open',
        ]);

        return response()->json([
            'message' => 'Laporan berhasil dikirim. Tim kami akan meninjau laporan Anda.',
            'report'  => $report,
        ], 201);
    }

    public function resolve(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'action'      => 'required|in:resolve,dismiss',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $report = Report::findOrFail($id);
        $admin  = $request->user();

        $status = $request->action === 'resolve' ? 'resolved' : 'dismissed';

        $report->update([
            'status'      => $status,
            'resolved_by' => $admin->id,
            'resolved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json(['message' => "Laporan berhasil ditandai sebagai {$status}."]);
    }
}
