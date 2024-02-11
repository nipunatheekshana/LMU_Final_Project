<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\HsCode;
use Modules\Settings\Entities\Country;

class HsCodesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'HSCode' => ['required'],
        ]);
        if (HsCode::where('HSCode', $request->HSCode)->exists()) {
            $this->validationError('HSCode', 'HSCode Exists');
        }
        try {
            $HsCode = new HsCode();
            $HsCode->HSCode = $request->HSCode;
            $HsCode->country = $request->country;
            $HsCode->HS_Description = $request->HS_Description;
            $HsCode->list_index = $request->list_index;
            $HsCode->enabled = $request->has('enabled');
            $HsCode->created_by = Auth::user()->id;
            $save = $HsCode->save();



            if ($save) {
                return $this->responseBody(true, "save", "HsCode saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'HSCode' => ['required'],
        ]);

        $data = HsCode::where('HSCode', $request->HSCode);

        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('HSCode', 'HSCode Exists');
            }
        }
        try {
            $HsCode = HsCode::find($request->id);
            $HsCode->HSCode = $request->HSCode;
            $HsCode->country = $request->country;
            $HsCode->HS_Description = $request->HS_Description;
            $HsCode->list_index = $request->list_index;
            $HsCode->enabled = $request->has('enabled');
            $HsCode->modified_by = Auth::user()->id;
            $save = $HsCode->save();

            if ($save) {
                return $this->responseBody(true, "save", "HsCode saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadHsCodes()
    {
        try {
            // $HsCode = HsCode::orderBy('id','ASC')
            // ->get();
            $HsCode = DB::table('inventory_hs_codes')
                ->leftJoin('settings_countries', 'settings_countries.id', '=', 'inventory_hs_codes.country')
                ->select('inventory_hs_codes.*', 'settings_countries.country_name')
                ->orderBy('id', 'ASC')
                ->get();
            return $this->responseBody(true, "loadHsCodes", "found", $HsCode);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadHsCodes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $HsCode = HsCode::where('id', $id)->delete();
            return $this->responseBody(true, "User", "HsCode Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $HsCode = HsCode::where('id', $id)->first();
            return $this->responseBody(true, "User", "HsCode ", $HsCode);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadHsCode($id)
    {
        try {
            $HsCode = HsCode::where('id', $id)->first();
            return $this->responseBody(true, "loadHsCode", "found", $HsCode);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadHsCode", "error", $exception->getMessage());
        }
    }
    public function LoadCountries()
    {
        try {
            $Country = Country::where('enabled', true)->get();
            return $this->responseBody(true, "LoadCountries", "found", $Country);
        } catch (Exception $exception) {
            return $this->responseBody(false, "LoadCountries", "error", $exception->getMessage());
        }
    }
}
