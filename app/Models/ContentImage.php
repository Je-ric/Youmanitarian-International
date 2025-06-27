<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentImage extends Model
{
    //
    protected $fillable = ['content_id', 'image_path', 'uploaded_at'];

    public $timestamps = false; 
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    protected $casts = [
        'uploaded_at' => 'datetime', 
    ];

}
