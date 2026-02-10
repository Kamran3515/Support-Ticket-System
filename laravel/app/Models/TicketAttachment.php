<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'file_path',
    ];

    public function ticket():belongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}

