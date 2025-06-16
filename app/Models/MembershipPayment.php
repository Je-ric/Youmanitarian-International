<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'amount',
        'payment_date',
        'payment_status',
        'receipt_url',
        'payment_period',
        'payment_year'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
        'payment_year' => 'integer'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
