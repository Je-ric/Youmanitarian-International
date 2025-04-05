<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $fillable = ['user_id', 'role_id', 'assigned_by'];

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}

