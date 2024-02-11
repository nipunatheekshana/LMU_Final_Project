<?php

namespace App\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\UserSetting;

class UserCustomizeController extends Controller
{
    use commonFeatures;
    public function SaveTheme(Request $request)
    {
        try {

            UserSetting::updateOrCreate(['user_id' => Auth::user()->id], ['isDarkMode' => $request->darkMood]);

            return $this->responseBody(true, "SaveTheme", "Saved", [$request->darkMood]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "SaveTheme", "Something Went Wrong", $ex->getMessage());
        }
    }
    //return dark or light mood according to the users preferance this is called in app.blade
    public static  function loadTheam()
    {
        try {
            $isDarkMode = UserSetting::where('user_id', Auth::id())->value('isDarkMode');
            return $isDarkMode ? 'dark' : '';
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
