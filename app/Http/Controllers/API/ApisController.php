<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Banks;
use App\Models\Order;
use App\Utils\helper;
use App\Models\Result;
use App\Models\Program;
use App\Models\InterestCalc;
use Illuminate\Http\Request;
use App\Http\Traits\HelperApi;
use App\Models\Program_period;
use App\Services\ExamServices;
use App\Models\ContractProgram;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BankAccounts;
use App\Models\Currancy;
use App\Models\Customer;
use App\Models\CustomerVerifications;
use App\Models\FieldsCountry;
use App\Models\Notifications;
use App\Models\orderContract;
use App\Models\orderInstallment;
use App\Models\orderStatus;
use App\Models\PaymentRequest;
use App\Models\Payments;
use App\Models\PeroidGlobel;
use App\Models\ProgramTypes;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Withdrawn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDO;

class ApisController extends Controller
{
    use HelperApi;


    // public function contract($id)
    // {
    //     $data = ContractProgram::find($id);
    //     if ($data) {
    //         $transformedData = helper::transformDataByLanguage($data->toArray());
    //         return $this->onSuccess(200, 'found', $transformedData);
    //     } else {
    //         return $this->onSuccess(200, 'Not Found',$data);
    //     }
    // }

    //// account
    public function create_account(Request $request)
    {
        $rules = [
            'currancy_id' => ['required', 'exists:currancies,id'],
        ];

        $customMessages = [

            'currancy_id.required' => __('validation.custom.currancy.required'),
            'currancy_id.exists' => __('validation.custom.currancy.exists'),
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            // Collect all error messages
            $errorMessages = $validator->errors()->all();

            // Combine all messages into a single string
            $combinedErrorMessage = implode(' ', $errorMessages);

            return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
        }

        Account::create([
            'customer_id' => helper::customer_id(),
            'currancy_id' => $request->currancy_id,
            'balance' => 0,
            'type' => 0

        ]);
        return $this->onSuccess(200, 'success_create_account');
    }
    public function get_all_accounts(){
        try {
            $user_id = helper::customer_id();

            $accounts=Account::where('customer_id',$user_id)->with('currancy')->get();

            return $this->onSuccess(200, 'found', $accounts);

        } catch (\Throwable $th) {
            return $this->onError(500, __('messages.general.some_error'));

        }

    }

    public function save_payment_request(Request $request)
    {

        $rules = [
            'payment_id' => ['required', 'exists:payments,id'],
            'value' => ['required', 'numeric', 'min:1'],
        ];
        $paymentType = $this->get_type_payment($request->payment_id);
        if ($paymentType === 'not found') {
            return $this->onError(422, 'not found payment');
        }

        $customMessages = [
            'payment_id.required' => __('validation.custom.payment.required'),
            'payment_id.exists' => __('validation.custom.payment.exists'),
            'value.required' => __('validation.custom.payment.required'),
            'value.numeric' => __('validation.custom.payment.numeric'),
            'value.min' => __('validation.custom.payment.min'),
        ];

        if ($paymentType->type == 1) {
            $rules['details_offline'] = ['required'];
            $customMessages = array_merge($customMessages, [
                'details_offline.required' => __('validation.custom.details_offline.required'),
            ]);
        } else {
            /////////////payment online

        }
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            // Collect all error messages
            $errorMessages = $validator->errors()->all();

            // Combine all messages into a single string
            $combinedErrorMessage = implode(' ', $errorMessages);
            return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
        }
        $account = helper::get_account($request->header('Accept-account'));
        if ($account == false) {
            return $this->onError(422, 'not found account');
        }
        DB::beginTransaction();
        try {
            PaymentRequest::create([
                'account_id' => $account->id,
                'value' => $request->value,
                'payment_id' => $request->payment_id,
                'details_offline' => json_encode($request->details_offline),
                'feas' => $paymentType->feas
            ]);
            Transactions::create([
                'account_id' => $account->id,
                'value' => $request->value,
                'transactions_status_id' => 3
            ]);



            DB::commit();
            return $this->onSuccess(200, __('messages.general.success_payment_request'), true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->onError(500, __('messages.general.some_error'));
        }

        return $this->onSuccess(200, 'success_payment_request');
    }
    private function get_type_payment($payment_id)
    {
        $payment = Payments::find($payment_id);
        return $payment ? $payment : 'not found';
    }
    public function payments(){
        $payments=Payments::all();
        return $this->onSuccess(200, 'found', $payments);
    }

