<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', // แก้ไขจาก user_id เป็น member_id
        'product_id',
        'name',
        'price',
        'color',
        'size',
        'quantity',
    ];
}

