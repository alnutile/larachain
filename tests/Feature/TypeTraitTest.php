<?php

namespace Tests\Feature;

use App\Helpers\TypeTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TypeTraitTest extends TestCase
{
    use TypeTrait;


    public function test_active() {

        // Load the fixture configuration file
        $fixtureConfig = require base_path('tests/fixtures/larachain.php');
        // Set the configuration values
        config(['larachain' => $fixtureConfig]);

        $results = $this->toArray("sources");
        // Set the configuration values
        $this->assertCount(2, $results);
    }


    public function test_defaults() {
        $fixtureConfig = require base_path('tests/fixtures/larachain.php');
        config(['larachain' => $fixtureConfig]);

        $results = $this->toArray("sources");
        $first = $results["web_file"];
        $this->assertEquals(
            'sources.web_file.create',
            $first['route']
        );

        $this->assertEquals(
            'web_file',
            $first['id']
        );

        $this->assertNotNull($first['icon']);
    }
}
