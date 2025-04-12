<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    /** @use HasFactory<\Database\Factories\RegionFactory> */
    use HasFactory;

    protected $fillable = ['name', 'status'];
    
    public function regionDelivery(): HasMany
    {
        return $this->hasMany(RegionDelivery::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'region_deliveries', 'region_id', 'user_id');
}
}
