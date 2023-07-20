<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'prod_name',
        'prod_amount',
        'prod_quantity',
        'prod_description',
        'prod_picture'
    ];
}
