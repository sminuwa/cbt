<?php

use Illuminate\Support\Facades\DB;


const CHPRBN_CBT_API_KEY = "shtl095";
const CHPRBN_CBT_SECRET_KEY = "590lths";
const CHPRBN_SERV_ADDR = "https://qwertyuiop.chprbn.gov.ng/api/v1/";

const APP_NAME = 'RMRDC 2025 Promotional Exam';

// Organization Configuration
const ORG_NAME = 'Raw Materials Research and Development Council';
const ORG_SHORT_NAME = 'RMRDC';
const ORG_ACRONYM = 'RMRDC';
const ORG_WEBSITE = 'https://www.rmrdc.gov.ng/';
const ORG_EMAIL = 'info@rmrdc.gov.ng/';
const ORG_PHONE = '+234-XXX-XXX-XXXX';
const ORG_ADDRESS = 'Abuja, Nigeria';

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


function searchArrayWithMultipleParameters($array, $conditions) {
    return array_filter($array, function($item) use ($conditions) {
        foreach ($conditions as $key => $value) {
            if (!isset($item[$key]) || $item[$key] != $value) {
                return false; // If any condition is not met, return false
            }
        }
        return true; // All conditions are met
    });
}

function search_multiple_param($search_list, $array) {
    // Create the result array
    $result = [];
    // Iterate over each array element
    foreach ($array as $value) {
        // Check if all search conditions match
        $match = true;
        foreach ($search_list as $k => $v) {
            // If any condition is not met, mark match as false
            if (!isset($value[$k]) || $value[$k] != $v) {
                $match = false;
                break;
            }
        }
        // If all conditions are met, add to result
        if ($match) {
            // Cast the array to an object
            $result[] = (object) $value;
        }
    }

    // Return result as an object
    return $result;
}


function removeDuplicates($array) {
    $tempArray = [];
    $uniqueArray = [];

    foreach ($array as $item) {
        // Create a unique key based on test_config_id, venue_id, and date
        // $search_items = implode('-',$param);
        $uniqueKey = $item['test_config_id'] . '-' . $item['venue_id'] . '-' . $item['date'];

        // If the key is not in the temp array, add it and include the item in the result
        if (!isset($tempArray[$uniqueKey])) {
            $tempArray[$uniqueKey] = true;
            $uniqueArray[] = $item;
        }
    }

    return $uniqueArray;
}

function removeDuplicatesCandidateSchedule($array) {
    $tempArray = [];
    $uniqueArray = [];

    foreach ($array as $item) {
        // Create a unique key based on test_config_id, venue_id, and date
        // $search_items = implode('-',$param);
        $uniqueKey = $item['candidate_id'] . '-' . $item['schedule_id'] . '-' . $item['exam_type_id'];

        // If the key is not in the temp array, add it and include the item in the result
        if (!isset($tempArray[$uniqueKey])) {
            $tempArray[$uniqueKey] = true;
            $uniqueArray[] = $item;
        }
    }

    return $uniqueArray;
}

function jResponse($status = true, $message = '', $data = []) {
    return response()->json(['status'=>$status, 'message'=>$message, 'data'=>$data]);
}

// Organization Helper Functions
if (!function_exists('org_name')) {
    /**
     * Get the full organization name
     * @return string
     */
    function org_name() {
        return ORG_NAME;
    }
}

if (!function_exists('org_short_name')) {
    /**
     * Get the organization short name
     * @return string
     */
    function org_short_name() {
        return ORG_SHORT_NAME;
    }
}

if (!function_exists('org_acronym')) {
    /**
     * Get the organization acronym
     * @return string
     */
    function org_acronym() {
        return ORG_ACRONYM;
    }
}

if (!function_exists('org_website')) {
    /**
     * Get the organization website
     * @return string
     */
    function org_website() {
        return ORG_WEBSITE;
    }
}

if (!function_exists('org_email')) {
    /**
     * Get the organization email
     * @return string
     */
    function org_email() {
        return ORG_EMAIL;
    }
}

if (!function_exists('org_phone')) {
    /**
     * Get the organization phone
     * @return string
     */
    function org_phone() {
        return ORG_PHONE;
    }
}

if (!function_exists('org_address')) {
    /**
     * Get the organization address
     * @return string
     */
    function org_address() {
        return ORG_ADDRESS;
    }
}

if (!function_exists('org_full_details')) {
    /**
     * Get all organization details as an array
     * @return array
     */
    function org_full_details() {
        return [
            'name' => ORG_NAME,
            'short_name' => ORG_SHORT_NAME,
            'acronym' => ORG_ACRONYM,
            'website' => ORG_WEBSITE,
            'email' => ORG_EMAIL,
            'phone' => ORG_PHONE,
            'address' => ORG_ADDRESS,
        ];
    }
}

if (!function_exists('org_display_name')) {
    /**
     * Get organization display name with optional format
     * @param string $format Options: 'full', 'short', 'acronym'
     * @return string
     */
    function org_display_name($format = 'full') {
        switch ($format) {
            case 'short':
                return ORG_SHORT_NAME;
            case 'acronym':
                return ORG_ACRONYM;
            case 'full':
            default:
                return ORG_NAME;
        }
    }
}
