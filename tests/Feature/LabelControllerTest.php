<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test of labels index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    /**
     * Test of labels create.
     *
     * @return void
     */
    public function testCreate():void
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    /**
     * Test of labels edit.
     *
     * @return void
     */
    public function testEdit():void
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', ['label' => $label]));
        $response->assertOk();
    }

    /**
     * Test of labels store.
     *
     * @return void
     */
    public function testStore():void
    {
        $labelInputData = Label::factory()
        ->make()
        ->only(['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store', $labelInputData));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->get(route('labels.index'))->assertSee($labelInputData['name']);
        $this->assertDatabaseHas('labels', $labelInputData);
    }

    /**
     * Test of labels update.
     *
     * @return void
     */
    public function testUpdate():void
    {
        $label = Label::factory()->create();

        $labelInputData = Label::factory()
        ->make()
        ->only(['name']);

        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', ['label' => $label]), $labelInputData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->get(route('labels.index'))->assertSee($labelInputData['name']);
        $this->assertDatabaseHas('labels', $labelInputData);
    }

    /**
     * Test of labels delete.
     *
     * @return void
     */
    public function testDestroy():void
    {
        $label = Label::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', ['label' => $label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
