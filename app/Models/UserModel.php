<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
      // echo "<pre>";print_r($getUserDetails);die();
    protected $table = "users"; 

    protected $fillable = ['name','email','salary','password'];

    protected $connection = 'mysql';

    public static function getUserListModel(){
        $userList = DB::table("users")->select(['id','name','email','salary','status','created_at'])->latest('id')->get();
        return $userList;
    }
    
    public static function addUserDetailsModel($addUserArr){
        $addUserDetailsID = DB::table("users")->insertGetId($addUserArr);
        // $lastInsertId = DB::getPdo()->lastInsertId();
        return $addUserDetailsID;
    }

    public static function getUserDetails($id){
        $where = array('id'=>$id);
        $select = ['id','name','email','salary','profile_img','profile_img_name','profile_img_type','profile_img_data'];
        $getUserDetails = DB::table("users")->select($select)->where($where)->get()->toArray();
        return $getUserDetails;
    }

    public static function updateUserDetails($updateReqArr,$where){
        $updateUserDetails = DB::table("users")->where($where)->update($updateReqArr);
        return $updateUserDetails;
    }
}
