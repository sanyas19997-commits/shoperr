<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportMessageResource;
use App\Http\Resources\SupportTicketResource;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Customer-facing support endpoints. Users can only see their own tickets.
 */
class SupportController extends Controller
{
    public function index(Request $request)
    {
        $tickets = SupportTicket::where('user_id', $request->user()->id)
            ->with(['latestMessage'])
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->paginate(20);
        return SupportTicketResource::collection($tickets);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $ticket = DB::transaction(function () use ($request, $data) {
            $ticket = SupportTicket::create([
                'user_id' => $request->user()->id,
                'subject' => $data['subject'],
                'status' => SupportTicket::STATUS_OPEN,
                'last_message_at' => now(),
                'admin_unread' => 1,
                'user_unread' => 0,
            ]);
            SupportMessage::create([
                'ticket_id' => $ticket->id,
                'author_id' => $request->user()->id,
                'is_admin' => false,
                'body' => $data['body'],
            ]);
            return $ticket;
        });

        $ticket->load(['latestMessage']);
        return (new SupportTicketResource($ticket))->response()->setStatusCode(201);
    }

    public function show(Request $request, SupportTicket $ticket)
    {
        $this->authorizeOwnership($request, $ticket);
        // Mark admin -> user messages as read when the user opens the thread.
        if ($ticket->user_unread > 0) {
            $ticket->messages()
                ->where('is_admin', true)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            $ticket->user_unread = 0;
            $ticket->save();
        }
        $ticket->load(['messages.author']);
        return new SupportTicketResource($ticket);
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $this->authorizeOwnership($request, $ticket);
        if ($ticket->status === SupportTicket::STATUS_CLOSED) {
            return response()->json(['message' => 'Тикет закрыт. Создайте новый, чтобы продолжить.'], 422);
        }
        $data = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);
        DB::transaction(function () use ($request, $ticket, $data) {
            SupportMessage::create([
                'ticket_id' => $ticket->id,
                'author_id' => $request->user()->id,
                'is_admin' => false,
                'body' => $data['body'],
            ]);
            // Atomic increment — `admin_unread` may be concurrently touched by
            // another user message or an admin `show()` that resets the counter.
            // Reading the current model value would lose increments under load.
            $ticket->update([
                'status' => SupportTicket::STATUS_PENDING,
                'last_message_at' => now(),
                'admin_unread' => DB::raw('admin_unread + 1'),
            ]);
        });

        $ticket->refresh()->load(['messages.author']);
        return new SupportTicketResource($ticket);
    }

    public function close(Request $request, SupportTicket $ticket): JsonResponse
    {
        $this->authorizeOwnership($request, $ticket);
        $ticket->update(['status' => SupportTicket::STATUS_CLOSED]);
        return response()->json(['message' => 'Тикет закрыт']);
    }

    protected function authorizeOwnership(Request $request, SupportTicket $ticket): void
    {
        if ((int) $ticket->user_id !== (int) $request->user()->id) {
            abort(403, 'Forbidden');
        }
    }
}
