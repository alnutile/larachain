<?php

namespace App\Http\Controllers;

use App\Models\[RESOURCE_PROPER];
use Illuminate\Http\Request;
use Inertia\Inertia;

class [RESOURCE_PROPER]Controller extends Controller
{
    public function index()
    {
        return Inertia::render('[RESOURCE_PROPER_PLURAL]/Index', [
            /** @phpstan-ignore-next-line */
            '[RESOURCE_PLURAL_KEY]' => [RESOURCE_PROPER]::query()
                ->orderBy('updated_at', 'DESC')
                ->simplePaginate(10)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return Inertia::render('[RESOURCE_PROPER_PLURAL]/Create', [
            '[RESOURCE_SINGULAR_KEY]' => new [RESOURCE_PROPER](),
        ]);
    }

    public function store(Request $request)
    {
        $validated = request()->validate(
            [
                'subject' => 'required',
                'message' => 'required',
                'active' => 'required',
                'campaign_id' => 'required',
            ]
        );

        $model = [RESOURCE_PROPER]::create($validated);

        return redirect()->route('[RESOURCE_PLURAL_KEY].edit', ['[RESOURCE_SINGULAR_KEY]' => $model->id]);
    }


    public function show([RESOURCE_PROPER] $[RESOURCE_SINGULAR_KEY])
{
    return Inertia::render('[RESOURCE_PROPER_PLURAL]/Show', [
        '[RESOURCE_SINGULAR_KEY]' => $[RESOURCE_SINGULAR_KEY],
    ]);
}

    public function edit([RESOURCE_PROPER] $[RESOURCE_SINGULAR_KEY])
    {
        return Inertia::render('[RESOURCE_PROPER_PLURAL]/Edit', [
            '[RESOURCE_SINGULAR_KEY]' => $[RESOURCE_SINGULAR_KEY],
        ]);
    }

    public function update(Request $request, [RESOURCE_PROPER] $[RESOURCE_SINGULAR_KEY])
    {
        $validated = request()->validate(
            [
                'subject' => 'required',
                'message' => 'required',
                'active' => 'required',
                'campaign_id' => 'required',
            ]
        );

        $[RESOURCE_SINGULAR_KEY]->update($validated);

        return redirect()->route('[RESOURCE_PLURAL_KEY].edit', ['[RESOURCE_SINGULAR_KEY]' => $[RESOURCE_SINGULAR_KEY]->id]);
    }

    public function destroy($id)
    {
        //
    }
}
