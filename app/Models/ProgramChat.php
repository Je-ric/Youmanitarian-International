<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramChat extends Model
{
    protected $fillable = ['program_id', 'user_id', 'message'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Assuming user is chatting
    }
}
