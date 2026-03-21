<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    // Ini daftar kolom yang wajib diisi saat transaksi terjadi
    protected $fillable = ['transaction_id', 'product_id', 'quantity', 'price'];
}