<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
    }

    /**
     * Test of tasks index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    /**
     * Test of tasks create.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    /**
     * Test of tasks show.
     *
     * @return void
     */
    public function testShow(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', ['task' => $task]));
        $response->assertOk();
    }

        /**
     * Test of tasks edit.
     *
     * @return void
     */
    public function testEdit(): void
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', ['task' => $task]));
        $response->assertOk();
    }

    /**
     * Test of tasks store.
     *
     * @return void
     */
    public function testStore(): void
    {
        $task = Task::factory()
            ->make()
            ->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $task);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->get(route('tasks.index'))->assertSee($task['name']);
        $this->assertDatabaseHas('tasks', $task);
    }

    /**
     * Test of tasks update.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $currentTask = Task::factory()->create();
        $updatedTask = Task::factory()
            ->make()
            ->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', ['task' => $currentTask]), $updatedTask);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $response = $this->get(route('tasks.index'))->assertSee($updatedTask['name']);
        $this->assertDatabaseHas('tasks', $updatedTask);
    }

    /**
     * Test of tasks delete.
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', ['task' => $task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
