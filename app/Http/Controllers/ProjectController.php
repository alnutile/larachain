<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Outbound\OutboundEnum;
use App\Source\SourceTypeEnum;
use App\Transformers\TransformerTypeEnum;
use Facades\App\Tools\ChatRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::query()
                ->where('team_id',
                auth()->user()->current_team_id)
                ->orderBy('updated_at', 'DESC')
                ->simplePaginate(10)
                ->withQueryString(),
        ]);
    }

    public function chat(Project $project)
    {
        $validated = request()->validate([
            'question' => ['required', 'max:5000'],
        ]);

        try {
            ChatRepository::handle($project, auth()->user(), $validated['question']);

            return response()->json([], 200);
        } catch (\Exception $e) {
            logger($e->getMessage());
            logger($e);

            return response()->json('Please try again later', 429);
        }
    }

    public function create()
    {
        return Inertia::render('Projects/Create', [
            'project' => new Project(),
        ]);
    }

    public function deleteMessages(Project $project)
    {
        Message::where('project_id', $project->id)
            ->where('user_id', auth()->user()->id)
            ->delete();

        return response('', 200);
    }

    public function store(Request $request)
    {
        $validated = request()->validate(
            [
                'name' => 'required',
                'active' => 'nullable',
            ]
        );

        $validated['team_id'] = auth()->user()->current_team_id;

        $model = Project::create($validated);

        return redirect()->route('projects.edit', ['project' => $model->id]);
    }

    public function show(Project $project)
    {
        $sourceTypes = SourceTypeEnum::toArray();
        $transformerTypes = TransformerTypeEnum::toArray();
        $outboundTypes = OutboundEnum::toArray();

        return Inertia::render('Projects/Show', [
            'source_types' => $sourceTypes,
            'transformer_types' => $transformerTypes,
            'outbound_types' => $outboundTypes,
            'project' => $project->load('documents', 'sources', 'transformers', 'outbounds')
                ->loadCount('documents'),
        ]);
    }

    public function edit(Project $project)
    {
        if (request()->user()->cannot('edit', $project)) {
            abort(403);
        }

        return Inertia::render('Projects/Edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        if ($request->user()->cannot('update', $project)) {
            abort(403);
        }

        $validated = request()->validate(
            [
                'name' => 'required',
                'active' => 'nullable',
                'team_id' => 'required',
            ]
        );

        $project->update($validated);

        return redirect()->route('projects.edit', ['project' => $project->id]);
    }

    public function destroy($id)
    {
        //
    }
}
