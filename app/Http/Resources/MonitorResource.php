<?php

namespace App\Http\Resources;

use App\Models\Monitor;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Monitor $monitor */
        $monitor = $this->resource;
        return [
            'id' => $monitor->id,
            'name'=>$monitor->name,
            'status' => $monitor->status,
            'created_at' => $monitor->created_at->toIso8601ZuluString(),
            'updated_at' => $monitor->updated_at->toIso8601ZuluString(),
        ];
    }
}
