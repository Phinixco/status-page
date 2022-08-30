<?php

namespace Tests\Feature;

use App\Models\Monitor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_monitor()
    {
        Carbon::setTestNow();

        $response = $this->post('api/monitors', [
            'name' => 'Test Monitor'
        ]);

        $response->assertStatus(201);


        $response->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'name',
                'created_at',
                'updated_at',
            ]
        ]);

        $response->assertJsonPath('data.name', 'Test Monitor');
        $response->assertJsonPath('data.status', Monitor::STATUS_UP);
        $response->assertJsonPath('data.created_at', Carbon::now()->toIso8601ZuluString());
        $response->assertJsonPath('data.updated_at', Carbon::now()->toIso8601ZuluString());
    }


    public function test_create_monitor_without_name()
    {
        $response = $this->post('api/monitors', [
        ]);

        $response->assertStatus(422);

    }

    public function test_get_monitor_by_id()
    {
        $response = $this->post('api/monitors', [
            'name' => 'Test Monitor'
        ]);

        $id = $response->json('data.id');

        $response = $this->get('api/monitors/' . $id);

        $response->assertStatus(200);


        $response->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'name',
                'created_at',
                'updated_at',
            ]
        ]);

        $response->assertJsonPath('data.id', $id);
        $response->assertJsonPath('data.name', 'Test Monitor');
        $response->assertJsonPath('data.status', Monitor::STATUS_UP);
        $response->assertJsonPath('data.created_at', Carbon::now()->toIso8601ZuluString());
        $response->assertJsonPath('data.updated_at', Carbon::now()->toIso8601ZuluString());


    }

    public function test_get_monitor_by_id_not_found()
    {
        $response = $this->get('api/monitors/35352312413');
        $response->assertStatus(404);
    }


    public function test_delete_monitor_by_id()
    {
        $response = $this->post('api/monitors', [
            'name' => 'Test Monitor'
        ]);

        $id = $response->json('data.id');

        $response = $this->delete('api/monitors/' . $id);

        $response->assertStatus(204);


        $response = $this->get('api/monitors/' . $id);
        $response->assertStatus(404);

    }

    public function test_delete_not_found_monitor_by_id()
    {
        $response = $this->delete('api/monitors/123123312312');
        $response->assertStatus(404);
    }


    public function test_update_monitor_by_id()
    {
        $yesterday = Carbon::yesterday();
        Carbon::setTestNow($yesterday);
        $response = $this->post('api/monitors', [
            'name' => 'Test Monitor'
        ]);

        $id = $response->json('data.id');

        Carbon::setTestNow();

        $response = $this->patch('api/monitors/' . $id, [
            'name' => 'New name',
            'status' => 'DOWN',
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'name',
                'created_at',
                'updated_at',
            ]
        ]);

        $response->assertJsonPath('data.id', $id);
        $response->assertJsonPath('data.name', 'New name');
        $response->assertJsonPath('data.status', Monitor::STATUS_UP);
        $response->assertJsonPath('data.created_at', $yesterday->toIso8601ZuluString());
        $response->assertJsonPath('data.updated_at', Carbon::now()->toIso8601ZuluString());
    }
}
