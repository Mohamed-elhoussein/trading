<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\OTP;
use App\Utils\helper;
use App\Models\ageRange;
use App\Models\Customer;
use App\Models\otp_register;
use Illuminate\Http\Request;
use App\Http\Traits\HelperApi;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Traits\ImageProcessing;
use App\Models\Account;
use App\Models\Banks;
use App\Models\Countries;
use App\Models\Currancy;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class AuthController extends Controller
{
    use HelperApi, ImageProcessing;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'changepass', 'verifyOtp_for_change_pass', 'forgetpassword', 'get_age_range','verifyOtpForRegister','countries','banks']]); //login, register methods won't go through the api guard
    }

    public function login(Request $request)
    {
             // Determine if the input is an email or phone and adjust rules accordingly

             $rules = [
                'password' => ['required'],
                'email' => [
                    'required'
                    , 'email', 'max:255', 'exists:customers,email'



                ],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                // Collect all error messages
                $errorMessages = $validator->errors()->all();

                // Combine all messages into a single string
                $combinedErrorMessage = implode(' ', $errorMessages);

                return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
            }

        try {

            $user = Customer::where('email', $request->email)->first();

            if ($user && (!Hash::check($request->password, $user->password))) {
                return $this->onError(401, __('messages.general.invalid_data'));
            }


            if (!$user) {
                return $this->onError(401, __('messages.general.invalid_data'));
            }

            $token = JWTAuth::fromUser($user);

            if (!$token) {

                return $this->onError(401, __('messages.general.unauthorized'));
            }
            return $this->onSuccessWithToken(200, __('messages.general.login'), $user, $token);
        } catch (\Throwable $error) {
            return $this->onError(500, __('messages.general.server_error'), $error->getMessage());
        }
    }


    public function register(Request $request)
    {
        try {

            // Base rules for all inputs
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
                'phone' => [
                    'required',
                    'numeric',
                    'unique:customers,phone'
                ],
                'password' => ['required', 'string', 'min:6'],
                'avtar' => ['nullable','string','max:300'], // Updated to validate image and size limit to 1MB
                 'birthday' => ['nullable', 'date'],
                 'country_id'=>['required','exists:countries,id'],
            ];

            $customMessages = [
                'name.required' => __('validation.custom.name.required'),
                'name.string' => __('validation.custom.name.string'),
                'name.max' => __('validation.custom.name.max'),

                'email.nullable' => __('validation.custom.email.required'),
                'email.email' => __('validation.custom.email.email'),
                'email.max' => __('validation.custom.email.max'),
                'email.unique' => __('validation.custom.email.unique'),
                'phone.required' => __('validation.custom.phone.required'),
                'phone.numeric' => __('validation.custom.phone.numeric'),
                'phone.unique' => __('validation.custom.phone.unique'),
                'password.required' => __('validation.custom.password.required'),
                'password.string' => __('validation.custom.password.string'),
                'password.min' => __('validation.custom.password.min'),
                'avtar.max' => __('validation.custom.logo.max'), // Change from 'logo.image' to 'logo.max'
                'birthday.nullable' => __('validation.custom.birthday.required'),
                'birthday.date' => __('validation.custom.birthday.date'),
                'country_id.required' => __('validation.custom.country.required'),
                'country_id.exists' => __('validation.custom.country.exists'),
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


            $user = Customer::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'avtar' => $request->avtar,
                'image_id_back' =>  $request->image_id_back,
                'image_id_front' => $request->image_id_front,
                'birthday' => $request->birthday,
                'status' => 0,
                'country_id'=>$request->country_id
            ]);
            // $account=Account::create([
            //     'customer_id'=>$user->id,
            //     'currancy_id'=>1,
            //     'balance'=>100000,

            // ]);

           event(new Registered($user));


            // Generate JWT token
            $token = JWTAuth::fromUser($user);
            return $this->onSuccessWithToken(200, __('messages.general.create_user'), $user, $token);
        } catch (\Throwable $error) {
            return $this->onError(500, __('messages.general.server_error'), $error->getMessage());
        }
    }

    public function verifyOtp(Request $request)
    {

        $request->validate(['otp' => 'required']);

        $otpEntry = OTP::where('customer_id', helper::customer_id())
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->latest() // Retrieve the latest record based on the created_at timestamp
            ->first(); // Retrieve the first matching record

        // Fetch the user ID using a helper function and then fetch the user model
        $userId = helper::customer_id();
        $user = Customer::find($userId); // Ensure you have included User model at the top

        if (!$otpEntry) {
            return $this->onError(402, __('messages.general.otp_false'), false);
        }
        // OTP is valid
        $user->email_verified = true;
        $user->save();

        // Optionally, delete the OTP entry if it should not be reused
        $otpEntry->delete();

        // OTP is valid
        // Here, you might want to update the user status or perform other actions

        return $this->onSuccess(200, __('messages.general.otp_true'), true);
    }

    public function sendOtp(Request $request)
    {

        $userId = helper::customer_id();
        $user = Customer::find($userId);

        if (!$user) {
            return $this->onError(404, __('messages.general.user_notfound'));
        }

        // Generate a four-digit OTP
        $otp = random_int(1000, 9999);
        $expires_at = now()->addMinutes(10); // Set expiration time

        // Create or update existing OTP record
        OTP::updateOrCreate(
            ['customer_id' => $userId],
            ['otp' => '1234', 'expires_at' => $expires_at]
        );

        // // Send OTP via email or SMS
        // Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
        //     $message->to($user->email)->subject('Verify Your Account');
        // });

        return $this->onSuccess(200, __('messages.general.otp_send'), true);
    }


    public function logout(Request $request)
    {
        try {
            // Invalidate the token by adding it to the blacklist
            JWTAuth::parseToken()->invalidate();
            return $this->onSuccess(200, __('messages.general.logout_success'));
        } catch (JWTException $e) {
            return $this->onError(500, __('messages.general.logout_error'));
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 400);
                return $this->onError(400, 'Token not provided');
            }

            $refreshedToken = JWTAuth::refresh($token);
            return $this->onSuccessWithToken(200, 'success change token', null, $refreshedToken);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->onError(401, 'Token is invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->onError(500, 'Could not refresh token');
        }
    }
    public function forgetpassword(Request $request)
    {
        // Determine if the input is an email or phone and adjust rules accordingly
        $rules = [
            'password' => ['required', 'min:6', 'confirmed'],
            'email' => [
                'required'
                , 'email', 'max:255', 'unique:customers,email',

            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Collect all error messages
            $errorMessages = $validator->errors()->all();

            // Combine all messages into a single string
            $combinedErrorMessage = implode(' ', $errorMessages);

            return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
        }

        $customer= Customer::where('email', $request->email)->first();

        if (!$customer) {
            return $this->onError(404, __('messages.general.user_notfound'));
        }
        $customer->password = Hash::make($request->password);
        $customer->is_verified = true;

        $customer->save();
        return $this->onSuccess(200, __('messages.general.change_pass'), true);
        // Perform validation
    }

    private function checkUser($identifier, $search_by)
    {
        return Customer::where($search_by, $identifier)->first();
    }

    private function sendOtpToUser(Customer $customer)
    {
        // Generate a four-digit OTP
        $otp = random_int(1000, 9999);
        $expires_at = now()->addMinutes(10); // Set expiration time

        // Create or update existing OTP record
        OTP::updateOrCreate(
            ['customer_id' => $customer->id],
            ['otp' =>'1234', 'expires_at' => $expires_at]
        );

        // Send OTP via email or SMS
        if ($customer->email) {
            // Mail::raw("Your OTP is: $otp", function ($message) use ($customer) {
            //     $message->to($customer->email)->subject('Verify Your Account');
            // });
        } else {
            // Implement SMS sending logic here
        }

        return $this->onSuccess(200, __('messages.general.otp_send'), true);
    }
    public function verifyOtp_for_change_pass(Request $request)
    {


        $request->validate(['otp' => 'required']);

        $otpEntry = OTP::where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();
        // Fetch the user ID using a helper function and then fetch the user model

        if (!$otpEntry) {
            return $this->onError(402, __('messages.general.otp_false'), false);
        }

        // OTP is valid
        // Here, you might want to update the user status or perform other actions

        return $this->onSuccess(200, __('messages.general.otp_true'), true);
    }

    public function changepass(Request $request)
    {
        $rules = [
            'otp' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
            'email' => [
                'required'
                , 'email', 'max:255', 'unique:customers,email',

            ],
        ];

        $search_by = 'email';
        $identifier = $request->email;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Collect all error messages
            $errorMessages = $validator->errors()->all();

            // Combine all messages into a single string
            $combinedErrorMessage = implode(' ', $errorMessages);

            return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
        }


        $customer = $this->checkUser($identifier, $search_by);
        if (!$customer) {
            return $this->onError(404, __('messages.general.user_notfound'));
        }


        $otpEntry = OTP::where('customer_id', '=', $customer->id)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();
        // Fetch the user ID using a helper function and then fetch the user model

        if (!$otpEntry) {
            return $this->onError(402, __('messages.general.otp_false'), false);
        }

        // OTP is valid
        // Here, you might want to update the user status or perform other actions
        $cus =  Customer::find($otpEntry->customer_id);
        $cus->password = Hash::make($request->password);
        $cus->is_verified = true;

        $cus->save();
        $otpEntry->delete();


        return $this->onSuccess(200, __('messages.general.change_pass'), true);
    }






    //////update profile

    // public function updateUser(Request $request)
    // {
    //     $userId = helper::customer_id();

    //     $user = Customer::find($userId);
    //     if (!$user) {
    //         return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
    //     }

    //     // Base rules for all inputs
    //     $rules = [
    //         'phone' => [
    //             'nullable',
    //             'numeric',
    //             'regex:/^(5|6|9)[0-9]{7}$/',
    //             'unique:customers,phone,' . $userId
    //         ],
    //         'password' => ['nullable', 'string', 'min:6'],
    //         'address' => ['nullable', 'string', 'max:255'],
    //         'avtar' => ['nullable','string','max:300'], // Validate image and size limit to 1MB
    //         'image_id_front' => ['required_with:image_id_back','string','max:300'], // Required if image_id_back is present, validate image and size limit to 1MB
    //         'image_id_back' => ['required_with:image_id_front','string','max:300'], // Required if image_id_front is present, validate image and size limit to 1MB
    //     ];

    //     $customMessages = [
    //         'phone.numeric' => __('validation.custom.phone.numeric'),
    //         'phone.regex' => __('validation.custom.phone.regex'),
    //         'phone.unique' => __('validation.custom.phone.unique'),
    //         'password.string' => __('validation.custom.password.string'),
    //         'password.min' => __('validation.custom.password.min'),
    //         'address.string' => __('validation.custom.address.string'),
    //         'address.max' => __('validation.custom.address.max'),
    //         'avtar.max' => __('validation.custom.avtar.max'),
    //         'image_id_front.required_with' => __('validation.custom.image_id_front.required_with'),
    //         'image_id_front.string' => __('validation.custom.image_id_front.string'), // Adjusted to 'string' from 'image'
    //         'image_id_front.max' => __('validation.custom.image_id_front.max'),
    //         'image_id_back.required_with' => __('validation.custom.image_id_back.required_with'),
    //         'image_id_back.string' => __('validation.custom.image_id_back.string'), // Adjusted to 'string' from 'image'
    //         'image_id_back.max' => __('validation.custom.image_id_back.max'),
    //     ];

    //     // Perform validation
    //     $validator = Validator::make($request->all(), $rules, $customMessages);
    //     if ($validator->fails()) {
    //         // Collect all error messages
    //         $errorMessages = $validator->errors()->all();

    //         // Combine all messages into a single string
    //         $combinedErrorMessage = implode(' ', $errorMessages);

    //         return $this->onError(422, $combinedErrorMessage, __('messages.general.validation_error'));
    //     }

    //     $input = $request->only(['phone', 'address']);

    //     if ($request->has('phone') && $request->phone != null) {
    //         $user->phone = $request->phone;
    //         $user->is_verified = 0;
    //     }

    //     if ($request->has('address') && $request->address != null) {
    //         $user->address = $request->address;
    //     }

    //     if ($request->has('image_id_front') || $request->has('image_id_back')) {
    //         $user->is_approve_id = 0;
    //     }

    //     if ( $request->avtar !=null) {

    //         $user->avtar = $request->avtar;
    //     }

    //     if ($request->image_id_front !=null) {

    //         $user->image_id_front = $request->image_id_front;
    //     }

    //     if ($request->image_id_back !=null) {
    //       $user->image_id_back = $request->image_id_back;
    //     }

    //     // Handle password separately
    //     if ($request->filled('password')) {

    //         $user->password = bcrypt($request->password);
    //     }

    //     try {
    //         $user->save();

    //         return $this->onSuccess(200, 'User updated successfully', $user);
    //     } catch (Exception $e) {
    //         return $this->onError(500, $e->getMessage());
    //     }
    // }
    public function updateUser(Request $request)
    {
        $userId = helper::customer_id();

        $user = Customer::find($userId);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }

        // Base rules for all inputs
        $rules = [

            'password' => ['nullable', 'string', 'min:6'],
            'avtar' => ['nullable','string','max:300'], // Validate image and size limit to 1MB
            'image_id_front' => ['required_with:image_id_back','string','max:300'], // Required if image_id_back is present, validate image and size limit to 1MB
            'image_id_back' => ['required_with:image_id_front','string','max:300'], // Required if image_id_front is present, validate image and size limit to 1MB
        ];

        $customMessages = [

            'password.string' => __('validation.custom.password.string'),
            'password.min' => __('validation.custom.password.min'),
            'address.string' => __('validation.custom.address.string'),
            'address.max' => __('validation.custom.address.max'),
            'avtar.max' => __('validation.custom.avtar.max'),
            'image_id_front.required_with' => __('validation.custom.image_id_front.required_with'),
            'image_id_front.string' => __('validation.custom.image_id_front.string'), // Adjusted to 'string' from 'image'
            'image_id_front.max' => __('validation.custom.image_id_front.max'),
            'image_id_back.required_with' => __('validation.custom.image_id_back.required_with'),
            'image_id_back.string' => __('validation.custom.image_id_back.string'), // Adjusted to 'string' from 'image'
            'image_id_back.max' => __('validation.custom.image_id_back.max'),
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
        $input = array_filter($request->all(), function ($value) {
            return !is_null($value);
        });

        if ($request->filled('password')) {

            $user->password = bcrypt($request->password);
        }

        if ($request->has('image_id_front') || $request->has('image_id_back')) {
            $user->is_approve_id = 0;
        }
        try {
            $user->updateOrFail($input);
            return $this->onSuccess(200, 'User updated successfully', $user);
        } catch (Exception $e) {
            return $this->onError(500, $e->getMessage());
        }
    }
    public function countries(){
        $countries=Countries::where('status',1)->get();
        $transformedData = helper::transformDataByLanguage($countries->toArray());
        return $this->onSuccess(200, 'found', $transformedData);
    }
    /////banks
    public function banks(){
        $banks=Banks::get();
        $transformedData = helper::transformDataByLanguage($banks->toArray());
        return $this->onSuccess(200, 'found', $transformedData);
    }
}
