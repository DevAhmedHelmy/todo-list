<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_guests_cannot_add_task()
    {
        $this->post('tasks')->assertRedirect('login');
    }
    /**
     * @test
     */
    public function a_task_require_a_title()
    {

        $this->signIn();
        $attributes = Task::factory()->raw(['title' => '']);
        $this->post('/tasks', $attributes)->assertSessionHasErrors('title');
    }
    /**
     * @test
     */
    public function a_task_require_a_description()
    {
        $this->signIn();
        $attributes = Task::factory()->raw(['description' => '']);
        $this->post('/tasks', $attributes)->assertSessionHasErrors('description');
    }
    /**
     * @test
     */
    public function a_task_require_a_status()
    {
        $this->signIn();
        $attributes = Task::factory()->raw(['status' => '']);
        $this->post('/tasks', $attributes)->assertSessionHasErrors('status');
    }

    /**
     * @test
     */
    public function it_can_create_a_task()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $this->get('/tasks/create')->assertStatus(200);
        $this->post('tasks', $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => 'inprogress'
        ]);
        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * @test
     */
    public function a_user_can_see_only_tasks()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        $task = Task::factory()->create(['user_id'=>$user->id]);
        $this->get('tasks')->assertSee($task->title);
    }
    /**
     * @test
     */
    public function it_can_update_task()
    {
        // $this->withoutExceptionHandling();

        $user = $this->signIn();
        $task = Task::factory()->create(['user_id'=>$user->id]);
        $this->patch($task->path(),$attributes=['title'=>'changed','description'=>'changed'])->assertRedirect($task->path());
        $this->get($task->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('tasks',$attributes);
    }
}
