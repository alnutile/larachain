<?php

namespace App\Http\Controllers\ResponeTypes;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\ResponseType;

abstract class BaseResponseTypeController extends Controller
{
    abstract public function create(Outbound $outbound);

    abstract public function show(Outbound $outbound);

    abstract public function edit(Outbound $outbound, ResponseType $response_type);

    abstract public function store(Outbound $outbound);

    abstract public function update(Outbound $outbound, ResponseType $response_type);
}
