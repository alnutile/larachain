<?php

it('test message cleaner', function () {
    $in = get_fixture('message_needs_fixing.json');
    $expected = get_fixture('expected.json');

    $out = clean_messages($in);
    expect($out)->toEqual($expected);
});


it('test makes filename from url', function () {
    $url = "codes_displaySection.xhtml?sectionNum=10729.&lawCode=WAT";
    $out = file_name_from_url($url);
    expect($out)->toEqual("codes_displaySection.xhtml.html");
});

it('test appends html once', function () {
    $url = "codes_displaySection.html";
    $out = file_name_from_url($url);
    expect($out)->toEqual("codes_displaySection.html");
});
