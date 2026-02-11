<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketAttachmentController extends Controller
{

    public function index(Ticket $ticket)
    {
        $user = Auth::user();

        if ($user->role === 'admin' ||
            $user->role === 'support' ||
            $ticket->user_id === $user->id) {

            return response()->json($ticket->attachments);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }


    public function store(Request $request, Ticket $ticket)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' &&
            $user->role !== 'support' &&
            $ticket->user_id !== $user->id) {

            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'file' => 'required|file|max:2048', // حداکثر 2MB
        ]);

        $path = $request->file('file')->store('tickets', 'public');

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'file_path' => $path,
        ]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'attachment' => $attachment,
            'url' => asset('storage/' . $path),
        ], 201);
    }


    public function destroy(TicketAttachment $attachment)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin','support'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return response()->json([
            'message' => 'Attachment deleted successfully'
        ]);
    }
}
