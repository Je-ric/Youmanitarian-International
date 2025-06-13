<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramChat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'program_id',
        'sender_id',
        'parent_id',
        'message',
        'message_type',
        'is_pinned',
        'is_edited',
        'edited_at'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
        'sent_at' => 'datetime'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function parent()
    {
        return $this->belongsTo(ProgramChat::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ProgramChat::class, 'parent_id');
    }

    public function readBy()
    {
        return $this->belongsToMany(User::class, 'program_chat_reads', 'chat_id', 'user_id')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
