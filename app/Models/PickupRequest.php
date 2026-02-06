<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_post_id',
        'donor_user_id',
        'ngo_user_id',
        'status',
        'pickup_time_from',
        'pickup_time_to',
        'final_pickup_at',
        'contact_phone',
        'note',
        'approved_at',
        'rejected_at',
        'rejected_reason',
        'cancelled_at',
        'picked_up_at',
        'completed_at',
    ];

    protected $casts = [
        'pickup_time_from' => 'datetime',
        'pickup_time_to'   => 'datetime',
        'final_pickup_at'  => 'datetime',
        'approved_at'      => 'datetime',
        'rejected_at'      => 'datetime',
        'cancelled_at'     => 'datetime',
        'picked_up_at'     => 'datetime',
        'completed_at'     => 'datetime',
    ];

    public function foodPost()
    {
        return $this->belongsTo(FoodPost::class, 'food_post_id');
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_user_id');
    }

    public function ngo()
    {
        return $this->belongsTo(User::class, 'ngo_user_id');
    }
}
