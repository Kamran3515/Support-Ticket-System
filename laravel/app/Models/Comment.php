<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
    ];

    public function ticket():belongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }
}

