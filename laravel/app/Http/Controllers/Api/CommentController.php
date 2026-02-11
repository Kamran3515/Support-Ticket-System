<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // لیست کامنت‌های یک تیکت
    public function index(Ticket $ticket)
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'support' || $ticket->user_id === $user->id) {
            $comments = $ticket->comments()->with('user')->get();
            return response()->json($comments);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // افزودن کامنت به تیکت
    public function store(Request $request, Ticket $ticket)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->role !== 'support' && $ticket->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $comment = Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment,
        ], 201);
    }
}
