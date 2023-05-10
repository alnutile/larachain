<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class WebFileSourceController extends Controller
{

    public function create(Project $project) {
        return inertia("Sources/WebFile/Create");
    }
}
