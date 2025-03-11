<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'email',
        'street',
        'city',
        'province',
        'zip_code',
        'company_name',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRegistered($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeWalkIns($query)
    {
        return $query->whereNull('user_id')->where('is_system', true);
    }
}
