<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawn extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function status(){
        $this->belongsTo(statusWithdrawn::class,'status_id');
    }
}
