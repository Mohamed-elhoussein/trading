<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tradingstock extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('Y-m-d'); // يمكنك تعديل التنسيق كما ترغب
    }
}