    public function withdrawn(Request $request)
    {

        $rules = [
            'account_bank_id' => ['required', 'exists:bank_accounts,id'],
            'value' => ['required', 'numeric', 'min:1'],

        ];
        $customMessages = [
            'account_bank_id.required' => __('validation.custom.account_bank_id.required'),
            'account_bank_id.exists' => __('validation.custom.account_bank_id.exists'),
            'value.required' => __('validation.custom.value.required'),
            'value.numeric' => __('validation.custom.value.numeric'),
            'value.min' => __('validation.custom.value.min'),
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            // Collect all error messages
            $errorMessages = $validator->errors()->all();

            // Combine all messages into a single string
            $combinedErrorMessage = implode(' ', $errorMessages);
            return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
        }
        $account = helper::get_account($request->header('Accept-account'));
        $account_bank = BankAccounts::where('id', $request->account_bank_id)->where('customer_id', helper::customer_id())->first();

        if ($account == false) {
            return $this->onError(422, 'not found account');
        }
        if (!$account_bank) {
            return $this->onError(422, 'not found account_bank');
        }
        $bank = Banks::where('id', $account_bank->bank_id)->first();
        DB::beginTransaction();
        try {

            $total_feas = 0;
            $total = 0;
            if ($bank->persage == 0) {
                $total_feas = $bank->feas;
                $total = $total_feas + $request->value;
            } else {
                $total_feas = ($request->value * $bank->feas) / 100;
                $total = $total_feas + $request->value;
            }
            if ($account->balance < $total) {
                return $this->onError(422, 'not found balance');
            }

            Withdrawn::create([
                'account_id' => $account->id,
                'value' => $request->value,
                'feas' => $total_feas,
                'account_bank_id' => $request->account_bank_id,
                'status_id' => 1,
            ]);
            $account->balance = $account->balance - $total;
            $account->update();
            Transactions::create([
                'account_id' => $account->id,
                'value' => $request->value,
                'transactions_status_id' => 4
            ]);



            DB::commit();
            return $this->onSuccess(200, __('messages.general.success_withdrawnrequest'), true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->onError(500, __('messages.general.some_error'));
        }
    }



    public function getUser()
    {
        $user = auth('api')->user();
        if ($user) {
            return $this->onSuccess(200, 'found', $user);
        } else {
            return $this->onError(500, 'notfound', $user);
        }
    }

    public function upload_file(Request $request)
    {
        // Base rules for all inputs
        $rules = [
            'name' => ['required', 'string'],
            'image' => ['required'], // Validate image and size limit to 1MB

        ];

        $customMessages = [
            'name.required' => __('validation.custom.name.required'),
            'image.required' => __('validation.custom.image.required'),
        ];

        // Perform validation
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            // Collect all error messages
            $errorMessages = $validator->errors()->all();

            // Combine all messages into a single string
            $combinedErrorMessage = implode(' ', $errorMessages);

            return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $directory = $request->name; // Change this to your desired directory name
            $request->image->move(public_path($directory), $imageName);
            $imagePath = $directory . '/' . $imageName;
            return $this->onSuccess(200, 'uploaded', $imagePath);
        } else {
            return $this->onSuccess(500, __('validation.custom.not_avalable'));
        }
    }
    ////get currancies
    public function currancies()
    {
        $currancies = Currancy::get();
        return $this->onSuccess(200, 'found', $currancies);
    }
    public function bank_accounts_store(Request $request)
    {
        try {


            $rules = [
                'bank_id' => ['required', 'exists:banks,id'],
                'account_num' => ['required', 'string'],
                'account_name' => ['required', 'string']
            ];

            $customMessages = [
                'bank_id.required' => __('validation.custom.bank_id.required'),
                'bank_id.exists' => __('validation.custom.bank_id.exists'),
                'account_num.required' => __('validation.custom.account_num.required'),
                'account_num.string' => __('validation.custom.account_num.string'),
                'account_name.required' => __('validation.custom.account_name.required'),
                'account_name.string' => __('validation.custom.account_name.string'),
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                // Collect all error messages
                $errorMessages = $validator->errors()->all();

                // Combine all messages into a single string
                $combinedErrorMessage = implode(' ', $errorMessages);
                return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
            }
            BankAccounts::create([
                'customer_id' => helper::customer_id(),
                'bank_id' => $request->bank_id,
                'account_num' => $request->account_num,
                'account_name' => $request->account_name
            ]);
            return $this->onSuccess(200, __('messages.general.success_store_bank_account'), true);
        } catch (\Throwable $th) {

            return $this->onError(500, __('messages.general.some_error'));
        }
    }
    public function bank_accounts_get()
    {
        $user_id = helper::customer_id();
        $bank_accounts = BankAccounts::where('customer_id', $user_id)->with('bank')->get();
        $transformedData = helper::transformDataByLanguage($bank_accounts->toArray());
        return $this->onSuccess(200, 'found', $transformedData);
    }
    public function trasactions(Request $request)
    {
        $account = helper::get_account($request->header('Accept-account'));
        $trasactions = Transactions::where('account_id', $account->id)->with('tran_status')->get();
        $transformedData = helper::transformDataByLanguage($trasactions->toArray());
        return $this->onSuccess(200, 'found', $transformedData);
    }
    public function get_verifications_country()
    {
        $user_id = helper::customer_id();
        $country = Customer::where('id', '=', $user_id)->select('id', 'country_id')->first();
        $fields = FieldsCountry::where('country_id', $country->country_id)
        ->with(['fields.type', 'customer_var' => function($query) use ($user_id) {
            $query->where('customer_id', 1);
        }])
        ->get();
        $transformedData = helper::transformDataByLanguage($fields->toArray());
        return $this->onSuccess(200, 'found', $transformedData);
    }
    public function store_verifications_customer(Request $request)
    {

        try {
            $user_id = helper::customer_id();

            $rules = [
                'field_country_id' => ['required', 'exists:fields_countries,id'],
                'value' => ['required', 'string'],
            ];

            $customMessages = [
                'field_country_id.required' => __('validation.custom.field_country_id.required'),
                'field_country_id.exists' => __('validation.custom.field_country_id.exists'),
                'value.required' => __('validation.custom.value.required'),
                'value.string' => __('validation.custom.value.string'),

            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                // Collect all error messages
                $errorMessages = $validator->errors()->all();

                // Combine all messages into a single string
                $combinedErrorMessage = implode(' ', $errorMessages);
                return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
            }


            CustomerVerifications::updateOrCreate(
                [
                    'field_country_id' => $request->field_country_id,
                    'customer_id' => $user_id
                ],
                [
                    'value' => $request->value,
                    'is_vervication' => 0
                ]
            );

            return $this->onSuccess(200, __('messages.general.store_verifications_customer'), true);
        } catch (\Throwable $th) {

            return $this->onError(500, __('messages.general.some_error'));
        }
    }
}
