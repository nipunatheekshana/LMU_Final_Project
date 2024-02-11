<?php

namespace App\Http\Controllers\MISL_level;

use App\Http\common\commonFeatures;
use App\Http\Controllers\Controller;
use App\Models\Parent_company;
use Exception;
use Illuminate\Http\Request;

class editParentCompanyController extends Controller
{
    use commonFeatures;
    function loadMotherCompanyData()
    {
        try {
            $motherCompany = Parent_company::first();
            return $this->responseBody(true, "loadMotherCompanyData", "found", $motherCompany);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadMotherCompanyData", "something went wrong", $exception->getMessage());
        }
    }

    public function save(Request $request){
        $validatedData= $request->validate([
            'name' => ['required'],
            'telepone_no' => ['nullable','regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'email' => ['nullable','email'],

        ]);
        try{
            $save=Parent_company::where('id',1)
            ->update(
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'email' => $request->email,
                    'contacts' => $request->contacts,
                ]);
            if($save){
                $responseBody = $this->responseBody(true, "save", "Company Updated",'data saved');

            }
        }
        catch(Exception $exception){
            $responseBody = $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());

        }
        return response()->json(["data" => $responseBody]);

    }
}
