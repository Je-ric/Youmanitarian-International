<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ContentRequest extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'requested_by', 'status', 'notes', 'created_at'];

    public function images()
    {
        return $this->hasMany(ContentRequestImage::class, 'request_id');
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'requested_by');
    }
    public function content()
{
    return $this->hasOne(Content::class);
}
}
