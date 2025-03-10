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
        'phone_number',
        'address',
        'birth_date',
        'gender',
        'company_name',
        'national_id',
        'customer_type',
        'preferences',
    ];

    protected $casts = [
        'preferences' => 'array', // For storing JSON data
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
