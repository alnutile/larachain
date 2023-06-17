<?php

namespace Tests\Feature\Listeners;

use App\Events\SourceRunCompleteEvent;
use App\Listeners\RunTransformersListener;
use App\Models\Document;
use App\Models\Source;
use Tests\TestCase;

class RunTransformersListenerTest extends TestCase
{

    public function test_coming_soon() {
        $this->markTestSkipped("@TODO got ahead of myself");
    }
}
