<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\UOM;
use Modules\Inventory\Entities\UOMConversionFactor;

class UOMConversionFactorsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'uom_category' => ['required'],
            'uom_from' => ['required'],
            'uom_to' => ['required'],
            'factor' => ['required'],
        ]);
        if(UOMConversionFactor::where('uom_from',$request->uom_from)->where('uom_to',$request->uom_to)->exists()){
            $this->validationError('uom_to','Combination alredy Exists');
        }
        if($request->uom_from== $request->uom_to){
            $this->validationError('uom_to','Select a Deferent Combination');
        }
        try {
            $UOMConversionFactor = new UOMConversionFactor();
            $UOMConversionFactor->uom_category = $request->uom_category;
            $UOMConversionFactor->uom_from = $request->uom_from;
            $UOMConversionFactor->uom_to = $request->uom_to;
            $UOMConversionFactor->factor = $request->factor;
            $UOMConversionFactor->enabled = $request->has('enabled');
            $UOMConversionFactor->created_by = Auth::user()->id;
            $save = $UOMConversionFactor->save();



            if ($save) {
                return $this->responseBody(true, "save", "UOMConversionFactor saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'uom_category' => ['required'],
            'uom_from' => ['required'],
            'uom_to' => ['required'],
            'factor' => ['required'],
        ]);
        $data=UOMConversionFactor::where('uom_from',$request->uom_from)->where('uom_to',$request->uom_to);
        if($data->exists()){
            if($data->first()->id!=$request->id){
                $this->validationError('uom_to','Combination alredy Exists');
            }
        }
        if($request->uom_from== $request->uom_to){
            $this->validationError('uom_to','Select a Deferent Combination');
        }
        try {
            $UOMConversionFactor = UOMConversionFactor::find($request->id);
            $UOMConversionFactor->uom_category = $request->uom_category;
            $UOMConversionFactor->uom_from = $request->uom_from;
            $UOMConversionFactor->uom_to = $request->uom_to;
            $UOMConversionFactor->factor = $request->factor;
            $UOMConversionFactor->enabled = $request->has('enabled');
            $UOMConversionFactor->modified_by = Auth::user()->id;
            $save = $UOMConversionFactor->save();

            if ($save) {
                return $this->responseBody(true, "save", "UOMConversionFactor saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadUOMConversionFactors()
    {
        try {
            $UOMConversionFactor = UOMConversionFactor::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadUOMConversionFactors", "found", $UOMConversionFactor);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUOMConversionFactors", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $UOMConversionFactor = UOMConversionFactor::where('id', $id)->delete();
            return $this->responseBody(true, "User", "UOMConversionFactor Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadUOMConversionFactor($id)
    {
        try {
            $UOMConversionFactor = UOMConversionFactor::where('id', $id)->first();
            return $this->responseBody(true, "loadUOMConversionFactor", "found", $UOMConversionFactor);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadUOMConversionFactor", "error", $exception->getMessage());
        }
    }
    public function loadUOM()
    {
        try {
            $UOM = UOM::where('enabled',true)->get();

            return $this->responseBody(true, "loadUOM", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUOM", '', $ex->getMessage());
        }
    }

}
