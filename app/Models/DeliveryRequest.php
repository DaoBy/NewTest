<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_type',
        'drop_off_branch',
        'pick_up_branch',
        'status',
    ];

    public function senderAddress()
    {
        return $this->hasOne(DeliveryAddress::class)->where('type', 'sender');
    }

    public function receiverAddress()
    {
        return $this->hasOne(DeliveryAddress::class)->where('type', 'receiver');
    }

    public function package()
    {
        return $this->hasOne(DeliveryPackage::class);
    }
}
