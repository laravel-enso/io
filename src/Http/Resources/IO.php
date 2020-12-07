<?php

namespace LaravelEnso\IO\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\Core\Http\Resources\User;
use LaravelEnso\Helpers\Services\Decimals;

class IO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'type' => $this->operationType(),
            'status' => $this->status(),
            'progress' => $this->progress(),
            'payload' => $this->broadcastWith(),
            'createdAt' => $this->createdAt(),
            'estimatedEnd' => $this->estimatedEnd(),
            'owner' => new User($this->whenLoaded('createdBy')),
        ];
    }

    private function estimatedEnd(): ?Carbon
    {
        if (! $this->progress()) {
            return null;
        }

        $elapsed = Carbon::now()->diffInSeconds($this->createdAt());
        $total = (int) Decimals::div(100 * $elapsed, $this->progress());

        return Carbon::now()->addSeconds($total - $elapsed);
    }
}
