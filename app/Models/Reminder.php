<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['note_id', 'reminder_at', 'sent'];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
