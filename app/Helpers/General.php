<?php

use Illuminate\Support\Facades\DB;

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
