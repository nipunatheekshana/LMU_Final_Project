<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\Brand;

class BrandsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => ['required'],
        ]);
        if(Brand::where('brand_name',$request->brand_name)->exists()){
            $this->validationError('brand_name','brand name Exists');
        }
        try {
            $Brand = new Brand();
            $Brand->brand_name = $request->brand_name;
            $Brand->description = $request->description;
            $Brand->list_index = $request->list_index;
            $Brand->enabled = $request->has('enabled');
            $Brand->created_by = Auth::user()->id;
            $save = $Brand->save();



            if ($save) {
                return $this->responseBody(true, "save", "Brand saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'brand_name' => ['required'],
        ]);
        $data=Brand::where('brand_name',$request->brand_name);
        if($data->exists()){
            if($data->first()->id!=$request->id){
                $this->validationError('brand_name','brand name Exists');
            }
        }
        try {
            $Brand = Brand::find($request->id);
            $Brand->brand_name = $request->brand_name;
            $Brand->description = $request->description;
            $Brand->list_index = $request->list_index;
            $Brand->enabled = $request->has('enabled');
            $Brand->modified_by = Auth::user()->id;
            $save = $Brand->save();

            if ($save) {
                return $this->responseBody(true, "save", "Brand saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBrands()
    {
        try {
            $Brand = Brand::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadBrands", "found", $Brand);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBrands", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Brand = Brand::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Brand Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBrand($id)
    {
        try {
            $Brand = Brand::where('id', $id)->first();
            return $this->responseBody(true, "loadBrand", "found", $Brand);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBrand", "error", $exception->getMessage());
        }
    }


}
