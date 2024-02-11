<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\CompanySupplier;
use Modules\Buying\Entities\Supplier;
use Modules\Buying\Entities\SupplierHoldType;
use Modules\Settings\Entities\Company;

class CompanySuppliersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'SupplierID' => ['required'],


        ]);
        try {
            $CompanySupplier = new CompanySupplier();
            $CompanySupplier->CompanyID = $request->CompanyID;
            $CompanySupplier->SupplierID = $request->SupplierID;
            $CompanySupplier->hold_type = $request->hold_type;
            $CompanySupplier->hold_Comment = $request->hold_Comment;
            $CompanySupplier->list_index = $request->list_index;
            $CompanySupplier->on_hold = $request->has('on_hold');
            $CompanySupplier->is_sf_supplier = $request->has('is_sf_supplier');
            $CompanySupplier->enabled = $request->has('enabled');
            $CompanySupplier->created_by = Auth::user()->id;
            $save = $CompanySupplier->save();



            if ($save) {
                return $this->responseBody(true, "save", "CompanySupplier saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyID' => ['required'],
            'SupplierID' => ['required'],

        ]);
        try {
            $CompanySupplier = CompanySupplier::find($request->id);
            $CompanySupplier->CompanyID = $request->CompanyID;
            $CompanySupplier->SupplierID = $request->SupplierID;
            $CompanySupplier->hold_type = $request->hold_type;
            $CompanySupplier->hold_Comment = $request->hold_Comment;
            $CompanySupplier->list_index = $request->list_index;
            $CompanySupplier->on_hold = $request->has('on_hold');
            $CompanySupplier->is_sf_supplier = $request->has('is_sf_supplier');
            $CompanySupplier->enabled = $request->has('enabled');
            $CompanySupplier->modified_by = Auth::user()->id;
            $save = $CompanySupplier->save();

            if ($save) {
                return $this->responseBody(true, "save", "CompanySupplier saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCompanySuppliers()
    {
        try {
            // $CompanySupplier = CompanySupplier::orderBy('id','ASC')
            // ->get();

            $CompanySupplier = DB::table('buying_company_suppliers')
                                    ->leftJoin('settings_companies','settings_companies.id','=','buying_company_suppliers.CompanyID')
                                    ->leftJoin('buying_suppliers','buying_suppliers.id','=','buying_company_suppliers.SupplierID')
                                    ->select('buying_company_suppliers.id','settings_companies.companyName','buying_suppliers.supplier_name')
                                    ->get();

            return $this->responseBody(true, "loadCompanySuppliers", "found", $CompanySupplier);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanySuppliers", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CompanySupplier = CompanySupplier::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CompanySupplier Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $CompanySupplier = CompanySupplier::where('id', $id)->first();
            return $this->responseBody(true, "User", "CompanySupplier ", $CompanySupplier);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCompanySupplier($id)
    {
        try {
            $CompanySupplier = CompanySupplier::where('id', $id)->first();
            return $this->responseBody(true, "loadCompanySupplier", "found", $CompanySupplier);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCompanySupplier", "error", $exception->getMessage());
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
    public function loadSuppliers()
    {
        try {
            $Supplier = Supplier::where('enabled',true)->get();

            return $this->responseBody(true, "loadSuppliers", '', $Supplier);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSuppliers", '', $ex->getMessage());
        }
    }
    public function loadHoldTypes()
    {
        try {
            $SupplierHoldType = SupplierHoldType::where('enabled',true)->get();

            return $this->responseBody(true, "loadHoldTypes", '', $SupplierHoldType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadHoldTypes", '', $ex->getMessage());
        }
    }

}
