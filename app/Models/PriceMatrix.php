<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceMatrix extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'base_fee',
        'volume_rate',
        'weight_rate',
        'package_rate',
    ];
    protected $table = 'price_matrix'; // Explicitly set the table name

}
