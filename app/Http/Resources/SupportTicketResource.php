<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->whenLoaded('user', fn () => $this->user?->name),
            'user_email' => $this->whenLoaded('user', fn () => $this->user?->email),
            'subject' => $this->subject,
            'status' => $this->status,
            'last_message_at' => $this->last_message_at,
            // Each side sees only its own unread count.
            'unread' => $isAdmin ? (int) $this->admin_unread : (int) $this->user_unread,
            'last_message' => $this->whenLoaded('latestMessage', function () {
                // `latestMessage` is a HasOne (via ->latestOfMany()), so the
                // loaded attribute is either a single model or null.
                $m = $this->latestMessage;
                return $m ? [
                    'is_admin' => (bool) $m->is_admin,
                    'body' => \Illuminate\Support\Str::limit($m->body, 140),
                    'created_at' => $m->created_at,
                ] : null;
            }),
            'messages' => SupportMessageResource::collection($this->whenLoaded('messages')),
            'created_at' => $this->created_at,
        ];
    }
}
