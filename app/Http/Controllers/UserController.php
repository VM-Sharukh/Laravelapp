<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //
    public function getUserList(){
        $user = Auth::user();
        // dd($user->name);
        $getUserList = UserModel::getUserListModel();
        $data['getUserList'] =  $getUserList;
        // echo "<pre>";print_r($data['getUserList']);die();
        return view('users.index',$data);
    }

    public function updateUserStatus(Request $request){
        // echo "<pre>";print_r($request->header('X-CSRF-TOKEN'));die();
        // echo "<pre>";print_r($request->headers->all());die();
        try{
            $user_id = $request->user_id;
            $status  = $request->status;

            $user_details = UserModel::find($user_id);
            if(!$user_details){
                $data = ['success'=>false,'message'=>'user not found.'];
                return response()->json($data);
            }

            $user_details->status = $status;
            $user_details->save();

            $data = ['success'=>true,'message'=>'status updated successfully.'];
            return response()->json($data);

        }catch(Exception $e){
            $data = ['success'=>false,'message'=>$e->getMessage()];
            return response()->json($data);
        }
        
    }

    public function addUser(){
        return view('users.add');
    }

    public function addUserDetails(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'salary'=>'required|integer',
            'profile_img'=>'required|mimes:jpg,jpeg,png|max:2048',
        ],
        [
            'name.required' => 'Please Enter Name',
            'email.required' => 'Please Enter Email',
            'email. ' => 'Please Enter valid Email',
            'salary.required' => 'Please Enter Salary',
            'profile_img.required' => 'Please Select Profile Image',
        ],
        
        );

        if($validator->fails()){
            return redirect()->route('users.add-user')->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $email = $request->email;
        $password = Hash::make('password1234');
        $salary = $request->salary;
        list($profile_img_name,$profile_img_type,$profile_img_data) = $this->getEncryptedImgData($request);
        $profile_img = $this->uploadProfileImg($request);
        $created_at = getCurrentDatetime();

        $addUserArr = [
            'name'=>$name,'email'=>$email,'password'=>$password,'salary'=>$salary,'profile_img'=>$profile_img,
            'profile_img_name'=>$profile_img_name,'profile_img_type'=>$profile_img_type,'profile_img_data'=>$profile_img_data,
            'created_at'=>$created_at
        ];
        $addUserDetailsID = UserModel::addUserDetailsModel($addUserArr);
        if($addUserDetailsID > 0){
            $addUserDetailsID = Crypt::EncryptString($addUserDetailsID);
            return redirect()->route('users.fetch-details',$addUserDetailsID)->with('success','User added successfully');
        }
        // dump($addUserDetails);
        
    }

    public function uploadProfileImg($request){
        $profile_img_name = "NA";
        if($request->hasFile('profile_img')){
            $file = $request->file('profile_img');

            $random_str = getRandomStringUniqueID();
            $getCurrentDatetime = strtotime(getCurrentDatetime());
            $extension = $file->getClientOriginalExtension();
            $profile_img_name = $random_str.$getCurrentDatetime.".".$extension;

            // $file->move(public_path('uploads/profile_img'),$profile_img_name);

            $filePath = $file->storeAs(
                'uploads/profile_img',
                $profile_img_name,
                'public'
            );
        }
        return $profile_img_name;
    }

    public function unlinkProfileImg($profile_img){
        /*
            $profile_img_location =  public_path('uploads/profile_img/'.$profile_img);
            if(file_exists($profile_img_location)){
                unlink($profile_img_location);
            }
        */

        if(Storage::disk('public')->exists('uploads/profile_img/'.$profile_img)){
            Storage::disk('public')->delete('uploads/profile_img/'.$profile_img);
        }
    }

    public function fetchUserDetails($id){
        try{
            $id = Crypt::decryptString($id);

            $getUserDetails = UserModel::getUserDetails($id)[0];
            $data['getUserDetails'] =  $getUserDetails;

            $data['getImageBase64'] = $this->getImageBase64($getUserDetails);
            // echo "<pre>";print_r($data['getUserDetails']);die();
            return view('users.edit',$data);
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            // return response()->json(['error' => 'Server Error'], 500);
            abort(500);
        }
        
    }

    public function getEncryptedImgData($request){
    
        $profile_img_file = $request->file('profile_img');
        $fileContent  = file_get_contents($profile_img_file->getRealPath());
        $base64Encode = base64_encode($fileContent);
        $encryptedFile = Crypt::encryptString($base64Encode);
        
        $random_str = getRandomStringUniqueID();
        $getCurrentDatetime = strtotime(getCurrentDatetime());
        $extension = $profile_img_file->getClientOriginalExtension();
        $profile_img_name = $random_str.$getCurrentDatetime.".".$extension;

        $fileType = $profile_img_file->getMimeType();

        $encryptedImgData = array($profile_img_name,$fileType,$encryptedFile);
        // echo "<pre>";print_r($encryptedImgData);die();
        return $encryptedImgData;
    }

    public function getImageBase64($getUserDetails){
        $profile_img_data =  $getUserDetails->profile_img_data;
        if($profile_img_data == "") return "";
        $decyptedData   = Crypt::decryptString($profile_img_data);
        $imageData      = base64_decode($decyptedData);
        $imageBase64    = base64_encode($imageData);
        return $imageBase64;
    }

    public function validateProfileImg($request){
        $validateProfileImg = ($request->hasFile('profile_img')) ? ['required','mimes:jpg,jpeg,png','max:2048'] : [];
        return $validateProfileImg;
    }

    public function updateUserDetails(Request $request,$id){
        // dd($request->file());
        $id = Crypt::decryptString($id);
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required','email',Rule::unique('users')->ignore($id)],
            'salary' => ['required','integer'],
            'profile_img' => $this->validateProfileImg($request)
        ]);

        if($validator->fails()){
            $id = Crypt::encryptString($id);
            return redirect()->route("users.fetch-details",$id)->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $email = $request->email;
        $password = Hash::make('123456');
        $salary = $request->salary;

        if($request->hasFile('profile_img')){
            list($profile_img_name,$profile_img_type,$profile_img_data) = $this->getEncryptedImgData($request);
            $profile_img = $this->uploadProfileImg($request);
            $this->unlinkProfileImg($request->old_profile_img);
        }else{
            list($profile_img_name,$profile_img_type,$profile_img_data) = array($request->old_profile_img_name,
            $request->old_profile_img_type,$request->old_profile_img_data);
            $profile_img = $request->old_profile_img;
        }
        $updated_at = getCurrentDatetime();

        $updateReqArr = array('name'=>$name,'email'=>$email,'password'=>$password,'salary'=>$salary,'profile_img'=>$profile_img,
            'profile_img_name'=>$profile_img_name,'profile_img_type'=>$profile_img_type,'profile_img_data'=>$profile_img_data,
            'updated_at'=>$updated_at);
        $where = array('id'=>$id);
        $updateUserDetails = UserModel::updateUserDetails($updateReqArr,$where);
        if($updateUserDetails > 0){
            return redirect()->route("users.user-list")->with('success','User updated successfully.');
        }
    }

    public function downloadUserData(){
        $filename = "users.csv";
        $headers = [
            "Content-Type"=>"text/csv",
            "Content-Disposition"=>"attachment; filename=$filename"
        ];
        return response()->stream(function(){
            $file = fopen("php://output","w");
            fputcsv($file,['ID','Name','Email','Created']);
            $getUserList = UserModel::getUserListModel();
            foreach($getUserList as $user){
                $id = $user->id;
                $name = $user->name;
                $email = $user->email;
                $created_at = $user->created_at;
                fputcsv($file,[$id,$name,$email,$created_at]);
            }
            
        },200,$headers);
    }

    public function fetchUserProfile(Request $request){

    echo "fetchUserProfile fn";
    }
}
