<?php
namespace App\Utils;

use App\Models\Account;
use Illuminate\Support\Facades\App;

class helper
{
    public static function customer_id(){
        $user = auth('api')->user();
        if($user){
            return $user->id;
        }else{
            return false;
        }
    }
    public static function lang_app()
    {
        return App::getLocale();
    }

    public static function get_account($id){
        $account=Account::where('id',$id)->where('customer_id',self::customer_id())->first();
        if($account){
            return $account;
        }else{
            return false;
        }
    }

    public static function transformDataByLanguage($data)
    {
        // Ensure the data is in the correct format before proceeding
        if (!is_array($data) && !is_object($data)) {
            throw new \InvalidArgumentException('Data must be an array or an object');
        }

        $language = self::lang_app();
        $suffix = $language === 'ar' ? '_ar' : '_en';

        // Handle single object transformation without changing the type
        $isSingleObject = is_object($data);
        if ($isSingleObject) {
            $data = (array) $data;
        }

        // Handle single item array (like a single record) by wrapping it into another array
        $isSingleRecord = isset($data['id']);
        if ($isSingleRecord) {
            $data = [$data];
        }

        // Function to transform individual items
        $transformItem = function ($item) use ($suffix) {
            if (is_object($item)) {
                $item = (array) $item;
            }

            if (!is_array($item)) {
                return $item; // Skip non-array items
            }

            $transformedItem = [];
            foreach ($item as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    // Recursively transform nested arrays or objects
                    $transformedItem[$key] = self::transformDataByLanguage($value);
                } elseif (strpos($key, $suffix) !== false) {
                    // Include only columns with the specified suffix
                    $newKey = str_replace($suffix, '', $key);
                    $transformedItem[$newKey] = $value;
                } elseif (!preg_match('/_(ar|en)$/', $key)) {
                    // Include columns that do not have _ar or _en suffixes
                    $transformedItem[$key] = $value;
                }
            }
            return $transformedItem;
        };

        $transformedData = array_map($transformItem, $data);

        // If the input was a single object, return a single transformed object
        if ($isSingleObject || $isSingleRecord) {
            return $transformedData[0];
        }

        return $transformedData;
    }
}
