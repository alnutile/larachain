<?php

namespace App\Http\Controllers\Outbounds;

use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Support\Facades\File;

class ChatGptRetrievalOutboundController extends BaseOutboundController
{
    public function create(Project $project)
    {
        $outbound = Outbound::create([
            'type' => OutboundEnum::ChatGptRetrieval,
            'active' => 1,
            'project_id' => $project->id,
        ]);

        request()->session()->flash('flash.banner', 'Created Outbound! Now to add Response Types');

        return to_route('outbounds.chat_gpt_retrieval.show',
            [
                'project' => $project->id,
                'outbound' => $outbound->id,
            ]);
    }

    public function show(Project $project, Outbound $outbound)
    {
        return inertia('Outbounds/ChatGptRetrieval/Show', [
            'details' => config('larachain.outbounds.chat_gpt_retrieval'),
            'project' => $project,
            'outbound' => $outbound->load('response_types'),
            'response_types' => ResponseTypeEnum::toArray('response_types'),
        ]);
    }

    public function edit(Project $project, Outbound $outbound)
    {
        // TODO: Implement edit() method.
    }

    public function store(Project $project)
    {
        // TODO: Implement store() method.
    }

    public function update(Project $project, Outbound $outbound)
    {
        // TODO: Implement update() method.
    }

    /**
     * @see https://github.com/openai/chatgpt-retrieval-plugin/tree/main
     */
    public function upsert() {
        logger("Upsert", request()->all());
        return response()->json([], 200);
    }

    /**
     * @see https://github.com/openai/chatgpt-retrieval-plugin/tree/main
     */
    public function upsertFile() {
        logger("Upsert File", request()->all());
        return response()->json([], 200);
    }

    /**
     * @see https://github.com/openai/chatgpt-retrieval-plugin/tree/main
     */
    public function query() {
        return response()->json([], 200);
    }

    /**
     * @see https://github.com/openai/chatgpt-retrieval-plugin/tree/main
     */
    public function delete() {
        return response()->json([], 200);
    }

    /**
     * @see https://github.com/openai/chatgpt-retrieval-plugin/tree/main
     */
    public function openApi() {
        $openaiApi = File::get(base_path("tests/fixtures/openapi.yaml"));
        return response($openaiApi, 200);
    }
}
