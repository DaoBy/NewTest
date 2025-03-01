<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_request_id',
        'description',
        'height',
        'width',
        'length',
        'weight',
        'quantity',
        'volume',
    ];

    public function deliveryRequest()
    {
        return $this->belongsTo(DeliveryRequest::class);
    }
}
