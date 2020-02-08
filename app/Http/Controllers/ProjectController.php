<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\CreateRequest;
use App\Project;
use App\Services\Vk;
use App\Services\VkApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{

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

        $from = $request->input('from');
        $to = $request->input('to');

        if(empty($from) || empty($to))
            return redirect(route('projects.show', $project->id))->with('error', 'Empty parameters');

        $date_from = date_format(date_create($from),'U');
        $date_to = date_format(date_create($to),'U');

        $group_keyword = str_replace("/","",parse_url($project->url, PHP_URL_PATH));

        $pdf = app('PDF');
        $pdf_file_name = "report-{$group_keyword}-".date('Y-m-d-H:i:s');

        $vkApi = new VkApi('5.101');
        $params = [
            'domain' => $group_keyword,
            'count' => 100,
            'filter' => 'owner',
            'offset' => 0,
        ];

        $response = $vkApi->request('wall.get', $params, config('vk.app_key'));


        $vk = new Vk;
        $items = $vk->getItems($date_from,$date_to, $response);
        $views = $vk->getSumViews($items);
        $likes = $vk->getSumLikes($items);
        $reposts = $vk->getSumReposts($items);
        $comments = $vk->getSumComments($items);

        $data = ['views' => $views,
            'likes' => $likes,
            'reposts' => $reposts,
            'comments' => $comments,
            'items' => $items];


        $pdf = $pdf::loadView('projects.report.pdf', $data);
        return $pdf->download("{$pdf_file_name}.pdf");

    }
}
