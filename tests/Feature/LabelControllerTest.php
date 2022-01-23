<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    public function testEdit()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', ['label' => $label]));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = Label::factory()
        ->make()
        ->only(['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store', $data));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->get(route('labels.index'))->assertSee($data['name']);
        $this->assertDatabaseHas('labels', $data);
    }

    public function testUpdate()
    {
        $label = Label::factory()->create();

        $data = Label::factory()
        ->make()
        ->only(['name']);

        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', ['label' => $label]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->get(route('labels.index'))->assertSee($data['name']);
        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $label = Label::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', ['label' => $label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
