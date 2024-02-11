<?php

namespace Modules\Settings\Http\Controllers\CompanySetting;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\Currency;
use Modules\Settings\Entities\Domain;

class CreateCompanyController extends Controller
{
    use commonFeatures;
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'companyName' => ['required'],
            'phone_no' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'fax' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'url'],
            'date_of_incorporation' => ['nullable', 'date'],
            'date_of_commencement' => ['nullable', 'date'],
            'company_logo' => ['image', 'max:1024'],
        ]);
        if (Company::where('companyName', $request->companyName)->exists()) {
            $this->validationError('companyName', 'company Name exists');
        }
        if (Company::where('abbr', $request->abbr)->exists()) {
            $this->validationError('abbr', 'Abbr exists');
        }
        if (Company::where('Company_code', $request->abbr)->exists()) {
            $this->validationError('abbr', 'Company code exists Please Change Abbr');
        }
        try {


            $Company = new Company();
            $Company->parent_company_id = 1;
            $Company->group_company_id = $request->group_company_id;
            $Company->companyName = $request->companyName;
            $Company->abbr = $request->abbr;
            $Company->Company_code = $request->abbr;
            $Company->is_group = $request->has('is_group');
            $Company->domain_id = $request->domain_id;
            $Company->country_id = $request->country_id;
            $Company->currency_id = $request->currency_id;
            $Company->local_currency_id = $request->local_currency_id;
            $Company->date_of_incorporation = $request->date_of_incorporation;
            $Company->date_of_commencement = $request->date_of_commencement;
            $Company->phone_no = $request->phone_no;
            $Company->fax = $request->fax;
            $Company->email = $request->email;
            $Company->website = $request->website;
            $Company->registration_No = $request->registration_No;
            $Company->company_description = $request->company_description;
            $Company->registration_details = $request->registration_details;
            $Company->list_index = $request->list_index;

            $Company->currentFishSerialNo = $request->currentFishSerialNo;
            $Company->minFishSerialNo = $request->minFishSerialNo;
            $Company->maxFishSerialNo = $request->maxFishSerialNo;

            $Company->enabled = $request->has('enabled');
            $Company->created_By = Auth::user()->id;
            $save = $Company->save();


            if ($request->has('company_logo') && $save) {

                $const = '-logo';
                $imagename = $request->companyName . $const; //new image name
                $guessExtension = $request->file('company_logo')->guessExtension(); //file extention
                $file = $request->file('company_logo')->storeAs($request->companyName . '/img/logo/', $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/' . $request->companyName . '/img/logo/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Company::find($Company->id);
                $image->company_logo = $url;
                $image->save();
            }

            // $this->log_activity('createchildcompany', $Company->id, [
            //     ['old_value' => '', 'new_value' => '', 'field_name' => 'name'],
            //     ['old_value' => '', 'new_value' => '', 'field_name' => 'name2'],
            // ]);

            if ($save) {
                return $this->responseBody(true, "save", "Company Created", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadChildCompany($id)
    {
        try {
            $Company = Company::where('id', $id)->first();
            return $this->responseBody(true, "loadChildCompany", "found", $Company);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadChildCompany", "error", $exception->getMessage());
        }
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'companyName' => ['required'],
            'phone_no' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'fax' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'url'],
            'date_of_incorporation' => ['nullable', 'date'],
            'date_of_commencement' => ['nullable', 'date'],
        ]);
        if (Company::where('companyName', $request->companyName)->exists()) {
            if (Company::where('companyName', $request->companyName)->first()->id != $request->companyid) {
                $this->validationError('companyName', 'company Name exists');
            }
        }
        if (Company::where('abbr', $request->abbr)->exists()) {
            if (Company::where('abbr', $request->abbr)->first()->id != $request->companyid) {
                $this->validationError('abbr', 'Abbr exists');
            }
        }
        try {


            $Company = Company::find($request->companyid);
            $Company->group_company_id = $request->group_company_id;
            $Company->companyName = $request->companyName;
            $Company->abbr = $request->abbr;
            $Company->is_group = $request->has('is_group');
            $Company->domain_id = $request->domain_id;
            $Company->country_id = $request->country_id;
            $Company->currency_id = $request->currency_id;
            $Company->local_currency_id = $request->local_currency_id;
            $Company->date_of_incorporation = $request->date_of_incorporation;
            $Company->date_of_commencement = $request->date_of_commencement;
            $Company->phone_no = $request->phone_no;
            $Company->fax = $request->fax;
            $Company->email = $request->email;
            $Company->website = $request->website;
            $Company->registration_No = $request->registration_No;
            $Company->company_description = $request->company_description;
            $Company->registration_details = $request->registration_details;
            $Company->list_index = $request->list_index;

            $Company->currentFishSerialNo = $request->currentFishSerialNo;
            $Company->minFishSerialNo = $request->minFishSerialNo;
            $Company->maxFishSerialNo = $request->maxFishSerialNo;

            $Company->enabled = $request->has('enabled');
            $Company->modified_By = Auth::user()->id;
            $save = $Company->save();

            if ($request->has('company_logo') && $save) {

                $const = '-logo';
                $imagename = $request->companyName . $const; //new image name
                $guessExtension = $request->file('company_logo')->guessExtension(); //file extention
                $file = $request->file('company_logo')->storeAs($request->companyName . '/img/logo/', $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/' . $request->companyName . '/img/logo/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Company::find($Company->id);
                $image->company_logo = $url;
                $image->save();
            }
            // $this->log_activity('createchildcompany', $Company->id, $this->getChangedArray($Company) );

            //   $changes=  $this->getChangedArray($Company);


            $responseBody = $this->responseBody(true, "update", "Company Updated", '');
        } catch (Exception $exception) {
            $responseBody = $this->responseBody(false, "update", $request->hiddnUserId, $exception->getMessage());
        }
        return response()->json(["data" => $responseBody]);
    }

    public function loadGroupCompanies()
    {
        try {
            $Company = Company::where('is_group', true)->get();

            return $this->responseBody(true, "loadGroupCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGroupCompanies", '', $ex->getMessage());
        }
    }
    public function loadCountries()
    {
        try {
            $Country = Country::where('enabled', true)->get();

            return $this->responseBody(true, "loadcountries", '', $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadcountries", '', $ex->getMessage());
        }
    }
    public function loadCurrency()
    {
        try {
            $Currency = Currency::where('enabled', true)->get();

            return $this->responseBody(true, "loadCurrency", '', $Currency);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrency", '', $ex->getMessage());
        }
    }
    public function loadDomains()
    {
        try {
            $Domain = Domain::where('enabled', true)->get();

            return $this->responseBody(true, "loadDomains", '', $Domain);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDomains", '', $ex->getMessage());
        }
    }
}
