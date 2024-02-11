<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Buying\Entities\SupplierHoldType;

class SupplierHoldTypesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'HoldTypeName' => ['required'],
        ]);
        try {
            $SupplierHoldType = new SupplierHoldType();
            $SupplierHoldType->HoldTypeName = $request->HoldTypeName;
            $SupplierHoldType->list_index = $request->list_index;
            $SupplierHoldType->enabled = $request->has('enabled');
            $SupplierHoldType->created_by = Auth::user()->id;
            $save = $SupplierHoldType->save();



            if ($save) {
                return $this->responseBody(true, "save", "SupplierHoldType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'HoldTypeName' => ['required'],
        ]);
        try {
            $SupplierHoldType = SupplierHoldType::find($request->id);
            $SupplierHoldType->HoldTypeName = $request->HoldTypeName;
            $SupplierHoldType->list_index = $request->list_index;
            $SupplierHoldType->enabled = $request->has('enabled');
            $SupplierHoldType->modified_by = Auth::user()->id;
            $save = $SupplierHoldType->save();

            if ($save) {
                return $this->responseBody(true, "save", "SupplierHoldType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadSupplierHoldTypes()
    {
        try {
            $SupplierHoldType = SupplierHoldType::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadSupplierHoldTypes", "found", $SupplierHoldType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSupplierHoldTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $SupplierHoldType = SupplierHoldType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "SupplierHoldType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $SupplierHoldType = SupplierHoldType::where('id', $id)->first();
            return $this->responseBody(true, "User", "SupplierHoldType ", $SupplierHoldType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadSupplierHoldType($id)
    {
        try {
            $SupplierHoldType = SupplierHoldType::where('id', $id)->first();
            return $this->responseBody(true, "loadSupplierHoldType", "found", $SupplierHoldType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadSupplierHoldType", "error", $exception->getMessage());
        }
    }


}
