<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Settings\Entities\Company;
use Modules\Sf\Entities\Boat;
use Modules\Sf\Entities\BoatHoldType;
use Modules\Sf\Entities\CompanyBoat;
use Modules\Sf\Entities\CompanyBoatHoldType;

class CompanyBoatsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'BoatId' => ['required'],

        ]);
        try {
            $CompanyBoat = new CompanyBoat();
            $CompanyBoat->CompanyID = $request->CompanyID;
            $CompanyBoat->BoatId = $request->BoatId;
            $CompanyBoat->hold_type = $request->hold_type;
            $CompanyBoat->hold_Comment = $request->hold_Comment;
            $CompanyBoat->list_index = $request->list_index;
            $CompanyBoat->on_hold = $request->has('on_hold');
            $CompanyBoat->enabled = $request->has('enabled');
            $CompanyBoat->created_by = Auth::user()->id;
            $save = $CompanyBoat->save();



            if ($save) {
                return $this->responseBody(true, "save", "CompanyBoat saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'BoatId' => ['required'],
        ]);
        try {
            $CompanyBoat = CompanyBoat::find($request->id);
            $CompanyBoat->CompanyID = $request->CompanyID;
            $CompanyBoat->BoatId = $request->BoatId;
            $CompanyBoat->hold_type = $request->hold_type;
            $CompanyBoat->hold_Comment = $request->hold_Comment;
            $CompanyBoat->list_index = $request->list_index;
            $CompanyBoat->on_hold = $request->has('on_hold');
            $CompanyBoat->enabled = $request->has('enabled');
            $CompanyBoat->modified_by = Auth::user()->id;
            $save = $CompanyBoat->save();

            if ($save) {
                return $this->responseBody(true, "save", "CompanyBoat saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCompanyBoats()
    {
        try {
            // $CompanyBoat = CompanyBoat::orderBy('id','ASC')
            // ->get();

            $CompanyBoat =DB::table('sf_company_boats')
                            ->leftJoin('settings_companies','settings_companies.id','=','sf_company_boats.CompanyID')
                            ->leftJoin('sf_boats','sf_boats.id','=','sf_company_boats.BoatId')
                            ->select('sf_company_boats.id','settings_companies.companyName','sf_boats.BoatName')

                            ->orderBy('id','ASC')
                            ->get();

            return $this->responseBody(true, "loadCompanyBoats", "found", $CompanyBoat);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanyBoats", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CompanyBoat = CompanyBoat::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CompanyBoat Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $CompanyBoat = CompanyBoat::where('id', $id)->first();
            return $this->responseBody(true, "User", "CompanyBoat ", $CompanyBoat);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCompanyBoat($id)
    {
        try {
            $CompanyBoat = CompanyBoat::where('id', $id)->first();
            return $this->responseBody(true, "loadCompanyBoat", "found", $CompanyBoat);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCompanyBoat", "error", $exception->getMessage());
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
    public function loadBoats()
    {
        try {
            $Boat = Boat::where('enabled',true)->get();

            return $this->responseBody(true, "loadBoats", '', $Boat);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBoats", '', $ex->getMessage());
        }
    }
    public function loadHoldTypes()
    {
        try {
            $BoatHoldType = BoatHoldType::where('enabled',true)->get();

            return $this->responseBody(true, "loadHoldTypes", '', $BoatHoldType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadHoldTypes", '', $ex->getMessage());
        }
    }

}
