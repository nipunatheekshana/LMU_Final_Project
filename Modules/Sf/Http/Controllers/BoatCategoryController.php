<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\BoatCategory;

class BoatCategoryController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'BoatCatName' => ['required'],

        ]);
        try {
            $BoatCategory = new BoatCategory();
            $BoatCategory->BoatCategory = $request->BoatCategory;
            $BoatCategory->BoatCatName = $request->BoatCatName;
            $BoatCategory->BoatCateDescription = $request->BoatCateDescription;
            $BoatCategory->list_index = $request->list_index;
            $BoatCategory->LicenseRequired = $request->has('LicenseRequired');
            $BoatCategory->LogSheetRequired = $request->has('LogSheetRequired');
            $BoatCategory->enabled = $request->has('enabled');

            $BoatCategory->created_by = Auth::user()->id;
            $save = $BoatCategory->save();



            if ($save) {
                return $this->responseBody(true, "save", "BoatCategory saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'BoatCatName' => ['required'],
        ]);
        try {
            $BoatCategory = BoatCategory::find($request->id);
            $BoatCategory->BoatCategory = $request->BoatCategory;
            $BoatCategory->BoatCatName = $request->BoatCatName;
            $BoatCategory->BoatCateDescription = $request->BoatCateDescription;
            $BoatCategory->list_index = $request->list_index;
            $BoatCategory->LicenseRequired = $request->has('LicenseRequired');
            $BoatCategory->LogSheetRequired = $request->has('LogSheetRequired');
            $BoatCategory->enabled = $request->has('enabled');

            $BoatCategory->modified_by = Auth::user()->id;
            $save = $BoatCategory->save();

            if ($save) {
                return $this->responseBody(true, "save", "BoatCategory saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadboatCategories()
    {
        try {
            $BoatCategory = BoatCategory::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadboatCategories", "found", $BoatCategory);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadboatCategories", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $BoatCategory = BoatCategory::where('id', $id)->delete();
            return $this->responseBody(true, "User", "BoatCategory Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $BoatCategory = BoatCategory::where('id', $id)->first();
            return $this->responseBody(true, "User", "BoatCategory ", $BoatCategory);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadBoatCategory($id)
    {
        try {
            $BoatCategory = BoatCategory::where('id', $id)->first();
            return $this->responseBody(true, "loadBoatCategory", "found", $BoatCategory);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBoatCategory", "error", $exception->getMessage());
        }
    }


}
