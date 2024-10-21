<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function account(){
        return $this->belongsTo(Account::class,'account_id');
    }
    public function tran_message(){
        return $this->belongsTo(TransactionsMessagas::class,'transactions_messagas_id');
    }

    public function tran_status(){
        return $this->belongsTo(TransactionStatus::class,'transactions_status_id');
    }

}
