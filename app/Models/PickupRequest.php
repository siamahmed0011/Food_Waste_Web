<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    protected $fillable = [
        'ngo_id',
        'donor_id',
        'food_post_id',
        'food_title',
        'pickup_time',
        'status',
        'note',
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
    ];

    // OLD: NGO from ngo table (optional)
    public function ngo()
    {
        return $this->belongsTo(Ngo::class, 'ngo_id');
    }

    // NEW: NGO user account (recommended for dashboard)
    public function ngoUser()
    {
        return $this->belongsTo(User::class, 'ngo_id');
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function foodPost()
    {
        return $this->belongsTo(FoodPost::class, 'food_post_id');
    }
}
