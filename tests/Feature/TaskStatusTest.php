<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\User;

class TaskStatusControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.edit', ['task_status' => $status]));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = TaskStatus::factory()
        ->make()
        ->only(['name']);

        $response = $this->actingAs($this->user)
            ->post(route('task_statuses.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->get(route('task_statuses.index'))->assertSee($data['name']);
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testUpdate()
    {
        $status = TaskStatus::factory()->create();

        $data = TaskStatus::factory()
        ->make()
        ->only(['name']);

        $response = $this->actingAs($this->user)
            ->patch(route('task_statuses.update', ['task_status' => $status]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->get(route('task_statuses.index'))->assertSee($data['name']);
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', ['task_status' => $status]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }
}
