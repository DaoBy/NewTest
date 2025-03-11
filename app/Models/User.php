<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::deleting(function ($user) {
            if ($user->customer) {
                $user->customer->delete(); // Delete linked customer if it exists
            }
        });
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer' && $this->customer()->exists();
    }
}
