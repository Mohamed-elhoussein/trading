<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrade extends Model
{
    use HasFactory;
    protected $guarded=['id'];



    protected $casts = [
        'details' => 'array',  // يعامل العمود كـ array أو JSON
    ];
}
