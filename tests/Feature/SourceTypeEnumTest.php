<?php

use App\Source\SourceTypeEnum;

it('see the array output', function () {

    $results = SourceTypeEnum::toArray();

    expect($results[0]['name'])->toBe('Web File');
});
