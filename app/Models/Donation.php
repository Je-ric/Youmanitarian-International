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
        'status'
    ];

    protected $casts = [
        'donation_date' => 'datetime',
        'amount' => 'decimal:2'
    ];
}
