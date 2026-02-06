<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPost extends Model
{
    use HasFactory;

    protected $table = 'food_posts';

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'quantity',
        'unit',
        'cooked_at',
        'expiry_time',
        'pickup_time_from',
        'pickup_time_to',
        'pickup_address',
        'description',
        'image_path',
        'ai_summary',
        'status',
    ];

    protected $casts = [
        'cooked_at'        => 'datetime',
        'expiry_time'      => 'datetime',
        'pickup_time_from' => 'datetime',
        'pickup_time_to'   => 'datetime',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Multiple NGOs can request pickup for same food post
    public function pickupRequests()
    {
        return $this->hasMany(PickupRequest::class, 'food_post_id');
    }

    // ✅ Only the approved one (if needed)
    public function approvedPickupRequest()
    {
        return $this->hasOne(PickupRequest::class, 'food_post_id')
            ->where('status', 'approved');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}

