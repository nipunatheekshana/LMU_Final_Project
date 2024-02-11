<?php

namespace Modules\Settings\Http\Controllers\CompanySetting;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Company;

class CompanyListController extends Controller
{
    use commonFeatures;
    public function loadCompanies()
    {
        try {
            $Company = Company::all();
            return $this->responseBody(true, "loadCompanies", "found", $Company);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCompanies", "Something went wrong", $exception->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = Company::where('id', $id)->first()->company_logo;
            if (file_exists($image)) {
                unlink($image);
            }

            $Company = Company::where('id', $id)->delete();
            return $this->responseBody(true, "Company", "Child company Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "Company", "Something went wrong", $exception->getMessage());
        }
    }
}
