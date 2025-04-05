<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentComment extends Model {
    use HasFactory;

    protected $fillable = ['content_id', 'user_id', 'comment'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function content() {
        return $this->belongsTo(Content::class);
    }
}
