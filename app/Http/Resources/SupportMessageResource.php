<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'author_id' => $this->author_id,
            'author_name' => $this->whenLoaded('author', fn () => $this->author?->name),
            'is_admin' => (bool) $this->is_admin,
            'body' => $this->body,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
        ];
    }
}
