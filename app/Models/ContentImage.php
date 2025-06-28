<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentImage extends Model
{
    protected $table = 'content_images';
    protected $fillable = ['content_id', 'image_path', 'uploaded_at'];

    const CREATED_AT = 'uploaded_at';
    const UPDATED_AT = null;
    
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
