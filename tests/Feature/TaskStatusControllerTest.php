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

    /**
     * Test of task statuses index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    /**
     * Test of task statuses create.
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.create'));
        $response->assertOk();
    }

    /**
     * Test of task statuses edit.
     *
     * @return void
     */
    public function testEdit(): void
    {
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.edit', ['task_status' => $status]));
        $response->assertOk();
    }

    /**
     * Test of task statuses store.
     *
     * @return void
     */
    public function testStore(): void
    {
        $taskStatusInputData = TaskStatus::factory()
        ->make()
        ->only(['name']);

        $response = $this->actingAs($this->user)
            ->post(route('task_statuses.store'), $taskStatusInputData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->get(route('task_statuses.index'))->assertSee($taskStatusInputData['name']);
        $this->assertDatabaseHas('task_statuses', $taskStatusInputData);
    }

    /**
     * Test of task statuses update.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $status = TaskStatus::factory()->create();

        $taskStatusInputData = TaskStatus::factory()
        ->make()
        ->only(['name']);

        $response = $this->actingAs($this->user)
            ->patch(route('task_statuses.update', ['task_status' => $status]), $taskStatusInputData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->get(route('task_statuses.index'))->assertSee($taskStatusInputData['name']);
        $this->assertDatabaseHas('task_statuses', $taskStatusInputData);
    }

    /**
     * Test of task statuses delete.
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', ['task_status' => $status]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }
}
