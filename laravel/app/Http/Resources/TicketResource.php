<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,

            'created_at' => $this->created_at->toDateTimeString(),

            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],

            'assigned_to' => $this->when(
                $this->support,
                [
                    'id' => optional($this->support)->id,
                    'name' => optional($this->support)->name,
                ]
            ),

            'comments_count' => $this->comments->count(),

            'attachments_count' => $this->attachments->count(),
        ];
    }
}
