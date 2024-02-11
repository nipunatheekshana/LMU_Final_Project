<?php

namespace Modules\Settings\Http\Controllers\CompanySetting;

use App\Http\common\commonFeatures;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Settings\Entities\Company;

class CreateCompanyUsersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'company' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6'],

        ]);
        try {
            $user = new User();
            $user->name = $request->name;
            $user->company_id = $request->company;
            $user->email = $request->email;
            $user->user_level = 'CCuser';
            $user->password = Hash::make($request->password);
            $save = $user->save();

            if ($save) {
                $responseBody = $this->responseBody(true, "save", "User saved", 'data saved');
            }
        } catch (Exception $exception) {
            $responseBody = $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
        return response()->json(["data" => $responseBody]);
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required'],
            'company' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);
        try {
            $save = User::where('id', $request->hiddnUserId)
                ->update(
                    [
                        'name' => $request->name,
                        'company_id' => $request->company,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]
                );
            if ($save) {
                $responseBody = $this->responseBody(true, "update", "Company Updated", 'data saved');
            }
        } catch (Exception $exception) {
            $responseBody = $this->responseBody(false, "update", $request->hiddnUserId, $exception->getMessage());
        }
        return response()->json(["data" => $responseBody]);
    }

    public function loadUsers()
    {
        try {
            $User = User::where('user_level', 'CCuser')->get();
            return $this->responseBody(true, "loadUsers", "found", $User);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadUsers", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadUser($id)
    {
        try {
            $User = User::where('id', $id)->first();
            return $this->responseBody(true, "loadUser", "found", $User);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadUser", "Something went wrong", $exception->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $User = User::where('id', $id)->delete();
            return $this->responseBody(true, "User", "User Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCompany()
    {
        try {
            $Company = Company::all();
            return $this->responseBody(true, "loadCompany", "found", $Company);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCompany", "Something went wrong", $exception->getMessage());
        }
    }
}
