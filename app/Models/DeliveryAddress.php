<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_request_id',
        'type',
        'first_name',
        'last_name',
        'company_name',
        'mobile',
        'street',
        'city',
        'province',
        'zip',
    ];

    public function deliveryRequest()
    {
        return $this->belongsTo(DeliveryRequest::class);
    }
}
