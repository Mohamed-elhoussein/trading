<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


            User::create([
                "name"=>"mohamed",
                "email"=>"mohamed@y.com",
                "password"=>Hash::make(12345),
            ]);


        // DB::table('order_status')->insert([
        //     'title_ar'=>'جارى المراجعه',
        //     'title_en'=>'Reviewing in progress',
        //     'persage'=>20,
        //     'backgroud_color'=>'#007DFC'
        // ]);
        // DB::table('order_status')->insert([
        //     'title_ar'=>'تمت الموافقة علي الطلب',
        //     'title_en'=>'The request has been approved',
        //     'persage'=>100,
        //     'backgroud_color'=>'#2ECC71'
        // ]);
        // DB::table('order_status')->insert([
        //     'title_ar'=>'تم رفض  الطلب',
        //     'title_en'=>'reques has been rejected',
        //     'persage'=>0,
        //     'backgroud_color'=>'#EF0808'
        // ]);
        // DB::table('currancies')->insert([
        //     'name'=>'dollar',
        //    'symble'=>'$'
        // ]);

        // DB::table('stocks')->insert([
        //         'name'=>'Gold 1 KM',
        //         'symble'=>'A7A7',
        //         'measure'=>0,
        //         'feas_buy'=>10,
        //         'feas_seller'=>20,
        //         'min_deliverd'=>2,
        //         'feas_deliverd_for_one'=>1,
        //     ]);


        //     DB::table('fields_types')->insert([
        //         'title_ar'=>'نص او رقم',
        //         'title_en'=>'text or phone'
        //     ]);
        //     DB::table('fields_types')->insert([
        //         'title_ar'=>'صوره او ملف',
        //         'title_en'=>'image or file'
        //     ]);



        //      DB::table('countries')->insert([
        //         'title_ar'=>'مصر',
        //         'title_en'=>'egypt',
        //         'iso'=>'EG',
        //         'status'=>true
        //     ]);
        //     DB::table('countries')->insert([
        //         'title_ar'=>'الكويت',
        //         'title_en'=>'Kuwait',
        //         'iso'=>'KW',
        //         'status'=>true
        //     ]);
        //       DB::table('payments')->insert([
        //         'name'=>'instapay',
        //         'type'=>true,
        //     ]);

        //     DB::table('transaction_statuses')->insert([
        //         'title_en'=>'The amount has been deposited',
        //         'title_ar'=>'تم ايداع المبلغ'
        //     ]);

        //     DB::table('transaction_statuses')->insert([
        //         'title_ar'=>'تم سحب المبلغ',
        //         'title_en'=>'The amount has been withdrawn'
        //     ]);
        //     DB::table('transaction_statuses')->insert([
        //         'title_en' => 'The deposit request has been made',
        //         'title_ar' => 'تم طلب ايداع المبلغ'
        //     ]);

        //     DB::table('transaction_statuses')->insert([
        //         'title_en' => 'The withdrawal request has been made',
        //         'title_ar' => 'تم طلب سحب المبلغ'
        //     ]);



        // DB::table('banks')->insert([
        //     'title_ar'=>'بنك عوده',
        //     'title_en'=>'Bank Audi',
        //     'feas'=>10,
        //     'persage'=>0,
        // ]);
        // DB::table('banks')->insert([
        //     'title_ar'=>'بنك مصر',
        //     'title_en'=>'Egypt Bank',
        //     'feas'=>10,
        //     'persage'=>1,
        // ]);
        // DB::table('status_withdrawns')->insert([
        //     'title_en' => 'pending',
        //     'title_ar' => 'قيد الانتظار'
        // ]);

        // DB::table('status_withdrawns')->insert([
        //     'title_en' => 'accepting',
        //     'title_ar' => 'تم القبول'
        // ]);

        // DB::table('status_withdrawns')->insert([
        //     'title_en' => 'rejecting',
        //     'title_ar' => 'تم الرفض'
        // ]);

        //   DB::table('fields')->insert([
        //     'title_en' => 'please enter id number',
        //     'title_ar' =>'يرجى ادخال رقم البطاقه',
        //     'fields_type'=>1
        // ]);

        // DB::table('fields')->insert([
        //     'title_en' => 'please enter image id front',
        //     'title_ar' =>'يرجى ادخال صوره البطاقه الاماميه',
        //     'fields_type'=>2
        // ]);
        // DB::table('fields')->insert([
        //     'title_en' => 'please enter image id back',
        //     'title_ar' =>'يرجى ادخال صوره البطاقه الخلفيه',
        //     'fields_type'=>2
        // ]);
        // DB::table('fields_countries')->insert([
        //     'country_id' => 1,
        //     'field_id'=>1
        // ]);

        // DB::table('fields_countries')->insert([
        //     'country_id' => 1,
        //     'field_id'=>2
        // ]);

        // DB::table('fields_countries')->insert([
        //     'country_id' => 1,
        //     'field_id'=>3
        // ]);

        // DB::table('fields_countries')->insert([
        //     'country_id' => 2,
        //     'field_id'=>1
        // ]);





    }
}
