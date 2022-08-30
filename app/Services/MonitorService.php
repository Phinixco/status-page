<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Monitor;
use Illuminate\Support\Facades\DB;

class MonitorService
{
    public function createMonitor(string $name): Monitor
    {
        $monitor = new Monitor();
        $monitor->name = $name;
        $monitor->status = Monitor::STATUS_UP;
        $monitor->save();

        return $monitor;
    }

    /**
     * @throws NotFoundException
     */
    public function getMonitor($id): Monitor
    {
        $monitor = Monitor::query()->find($id);

        if (!$monitor)
            throw new NotFoundException();

        return $monitor;
    }

    /**
     * @throws NotFoundException
     */
    public function updateMonitor(int $id, $data): Monitor
    {
        $result = DB::transaction(function () use ($id, $data) {
            $monitor = Monitor::query()->where('id', $id)->lockForUpdate()->first();

            if (!$monitor)
                return null;

            $monitor->fill($data);
            $monitor->save();
            return $monitor;
        });
        if (empty($result))
            throw new NotFoundException();
        return $result;
    }


    /**
     * @throws NotFoundException
     */
    public function deleteMonitor(int $id): void
    {
        $count = Monitor::query()
            ->where('id', $id)
            ->delete();

        if ($count == 0)
            throw new NotFoundException();
    }

}
