<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_email',
        'amount',
        'donation_date',
        'payment_method',
        'receipt_url',
        'status',
        'recorded_by',
        'confirmed_at',
        'is_anonymous',
        'notes'
    ];

    protected $casts = [
        'donation_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean'
    ];

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
