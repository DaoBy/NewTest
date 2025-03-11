<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Added for better association
        'sender_id',
        'receiver_id',
        'sender_type',
        'sender_name',
        'sender_company_name',
        'sender_mobile',
        'sender_email',
        'sender_street',
        'sender_city',
        'sender_province',
        'sender_zip',
        'drop_off_branch',
        'receiver_type',
        'receiver_name',
        'receiver_company_name',
        'receiver_mobile',
        'receiver_email',
        'receiver_street',
        'receiver_city',
        'receiver_province',
        'receiver_zip',
        'pick_up_branch',
        'packages', // Stores package details as a JSON string
        'payment_method',
        'total_price',
        'status', // Pending, approved, rejected
    ];

    protected $casts = [
        'packages' => 'array', // Automatically cast the JSON to an array
    ];

    // Relationships
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
