<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldsCountry extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function country(){
        return $this->belongsTo(Countries::class,'country_id');
    }
    public function fields(){
        return $this->belongsTo(Fields::class,'field_id');
    }
    public function customer_var(){
        return $this->hasMany(CustomerVerifications::class,'field_country_id');
    }
}
