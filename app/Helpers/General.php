<?php

use Illuminate\Support\Facades\DB;


const CHPRBN_CBT_API_KEY = "sht022";
const CHPRBN_CBT_SECRET_KEY = "022sht";
const CHPRBN_SERV_ADDR = "https://cbt.chprbn.gov.ng/api/v1/";



if(!function_exists('logo')){
    function logo($width = 50, $height = 50){
        return asset('candidate/assets/images/logo/logo.png').'"  width="'.$width.'" height="'.$height;
    }
}

function reset_auto_increment($table_name){
    if(DB::statement("ALTER TABLE $table_name AUTO_INCREMENT = 1"))
        return true;
    return false;
}


function tempPassport(){
    return asset('commons/images/user.jpg');
}

function candidate_passport_path(){
    return 'storage/images/candidates';
}

function searchIndex($array, $column_name){
    foreach ($array as $key => $value) {
        if (stripos($value, $column_name) !== false) {
            return $key;
        }
    }
    return null;
}

function searchForId($search_value, $array) {
    // Iterating over main array
    foreach ($array as $key1 => $val1) {
        $temp_path = array();
        // Adding current key to search path
        array_push($temp_path, $key1);
        // Check if this value is an array
        // with atleast one element
        if(is_array($val1) and count($val1)) {
            // Iterating over the nested array
            foreach ($val1 as $key2 => $val2) {
                if(strtoupper($val2) == strtoupper($search_value)) {
                    // Adding current key to search path
                    array_push($temp_path, $key2);
                    return (object)$array[$key1] = $val1;
                }
            }
        }
        elseif(strtoupper($val1) == strtoupper($search_value)) {
            return (object)$array[$key1] = $val1;
        }
    }
    return null;
}

function jResponse($status = true, $message = '', $data = []) {
    return response()->json(['status'=>$status, 'message'=>$message, 'data'=>$data]);
}