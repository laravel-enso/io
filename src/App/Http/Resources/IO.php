<?php

namespace LaravelEnso\IO\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\TrackWho\App\Http\Resources\TrackWho;

class IO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'entries' => $this->entries(),
            'name' => $this->name(),
            'type' => $this->type(),
            'since' => $this->created_at,
            'status' => $this->status(),
            'owner' => new TrackWho($this->createdBy),
        ];
    }
}
