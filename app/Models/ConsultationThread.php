<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationThread extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'status',
    ];

    public function userOne() { return $this->belongsTo(User::class, 'user_one_id'); }
    public function userTwo() { return $this->belongsTo(User::class, 'user_two_id'); }

    public function chats()
    {
        return $this->hasMany(ConsultationChat::class, 'thread_id');
    }

    public function latestChat()
    {
        return $this->hasOne(ConsultationChat::class, 'thread_id')->latestOfMany('sent_at');
    }

    public function scopeBetweenUsers($q, int $a, int $b)
    {
        return $q->where(function($qq) use ($a,$b){
            $qq->where('user_one_id',$a)->where('user_two_id',$b);
        })->orWhere(function($qq) use ($a,$b){
            $qq->where('user_one_id',$b)->where('user_two_id',$a);
        });
    }

    public function scopeForUser($q, int $userId)
    {
        return $q->where(function($qq) use ($userId){
            $qq->where('user_one_id',$userId)->orWhere('user_two_id',$userId);
        });
    }

    public static function between($a, $b)
    {
        $one = min($a, $b);
        $two = max($a, $b);
        return self::where('user_one_id', $one)->where('user_two_id', $two)->first();
    }
}

