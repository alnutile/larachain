<?php

it('test message cleaner', function () {
    $in = get_fixture('message_needs_fixing.json');
    $expected = get_fixture('expected.json');

    $out = clean_messages($in);
    expect($out)->toEqual($expected);
});
