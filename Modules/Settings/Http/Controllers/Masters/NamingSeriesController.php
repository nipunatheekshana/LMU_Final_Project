<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\NamingSeries;

class NamingSeriesController extends Controller
{
    use commonFeatures,nameingSeries;

    public function save(Request $request)
    {
        // $validatedData = $request->validate([
        //     'SupGroupCode' => ['required'],
        //     'SupGroupName' => ['required'],
        // ]);
        if(!$this->hasNumber($request->namingFormat)){
            $this->validationError('namingFormat','Naming Format Field Required a number');
        }
        try {
            $NamingSeries = new NamingSeries();
            $NamingSeries->function = $request->function;
            $NamingSeries->namingFormat = $request->namingFormat;
            $NamingSeries->currentValue = $request->currentValue;
            $NamingSeries->enabled = $request->has('enabled');
            $NamingSeries->created_by = Auth::user()->id;
            $save = $NamingSeries->save();



            if ($save) {
                return $this->responseBody(true, "save", "NamingSeries saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        // $validatedData = $request->validate([
        //     'SupGroupCode' => ['required'],
        //     'SupGroupName' => ['required'],
        // ]);
        if(!$this->hasNumber($request->namingFormat)){
            $this->validationError('namingFormat','Naming Format Field Required a number');
        }
        try {
            $NamingSeries = NamingSeries::find($request->id);
            $NamingSeries->function = $request->function;
            $NamingSeries->namingFormat = $request->namingFormat;
            $NamingSeries->currentValue = $request->currentValue;
            $NamingSeries->enabled = $request->has('enabled');
            $NamingSeries->modified_by = Auth::user()->id;
            $save = $NamingSeries->save();

            if ($save) {
                return $this->responseBody(true, "save", "NamingSeries saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadNamingSerieses()
    {
        try {
            $NamingSeries = NamingSeries::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadNamingSeriess", "found", $NamingSeries);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNamingSeriess", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $NamingSeries = NamingSeries::where('id', $id)->delete();
            return $this->responseBody(true, "User", "NamingSeries Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadNamingSeries($id)
    {
        try {
            $NamingSeries = NamingSeries::where('id', $id)->first();
            return $this->responseBody(true, "loadNamingSeries", "found", $NamingSeries);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadNamingSeries", "error", $exception->getMessage());
        }
    }
    public function loadParentGroups()
    {
        try {
            $NamingSeries = NamingSeries::where('isGroup',true)->get();

            return $this->responseBody(true, "loadParentGroups", '', $NamingSeries);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroups", '', $ex->getMessage());
        }
    }

}
