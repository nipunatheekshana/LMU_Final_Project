<?php

namespace Modules\Mnu\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Mnu\Entities\ManufacturingSetting;
use Modules\Settings\Entities\Company;
use Illuminate\Support\Facades\DB;

class ManufacturingSettingController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'companyID' => ['required'],
        ]);
        try {
            $ManufacturingSetting = new ManufacturingSetting();
            $ManufacturingSetting->companyID = $request->companyID;
            $ManufacturingSetting->default_container_item_category = $request->default_container_item_category;
            $ManufacturingSetting->default_label_item_category = $request->default_label_item_category;
            $ManufacturingSetting->enabled = $request->has('enabled');
            $ManufacturingSetting->created_by = Auth::user()->id;
            $save = $ManufacturingSetting->save();



            if ($save) {
                return $this->responseBody(true, "save", "ManufacturingSetting saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'companyID' => ['required'],
        ]);
        try {
            $ManufacturingSetting = ManufacturingSetting::find($request->id);
            $ManufacturingSetting->companyID = $request->companyID;
            $ManufacturingSetting->default_container_item_category = $request->default_container_item_category;
            $ManufacturingSetting->default_label_item_category = $request->default_label_item_category;
            $ManufacturingSetting->enabled = $request->has('enabled');
            $ManufacturingSetting->modified_by = Auth::user()->id;
            $save = $ManufacturingSetting->save();

            if ($save) {
                return $this->responseBody(true, "save", "ManufacturingSetting saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadManufacturingSettings()
    {
        try {
            $ManufacturingSetting = DB::table('mnu_settings')
                ->leftjoin('settings_companies', 'mnu_settings.companyID', '=', 'settings_companies.id')
                ->select('mnu_settings.id', 'settings_companies.companyName')
                ->get();

            return $this->responseBody(true, "loadManufacturingSettings", "found", $ManufacturingSetting);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadManufacturingSettings", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ManufacturingSetting = ManufacturingSetting::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ManufacturingSetting Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadManufacturingSetting($id)
    {
        try {
            $ManufacturingSetting = ManufacturingSetting::where('id', $id)->first();
            return $this->responseBody(true, "loadManufacturingSetting", "found", $ManufacturingSetting);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadManufacturingSetting", "error", $exception->getMessage());
        }
    }
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled',true)->get();

            return $this->responseBody(true, "loadCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanies", '', $ex->getMessage());
        }
    }

}
