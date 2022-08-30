<?php

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Models\Monitor;
use App\Services\MonitorService;
use Tests\TestCase;


    class MonitorServiceTest extends TestCase
{

    private MonitorService $monitorService;

    protected function setUp(): void
    {
        $this->monitorService = app(MonitorService::class);
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_monitor_working_correct(): void
    {
        $monitor = $this->monitorService->createMonitor('Test monitor');
        $this->assertEquals('Test monitor', $monitor->name);
        $this->assertEquals(Monitor::STATUS_UP, $monitor->status);
        $this->assertTrue(!empty($monitor->id));
    }

    public function test_get_monitor_by_id(): void
    {
        $monitor = $this->monitorService->createMonitor('Test monitor');

        $newMonitor = $this->monitorService->getMonitor($monitor->id);

        $this->assertEquals($monitor->id, $newMonitor->id);
        $this->assertEquals($monitor->name, $newMonitor->name);
        $this->assertEquals($monitor->created_at, $newMonitor->created_at);
        $this->assertEquals($monitor->updated_at, $newMonitor->updated_at);
        $this->assertEquals($monitor->status, $newMonitor->status);
    }

    public function test_update_monitor(): void
    {
        $monitor = $this->monitorService->createMonitor('Test monitor');

        $newMonitor = $this->monitorService->updateMonitor($monitor->id, [
            'name' => 'New Name'
        ]);

        $this->assertEquals('New Name', $newMonitor->name);

        $this->assertEquals($monitor->id, $newMonitor->id);
        $this->assertEquals($monitor->created_at, $newMonitor->created_at);
        $this->assertEquals($monitor->updated_at, $newMonitor->updated_at);
        $this->assertEquals($monitor->status, $newMonitor->status);
    }

    public function test_delete_monitor(): void
    {
        $monitor = $this->monitorService->createMonitor('Test monitor');

        $this->monitorService->deleteMonitor($monitor->id);

        $this->expectException(NotFoundException::class);
        $this->monitorService->getMonitor($monitor->id);
    }
}
