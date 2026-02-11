<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Ticket::class);

        $tickets = Ticket::with(['user','support','comments','attachments'])->get();

        return TicketResource::collection($tickets);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => ['sometimes', Rule::in(['low','medium','high'])],
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'] ?? 'medium',
        ]);

        return new TicketResource($ticket);
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['user','support','comments','attachments']);

        return new TicketResource($ticket);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'status' => ['sometimes', Rule::in(['open','pending','answered','closed'])],
            'priority' => ['sometimes', Rule::in(['low','medium','high'])],
            'assigned_to' => ['sometimes','nullable','exists:users,id'],
        ]);

        $ticket->update($validated);

        return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return response()->json([
            'message' => 'Ticket deleted successfully'
        ]);
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $this->authorize('assign', $ticket);

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $ticket->update([
            'assigned_to' => $validated['assigned_to']
        ]);

        return response()->json([
            'message' => 'Ticket assigned successfully',
            'ticket' => $ticket
        ]);
    }
}
