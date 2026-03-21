<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'total_price',
        'paid_amount',
        'change_amount',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
    ];
}