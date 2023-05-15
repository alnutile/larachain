<?php

namespace App\Http\Controllers\ResponseTypes;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\ResponseType;

abstract class BaseResponseTypeController extends Controller
{
    abstract public function create(Outbound $outbound);

    public function show(Outbound $outbound, ResponseType $response_type)
    {
        request()->session()->flash('flash.banner', 'No Settings for this 🤷🏻‍');

        return back();
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        request()->session()->flash('flash.banner', 'No Settings for this 🤷🏻‍');

        return back();
    }

    abstract public function store(Outbound $outbound);

    abstract public function update(Outbound $outbound, ResponseType $response_type);
}
