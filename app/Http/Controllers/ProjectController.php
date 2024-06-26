<?php

namespace App\Http\Controllers;

use App\Data\Filters;
use App\Models\Message;
use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;
use App\Source\SourceEnum;
use App\Transformer\TransformerEnum;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            /** @phpstan-ignore-next-line */
            'projects' => Project::query()
                ->with('sources', 'outbounds')
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
            'filters' => ['nullable'],
        ]);

        try {
            $outbound = $project->outbounds()
                ->whereType(OutboundEnum::ChatUi->value)
                ->first();

            /** @var Outbound $outbound */
            $outbound->run(
                auth()->user(),
                $validated['question'],
                Filters::from($validated['filters'])
            );

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

        return redirect()->route('projects.show', ['project' => $model->id]);
    }

    public function show(Project $project)
    {
        $sourceTypes = SourceEnum::toArray();
        $transformerTypes = TransformerEnum::toArray('transformers');
        $outboundTypes = OutboundEnum::toArray('outbounds');
        $messages = Message::query()
            ->select('id', 'content', 'created_at', 'user_id', 'project_id', 'role as type')
            ->where('project_id', $project->id)
            ->where('user_id', auth()->user()->id)
            ->where('role', '!=', 'system')
            ->orderBy('id', 'ASC')
            ->get();

        return Inertia::render('Projects/Show', [
            'source_types' => $sourceTypes,
            'messages' => $messages,
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
