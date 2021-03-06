<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\CreateRequest;
use App\Project;
use App\Services\VkReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    protected $report_service;

    public function __construct(VkReportService $report_service)
    {
        $this->report_service = $report_service;
    }

    public function index()
    {

        if (Gate::allows('admin-project')) {

            $projects = Project::all();
        }
        else {
            $projects = Project::where('user_id', '=', auth()->user()->id)->get();
        }

        return view('projects.index', compact('projects'));
    }


    public function create()
    {

        return view('projects.create');
    }


    public function store(CreateRequest $request)
    {
        Project::create([
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('projects.index');
    }


    public function show(Project $project)
    {
        if (Gate::denies('view-project', $project)) {
            return response('Access Denied', 403);
        }

        return view('projects.show', compact('project'));

    }


    public function edit(Project $project)
    {

        if (Gate::denies('update-project', $project)) {
            return response('Access Denied', 403);
        }

        return view('projects.edit', compact('project'));
    }


    public function update(Request $request, Project $project)
    {
        if (Gate::denies('update-project', $project)) {
            return response('Access Denied', 403);
        }

        $project->update([
            'name' => $request->get('name'),
            'url' => $request->get('url')
        ]);

        return redirect()->route('projects.index');
    }


    public function destroy(Project $project)
    {
        if (Gate::denies('delete-project', $project)) {
            return response('Access Denied', 403);
        }

        $project->delete();
        return redirect()->route('projects.index');
    }

    public function report(Request $request, Project $project)
    {
        if (Gate::denies('report-project', $project)) {
            return response('Access Denied', 403);
        }

        if(empty($request->input('from')) || empty($request->input('to')))
            return redirect(route('projects.show', $project->id))->with('error', 'Empty parameters');


        $data = $this->report_service->report($project, $request);

        $pdf = app('PDF');
        $pdf_file_name = "report-" . $project->getGroupKeyword() . "-".date('Y-m-d-H:i:s');

        $pdf = $pdf::loadView('projects.report.pdf', $data);
        return $pdf->download("{$pdf_file_name}.pdf");

    }
}
