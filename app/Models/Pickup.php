<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'food_type',
        'quantity',
        'unit',
        'prepared_at',
        'best_before',
        'pickup_time',
        'pickup_address',
        'contact_phone',
        'notes',
        'status',
    ];

    protected $casts = [
        'prepared_at'  => 'datetime',
        'best_before'  => 'datetime',
        'pickup_time'  => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
}
