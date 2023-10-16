<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable=[
        'user_id',
        'subject',
        'reply_to',
        'body',
        'mailer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
