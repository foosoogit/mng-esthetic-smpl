<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InitConsts extends Controller
{
    //class initConsts{
        public static function MinimumLessonTimeInterval(){
            $inits_array=DB::table('configrations')->where('subject','=','MinimumLessonTimeInterval')->first();
            //print_r($inits_array);
            //print 'value1='.$inits_array->value1;
            return $inits_array->value1;
        }
        public static function LessonInterval(){
            $inits_array=DB::table('configrations')->where('subject','=','LessonInterval')->first();
            return $inits_array->value1;
        }
        public static function RestTime(){
            $inits_array=DB::table('configrations')->where('subject','=','RestTime')->first();
            return $inits_array->value1;
        }
        
        public static function VerifycodeTimeLimitTeacher(){
            $inits_array=DB::table('configrations')->where('subject','=','VerifycodeTimeLimitTeacher')->first();
            return $inits_array->value1;
        }
        
        public static function DdisplayLineNumCustomerList(){
            $inits_array=DB::table('configrations')->where('subject','=','DdisplayLineNumCustomerList')->first();
            return $inits_array->value1;
        }
        
        public static function DdisplayLineNumContractList(){
            $inits_array=DB::table('configrations')->where('subject','=','DdisplayLineNumContractList')->first();
            return $inits_array->value1;
        }
        
        public static function ReasonsComing(){
            $inits_array=DB::table('configrations')->where('subject','=','ReasonComing')->first();
            return $inits_array->value1;
        }
        
        public static function MaxTreatmentsTimes(){
            $inits_array=DB::table('configrations')->where('subject','=','MaxTreatmentsTimes')->first();
            return $inits_array->value1;
        }
        
        public static function PaymentNumMax(){
            $inits_array=DB::table('configrations')->where('subject','=','PaymentNumMax')->first();
            return $inits_array->value1;
        }
    
        public static function KesanMonth(){
            $inits_array=DB::table('configrations')->where('subject','=','KesanMonth')->first();
            return $inits_array->value1;
        }
    
        public static function TargetContractMoney(){
            $inits_array=DB::table('configrations')->where('subject','=','TargetContractMoney')->first();
            return $inits_array->value2;
        }
}
