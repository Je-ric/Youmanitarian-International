<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model {
    use HasFactory;
    protected $table = 'content';

    protected $fillable = [
        'title', 'type', 'body', 'status', 'image_content', 'created_by', 'request_id'
    ];
    
    // relationship with ContentRequest
public function contentRequest()
{
    return $this->belongsTo(ContentRequest::class, 'request_id');
}
    public function user(): BelongsTo {
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

public function comments() {
    return $this->hasMany(ContentComment::class, 'content_id')->latest();
}

}
