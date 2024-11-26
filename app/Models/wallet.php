<?php

namespace App\Models;


use App\Models\Currancy;
use App\Models\Customer;
use App\Models\walletHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class wallet extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function history()
    {
        return $this->hasMany(walletHistory::class);
    }

    public function currancy()
    {
        return $this->belongsTo(Currancy::class,'curranc_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public static function WalletAccount($current_price , $profit ,$customer_id)
    {

            $customer_id = Auth::user()->id ?? $customer_id;
            // جلب رصيد المحفظة الحالي
            $wallet = wallet::where('customer_id', $customer_id)->first();

            if ($wallet) {
                // خصم الربح السالب من رصيد المحفظة
                $newBalance = $wallet->current_amount + $current_price; // بما أن `profit` سالب، سيتم خصم المبلغ

                // تحديث رصيد المحفظة
                $wallet->update([
                    'current_amount' => $newBalance
                ]);

                // إضافة سجل في `wallet_history` لتوثيق التخصم
                walletHistory::create([
                    'wallet_id' => $wallet->id,
                    'action' => 'The amount due from the trading transaction',
                    'amount' => $profit,  // خصم المبلغ (تحويله إلى قيمة إيجابية)
                ]);
            } else {
                return Toastr::error("Wallet not found.");
            }
        }


        public static function CheckAmountFound($request)
        {
            $customer_id = $request->customer_id??1;
            $dataUser = wallet::where("customer_id", $customer_id)->first();

            // التحقق من وجود المستخدم والمحفظة
            if (!$dataUser) {
             return Toastr::error("you do not have any amount");
            }

            return $dataUser;
        }
    }

