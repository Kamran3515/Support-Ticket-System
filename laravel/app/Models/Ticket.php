<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
    ];

    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function support():belongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments():hasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments():hasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }
}
