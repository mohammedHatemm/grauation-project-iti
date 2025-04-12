<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'company_name', 'address', 'gender', 'phone'
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    
    public function regionDelivery()
{
    return $this->hasOne(RegionDelivery::class, 'user_id');
}

    
    public function orderDelivery(): HasMany
    {
        return $this->hasMany(OrderDelivery::class);
    }

    public function region()
{
    return $this->belongsToMany(Region::class, 'region_deliveries', 'user_id', 'region_id');
}



}
