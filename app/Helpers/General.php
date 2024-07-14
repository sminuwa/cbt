<?php

if(!function_exists('logo')){
    function logo($width = 50, $height = 50){
        return ' '.asset('candidate/assets/images/logo/logo.png').'"  width="'.$width.'" height="'.$height;
    }
}
