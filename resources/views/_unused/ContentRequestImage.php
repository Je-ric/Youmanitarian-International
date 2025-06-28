<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentRequestImage extends Model
{
    use HasFactory;

    protected $fillable = ['request_id', 'image_url'];
    public $timestamps = true; 
    public function contentRequest()
    {
        return $this->belongsTo(ContentRequest::class, 'request_id');
    }
    

    
}
    