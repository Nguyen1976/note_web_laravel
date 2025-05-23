<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['reminder_at', 'sent'];

    public function note()
    {
        return $this->hasMany(Note::class);
    }
}
