<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContentImage extends Model
{
    protected $table = 'content_images';
    protected $fillable = ['content_id', 'image_path', 'uploaded_at'];

    const CREATED_AT = 'uploaded_at';
    const UPDATED_AT = null;

    protected $appends = ['url']; //accessor

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function getUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }
}
