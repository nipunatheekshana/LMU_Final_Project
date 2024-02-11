<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Settings\Entities\Country;

class ApiController extends Controller
{
    // public function saveCountry(Request $request)
    // {
    //     try {
    //         $Country = new Country();
    //         $Country->country_code=$request->country_code;
    //         $Country->country_name=$request->country_name;
    //        if ($Country->save()){
    //         return "data saved";

    //        }

    //     } catch (Exception $ex) {
    //         return $ex->getMessage();
    //     }
    // }
}
