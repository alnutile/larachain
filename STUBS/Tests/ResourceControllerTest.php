<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\[RESOURCE_PROPER];
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class [RESOURCE_PROPER]ControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        [RESOURCE_PROPER]::factory()->count(3)->create();

        $this->get(route('[RESOURCE_PLURAL_KEY].index'))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('[RESOURCE_PROPER_PLURAL]/Index'));
    }

    public function test_show()
{
    Sanctum::actingAs(
        $user = User::factory()->create(),
        ['view-tasks']
    );

    $model = [RESOURCE_PROPER]::factory()->create();

        $this->get(route('[RESOURCE_PLURAL_KEY].show', [
            '[RESOURCE_SINGULAR_KEY]' => $model->id,
        ]))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('[RESOURCE_PROPER_PLURAL]/Show'));
    }

    public function test_edit()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        $model = [RESOURCE_PROPER]::factory()->create();

        $this->get(route('[RESOURCE_PLURAL_KEY].edit', [
            '[RESOURCE_SINGULAR_KEY]' => $model->id,
        ]))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('[RESOURCE_PROPER_PLURAL]/Edit'));
    }



    public function test_update()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        $model = [RESOURCE_PROPER]::factory()->create();

        $this->put(route('[RESOURCE_PLURAL_KEY].update', [
            '[RESOURCE_SINGULAR_KEY]' => $model->id,
        ]), [
            'subject' => 'foobar',
            'message' => 'foobar',
            'active' => 1,
        ])
            ->assertStatus(302)
            ->assertRedirect(route('[RESOURCE_PLURAL_KEY].edit', [
                '[RESOURCE_SINGULAR_KEY]' => $model->id,
            ]));

        $this->assertEquals('foobar', $model->refresh()->subject);
        $this->assertEquals('foobar', $model->refresh()->message);
    }

    public function test_create()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        $this->get(route('[RESOURCE_PLURAL_KEY].create'))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('[RESOURCE_PROPER_PLURAL]/Create'));
    }

    public function test_store()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

       $this->assertDatabaseCount('[RESOURCE_PLURAL_KEY]', 0);
        $this->post(route('[RESOURCE_PLURAL_KEY].create'), [
            'subject' => 'foobar',
            'message' => 'foobar',
            'active' => 1,
        ])
            ->assertStatus(302);

        $this->assertDatabaseCount('[RESOURCE_PLURAL_KEY]', 1);

        $model = [RESOURCE_PROPER]::first();

        $this->assertNotNull($model->subject);
    }
}
