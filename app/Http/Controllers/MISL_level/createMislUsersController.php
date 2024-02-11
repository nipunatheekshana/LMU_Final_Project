<?php

namespace App\Http\Controllers\MISL_level;

use App\Http\common\commonFeatures;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class createMislUsersController extends Controller
{
    use commonFeatures;

        public function save(Request $request){
            $validatedData= $request->validate([
                'name' => ['required'],
                'email' => ['required','email'],
                'password' => ['required','confirmed','min:6'],

            ]);
            try{
                $user=new User();
                $user->name=$request->name;
                $user->email=$request->email;
                $user->user_level='MISLuser';
                $user->password=Hash::make($request->password);
                $save=$user->save();

                if($save){
                    $responseBody = $this->responseBody(true, "save", "User Saved",'data saved');

                }
            }
            catch(Exception $exception){
                $responseBody = $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());

            }
            return response()->json(["data" => $responseBody]);

        }

    public function update(Request $request){

        $validatedData= $request->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'password' => ['nullable','confirmed','min:6'],

        ]);
        try{
            $save=User::where('id',$request->hiddnUserId)
            ->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            if($save){
                $responseBody = $this->responseBody(true, "update", "Company Updated",'data saved');

            }
        }
        catch(Exception $exception){
            $responseBody = $this->responseBody(false, "update", $request->hiddnUserId, $exception->getMessage());

        }
        return response()->json(["data" => $responseBody]);

    }

    public function loadUsers(){
        try {
                $User=User::where('user_level','MISLuser')->get();
                return $this->responseBody(true, "loadUsers", "found",$User );

        }
         catch (Exception $exception) {
            return $this->responseBody(false, "loadUsers", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadUser($id){
        try {
                $User=User::where('id',$id)->first();
                return $this->responseBody(true, "loadUser", "found",$User );

        }
         catch (Exception $exception) {
            return $this->responseBody(false, "loadUser", "Something went wrong", $exception->getMessage());
        }
    }
    public function delete($id){
        try {


                $User=User::where('id',$id)->delete();
                return $this->responseBody(true, "User", "User Deleted",null );

        }
         catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
}
