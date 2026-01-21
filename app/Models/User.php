<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'organization_name',
        'organization_type',
        'district',
        'city',
        'road_no',
        'house_no',
        'address',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Donor → Food Posts
    public function foodPosts()
    {
        return $this->hasMany(FoodPost::class, 'user_id');
    }

    // Donor → Pickup Requests
    public function pickupRequests()
    {
        return $this->hasMany(PickupRequest::class, 'donor_id');
    }

    public function isDonor()
    {
        return $this->role === 'donor';
    }

    public function isNgo()
    {
        return $this->role === 'organization';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
