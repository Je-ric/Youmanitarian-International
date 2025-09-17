<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    use HasFactory;
    protected $table = 'contents';

    protected $fillable = [
        'title',
        'body',
        'image_content',
        'created_by',
        'content_status',
        'content_type',
        'approval_status',
        'approved_by',
        'approved_at',
        'slug',
        'views',
        'enable_likes',
        'enable_comments',
        'enable_bookmark',
        'published_at',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_content ? Storage::url($this->image_content) : null;
    }

    public function contentRequest()
    {
        return $this->belongsTo(ContentRequest::class, 'request_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images()
    {
        return $this->hasMany(ContentImage::class, 'content_id');
    }

    public function heartReacts()
    {
        return $this->hasMany(HeartReact::class, 'content_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(HeartReact::class, 'content_id');
    }


    public function comments()
    {
        return $this->hasMany(ContentComment::class, 'content_id')->latest();
    }

    public function reviewComments()
    {
        return $this->hasMany(ContentReviewComment::class, 'content_id');
    }
}
