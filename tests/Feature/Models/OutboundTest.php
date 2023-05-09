<?php


use App\Models\Outbound;
use App\Outbound\OutboundEnum;

it("should have factory", function () {

    $model = Outbound::factory()->create();
    expect($model->type)->toBeInstanceOf(OutboundEnum::class);
});

it("has relations to project", function () {

    $model = Outbound::factory()->create();

    expect($model->project->id)->not->toBeNull();
    expect($model->project->outbounds->first()->id)->not->toBeNull();
});
