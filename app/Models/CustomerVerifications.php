<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVerifications extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function fields_country(){
        return $this->belongsTo(FieldsCountry::class,'field_country_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
