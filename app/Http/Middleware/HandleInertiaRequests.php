<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Pennant\Feature;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        $features = Feature::all();

        return array_merge(parent::share($request), [
            'features' => $features,
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'team_label' => 'Organization Name',
            'larachain' => config('larachain'),
        ]);
    }
}
