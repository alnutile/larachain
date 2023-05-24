<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use YlsIdeas\FeatureFlags\Facades\Features;

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

        $features = [
            'private_web' => Features::accessible('private_web'),
        ];

        return array_merge(parent::share($request), [
            'feature_flags' => $features,
            'app_name' => config('app.name'),
            'team_label' => 'Organization Name',
            'larachain' => config('larachain'),
        ]);
    }
}
