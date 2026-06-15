<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'open');

        $statusMap = [
            'open'         => 'open',
            'under_review' => 'under_review',
            'resolved'     => 'resolved',
            'dismissed'    => 'dismissed',
        ];

        $reports = Report::with(['reporter'])
            ->where('status', $statusMap[$tab] ?? 'open')
            ->when($request->search, fn($q) => $q->where('reason', 'like', "%{$request->search}%")
                ->orWhereHas('reporter', fn($q2) => $q2->where('name', 'like', "%{$request->search}%"))
            )
            ->when($request->type, function ($q) use ($request) {
                $typeMap = ['event' => \App\Models\Event::class, 'user' => \App\Models\User::class];
                if (isset($typeMap[$request->type])) {
                    $q->where('reportable_type', $typeMap[$request->type]);
                }
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'open'         => Report::where('status', 'open')->count(),
            'under_review' => Report::where('status', 'under_review')->count(),
            'resolved'     => Report::where('status', 'resolved')->count(),
            'dismissed'    => Report::where('status', 'dismissed')->count(),
        ];

        return view('admin.reports', compact('reports', 'tab', 'counts'));
    }

    public function show(int $id)
    {
        $report = Report::with(['reporter', 'resolvedBy', 'reportable'])->findOrFail($id);

        return view('admin.reports.show', compact('report'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'action'      => 'required|in:under_review,resolve,dismiss',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $report = Report::findOrFail($id);

        $statusMap = [
            'under_review' => 'under_review',
            'resolve'      => 'resolved',
            'dismiss'      => 'dismissed',
        ];

        $data = ['status' => $statusMap[$request->action]];

        if (in_array($request->action, ['resolve', 'dismiss'])) {
            $data['resolved_by'] = session('user_id');
            $data['resolved_at'] = now();
            $data['admin_notes'] = $request->admin_notes;
        }

        $report->update($data);

        return redirect()
            ->route('admin.reports.show', ['id' => $report->id])
            ->with('success', 'Status laporan berhasil diperbarui.');
    }
}