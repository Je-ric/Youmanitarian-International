<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentImage extends Model
{
    //
    protected $fillable = ['content_id', 'image_path'];

    public $timestamps = false; //prevent Laravel inserting updated_at
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    protected $casts = [
        'uploaded_at' => 'datetime', // Ensure uploaded_at is treated as a date
    ];

}
