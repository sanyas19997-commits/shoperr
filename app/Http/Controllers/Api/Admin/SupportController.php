<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportTicketResource;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::query()->with(['user', 'latestMessage']);
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('email', 'like', "%{$search}%"));
            });
        }
        $tickets = $query->orderByDesc('last_message_at')->orderByDesc('id')->paginate(20);
        return SupportTicketResource::collection($tickets);
    }

    public function stats()
    {
        return response()->json([
            'total' => SupportTicket::count(),
            'open' => SupportTicket::where('status', SupportTicket::STATUS_OPEN)->count(),
            'pending' => SupportTicket::where('status', SupportTicket::STATUS_PENDING)->count(),
            'unread' => SupportTicket::where('admin_unread', '>', 0)->count(),
        ]);
    }

    public function show(Request $request, SupportTicket $ticket)
    {
        if ($ticket->admin_unread > 0) {
            $ticket->messages()
                ->where('is_admin', false)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            $ticket->admin_unread = 0;
            $ticket->save();
        }
        $ticket->load(['user', 'messages.author']);
        return new SupportTicketResource($ticket);
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        if ($ticket->status === SupportTicket::STATUS_CLOSED) {
            return response()->json(['message' => 'Тикет закрыт'], 422);
        }
        $data = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);
        DB::transaction(function () use ($request, $ticket, $data) {
            SupportMessage::create([
                'ticket_id' => $ticket->id,
                'author_id' => $request->user()->id,
                'is_admin' => true,
                'body' => $data['body'],
            ]);
            $ticket->update([
                'status' => SupportTicket::STATUS_ANSWERED,
                'last_message_at' => now(),
                'user_unread' => $ticket->user_unread + 1,
            ]);
        });

        $ticket->load(['user', 'messages.author']);
        return new SupportTicketResource($ticket);
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,answered,pending,closed'],
        ]);
        $ticket->update(['status' => $data['status']]);
        $ticket->load(['user', 'latestMessage']);
        return new SupportTicketResource($ticket);
    }

    public function destroy(SupportTicket $ticket): JsonResponse
    {
        $ticket->delete();
        return response()->json(['message' => 'Удалено']);
    }
}
