<?php

namespace Modules\Assets\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Assets\Entities\AssetCategory;
use Modules\Settings\Entities\Company;

class AssetCategoryController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required'],
            'asset_category_name' => ['required'],
        ]);
        if(AssetCategory::where('company',$request->company)->where('asset_category_name',$request->asset_category_name)->exists()){
            $this->validationError('asset_category_name','asset category name exists');
        }
        if(AssetCategory::where('company',$request->company)->where('category_short_code',$request->category_short_code)->exists()){
            $this->validationError('category_short_code','asset short name exists');
        }
        try {
            $AssetCategory = new AssetCategory();
            $AssetCategory->company = $request->company;
            $AssetCategory->asset_category_name = $request->asset_category_name;
            $AssetCategory->category_short_code = $request->category_short_code;
            $AssetCategory->list_index = $request->list_index;
            $AssetCategory->enabled = $request->has('enabled');
            $AssetCategory->created_by = Auth::user()->id;
            $save = $AssetCategory->save();



            if ($save) {
                return $this->responseBody(true, "save", "AssetCategory saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required'],
            'asset_category_name' => ['required'],
        ]);
        $data1=AssetCategory::where('company',$request->company)->where('asset_category_name',$request->asset_category_name);
        $data2=AssetCategory::where('company',$request->company)->where('category_short_code',$request->category_short_code);

        if($data1->exists()){
            if($data1->first()->id!=$request->id){
                $this->validationError('asset_category_name','asset category name exists');
            }
        }
        if($data2->exists()){
            if($data2->first()->id!=$request->id){
                $this->validationError('category_short_code','asset short name exists');
            }
        }
        try {
            $AssetCategory = AssetCategory::find($request->id);
            $AssetCategory->company = $request->company;
            $AssetCategory->asset_category_name = $request->asset_category_name;
            $AssetCategory->category_short_code = $request->category_short_code;
            $AssetCategory->list_index = $request->list_index;
            $AssetCategory->enabled = $request->has('enabled');
            $AssetCategory->modified_by = Auth::user()->id;
            $save = $AssetCategory->save();

            if ($save) {
                return $this->responseBody(true, "save", "AssetCategory saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadAssetCategories()
    {
        try {
            $AssetCategory = AssetCategory::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadAssetCategories", "found", $AssetCategory);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAssetCategories", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $AssetCategory = AssetCategory::where('id', $id)->delete();
            return $this->responseBody(true, "User", "AssetCategory Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadAssetCategory($id)
    {
        try {
            $AssetCategory = AssetCategory::where('id', $id)->first();
            return $this->responseBody(true, "loadAssetCategory", "found", $AssetCategory);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadAssetCategory", "error", $exception->getMessage());
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
