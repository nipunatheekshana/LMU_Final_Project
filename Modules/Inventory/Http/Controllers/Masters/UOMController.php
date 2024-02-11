<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\UOM;

class UOMController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'UomName' => ['required'],
        ]);
        try {
            $UOM = new UOM();
            $UOM->UomName = $request->UomName;
            $UOM->list_index = $request->list_index;
            $UOM->enabled = $request->has('enabled');
            $UOM->created_by = Auth::user()->id;
            $save = $UOM->save();



            if ($save) {
                return $this->responseBody(true, "save", "UOM saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'UomName' => ['required'],
        ]);
        try {
            $UOM = UOM::find($request->id);
            $UOM->UomName = $request->UomName;
            $UOM->list_index = $request->list_index;
            $UOM->enabled = $request->has('enabled');
            $UOM->modified_by = Auth::user()->id;
            $save = $UOM->save();

            if ($save) {
                return $this->responseBody(true, "save", "UOM saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadUOMs()
    {
        try {
            $UOM = UOM::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadUOMs", "found", $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUOMs", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $UOM = UOM::where('id', $id)->delete();
            return $this->responseBody(true, "User", "UOM Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $UOM = UOM::where('id', $id)->first();
            return $this->responseBody(true, "User", "UOM ", $UOM);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadUOM($id)
    {
        try {
            $UOM = UOM::where('id', $id)->first();
            return $this->responseBody(true, "loadUOM", "found", $UOM);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadUOM", "error", $exception->getMessage());
        }
    }
 

}
