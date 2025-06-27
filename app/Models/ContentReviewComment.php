<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentReviewComment extends Model
{
    protected $fillable = [
        'content_id', 'user_id', 'comment', 'role', 'parent_id'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(ContentReviewComment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ContentReviewComment::class, 'parent_id');
    }
}