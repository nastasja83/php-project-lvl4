<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testShow()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', ['task' => $task]));
        $response->assertOk();
    }

    public function testEdit()
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
    public function testStore()
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
    public function testUpdate()
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
    public function testDestroy()
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', ['task' => $task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
