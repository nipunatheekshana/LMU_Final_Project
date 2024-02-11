<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\WarehouseType;

class warehouseTypeController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_type_name' => ['required'],
        ]);
        try {
            $WarehouseType = new WarehouseType();
            $WarehouseType->company_id = Auth::user()->company_id;
            $WarehouseType->warehouse_type_name = $request->warehouse_type_name;
            $WarehouseType->description = $request->description;
            $WarehouseType->created_by = Auth::user()->id;
            $save = $WarehouseType->save();



            if ($save) {
                return $this->responseBody(true, "save", "WarehouseType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_type_name' => ['required'],
        ]);
        try {
            $WarehouseType = WarehouseType::find($request->id);
            $WarehouseType->company_id = Auth::user()->company_id;
            $WarehouseType->warehouse_type_name = $request->warehouse_type_name;
            $WarehouseType->description = $request->description;
            $WarehouseType->modified_by = Auth::user()->id;
            $save = $WarehouseType->save();

            if ($save) {
                return $this->responseBody(true, "save", "WarehouseType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadWarehouseTypes()
    {
        try {
            $WarehouseType = WarehouseType::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadWarehouseTypes", "found", $WarehouseType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadWarehouseTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $WarehouseType = WarehouseType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "WarehouseType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadWarehouseType($id)
    {
        try {
            $WarehouseType = WarehouseType::where('id', $id)->first();
            return $this->responseBody(true, "loadWarehouseType", "found", $WarehouseType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadWarehouseType", "error", $exception->getMessage());
        }
    }
}
