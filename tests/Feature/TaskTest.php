<?php
namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/tasks', [
                'title' => 'Test Task',
                'description' => 'Test Description',
                'status' => 'pending'
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'description', 'status']);
    }

    public function test_user_can_list_their_tasks()
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_view_single_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $task->id,
                'title' => $task->title,
            ]);
    }

    public function test_user_can_update_their_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/tasks/{$task->id}", [
                'title' => 'Updated Title',
                'status' => 'completed'
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Title',
                'status' => 'completed',
            ]);
    }

    public function test_user_can_delete_their_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_access_other_users_tasks()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user1->id]);
        $token = auth()->login($user2);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(403);
    }
}