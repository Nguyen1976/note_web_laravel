<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['reminder_at', 'sent', 'user_id'];
    protected $casts = [
        'reminder_at' => 'datetime', // QUAN TRỌNG: Chuyển đổi reminder_at thành đối tượng Carbon
        'sent'        => 'boolean',  // Giả sử 'sent' được lưu dưới dạng số (0/1) và bạn muốn nó là boolean
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
