<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldsType extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function fields()
    {
        return $this->hasMany(fields::class,'fields_type');
    }

}
