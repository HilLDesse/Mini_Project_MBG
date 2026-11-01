<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Report;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index()
    {
        $reports = auth()->user()
            ->reports()
            ->with('distribution.school', 'distribution.sppg')
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function show(int $id)
    {
        $report = auth()->user()
            ->reports()
            ->with('distribution.school', 'distribution.sppg')
            ->findOrFail($id);

        return view('reports.show', compact('report'));
    }

    public function edit(int $id)
    {
        $report = auth()->user()
            ->reports()
            ->with('distribution')
            ->findOrFail($id);

        if (!in_array($report->status, [
            'menunggu_peninjauan',
            'perlu_informasi_tambahan',
        ])) {
            abort(403, 'Laporan tidak dapat diubah pada status ini.');
        }

        $schools = School::orderBy('name')->get();

        return view('reports.edit', compact('report', 'schools'));
    }

    public function update(Request $request, int $id)
    {
        $report = auth()->user()
            ->reports()
            ->findOrFail($id);

        if (!in_array($report->status, [
            'menunggu_peninjauan',
            'perlu_informasi_tambahan',
        ])) {
            abort(403, 'Laporan tidak dapat diubah pada status ini.');
        }

        $validated = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'distribution_id' => [
                'required',
                Rule::exists('distributions', 'id')
                    ->where('school_id', $request->school_id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'incident_date' => ['required', 'date'],
            'evidence' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ]);

        $oldEvidencePath = $report->evidence_path;

        if ($request->hasFile('evidence')) {
            $validated['evidence_path'] = $request->file('evidence')
                ->store('reports/evidence', 'local');
        }

        $report->update([
            'distribution_id' => $validated['distribution_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'incident_date' => $validated['incident_date'],
            'evidence_path' => $validated['evidence_path']
                ?? $report->evidence_path,
        ]);

        if (
            $request->hasFile('evidence')
            && $oldEvidencePath
        ) {
            Storage::disk('local')->delete($oldEvidencePath);
        }

        return redirect()
            ->route('reports.show', $report->id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();

        return view('reports.create', compact('schools'));
    }

    public function distributionsBySchool(Request $request)
    {
        $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        $distributions = Distribution::where(
            'school_id',
            $request->school_id
        )
            ->orderByDesc('distribution_date')
            ->get(['id', 'distribution_date']);

        return response()->json($distributions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'distribution_id' => [
                'required',
                Rule::exists('distributions', 'id')
                    ->where('school_id', $request->school_id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'incident_date' => ['required', 'date'],
            'evidence' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ]);

        $evidencePath = null;

        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')
                ->store('reports/evidence', 'local');
        }

        Report::create([
            'user_id' => auth()->id(),
            'distribution_id' => $validated['distribution_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'incident_date' => $validated['incident_date'],
            'status' => 'menunggu_peninjauan',
            'evidence_path' => $evidencePath,
        ]);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil dibuat.');
    }
}
