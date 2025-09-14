<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
        'target_audience',
        'location',
        'proposed_date',
    ];
}
