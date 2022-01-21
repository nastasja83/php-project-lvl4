<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Label;
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

    public function testStore()
    {
        $task = Task::factory()
            ->make()
            ->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $label = Label::factory()->create();

        $data = array_merge($task, ['labels' => [$label->id]]);

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->get(route('tasks.index'))->assertSee($task['name']);
        $this->assertDatabaseHas('tasks', array_merge($task, ['created_by_id' => $this->user->id]));
    }

    public function testUpdate()
    {
        $currentTask = Task::factory()->create();
        $label = Label::factory()->create();
        $updatedTask = Task::factory()
            ->make()
            ->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $data = array_merge($updatedTask, ['labels' => [$label->id]]);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', ['task' => $currentTask]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $response = $this->get(route('tasks.index'))->assertSee($updatedTask['name']);
        $this->assertDatabaseHas('tasks', $updatedTask);
        $this->assertDatabaseHas('label_task', ['label_id' => $label->id, 'task_id' => $currentTask->id]);
    }

    public function testDestroy()
    {
        $task = Task::factory()->create();
        $user = $task->creator;

        $response = $this->actingAs($user)
            ->delete(route('tasks.destroy', ['task' => $task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
