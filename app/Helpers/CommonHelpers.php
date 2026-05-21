<?php

use Illuminate\Support\Str;

if(!function_exists('getCurrentDatetime')){
    function getCurrentDatetime(){
        $currentDateTime = date('Y-m-d H:i:s');
        return $currentDateTime;
    }
}

if(!function_exists('getUserNameByID')){
    function getUserNameByID($id){
        $nameMappedArray = array(1=>'Sharukh');
        return isset($nameMappedArray[$id]) ? $nameMappedArray[$id] : 'NA';
    }
}

if(!function_exists('getRandomStringUniqueID')){
    function getRandomStringUniqueID(){
        $uuid = Str::uuid();
        return $uuid;die();
    }
}

?>