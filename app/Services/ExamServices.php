<?php

namespace App\Services;

use App\Models\Questions;
use Exception;
use Brian2694\Toastr\Facades\Toastr;

class ExamServices
{
    public function getExam(){
        $data=Questions::with('choises')->get();
        return $data;
    }
    public function getCount(){
        $count=Questions::count();
        return $count;
    }

}
