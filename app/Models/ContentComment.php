<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentComment extends Model {
    use HasFactory;

    protected $fillable = ['content_id', 'user_id', 'comment', 'parent_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function content() {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function parent()
    {
        return $this->belongsTo(ContentComment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ContentComment::class, 'parent_id');
    }
}
