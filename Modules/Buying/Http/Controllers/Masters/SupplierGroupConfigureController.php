<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Buying\Entities\SupplierGroup;

class SupplierGroupConfigureController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'SupGroupCode' => ['required'],
            'SupGroupName' => ['required'],
        ]);
        try {
            $SupplierGroup = new SupplierGroup();
            $SupplierGroup->SupGroupCode = $request->SupGroupCode;
            $SupplierGroup->SupGroupName = $request->SupGroupName;
            $SupplierGroup->ParentSupGroupID = $request->ParentSupGroupID;
            $SupplierGroup->list_index = $request->list_index;
            $SupplierGroup->isGroup = $request->has('isGroup');
            $SupplierGroup->enabled = $request->has('enabled');
            $SupplierGroup->created_by = Auth::user()->id;
            $save = $SupplierGroup->save();



            if ($save) {
                return $this->responseBody(true, "save", "SupplierGroup saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'SupGroupCode' => ['required'],
            'SupGroupName' => ['required'],
        ]);
        try {
            $SupplierGroup = SupplierGroup::find($request->id);
            $SupplierGroup->SupGroupCode = $request->SupGroupCode;
            $SupplierGroup->SupGroupName = $request->SupGroupName;
            $SupplierGroup->ParentSupGroupID = $request->ParentSupGroupID;
            $SupplierGroup->list_index = $request->list_index;
            $SupplierGroup->isGroup = $request->has('isGroup');
            $SupplierGroup->enabled = $request->has('enabled');
            $SupplierGroup->modified_by = Auth::user()->id;
            $save = $SupplierGroup->save();

            if ($save) {
                return $this->responseBody(true, "save", "SupplierGroup saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadsupplierGroups()
    {
        try {
            $SupplierGroup = SupplierGroup::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadsupplierGroups", "found", $SupplierGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadsupplierGroups", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $SupplierGroup = SupplierGroup::where('id', $id)->delete();
            return $this->responseBody(true, "User", "SupplierGroup Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadSupplierGroup($id)
    {
        try {
            $SupplierGroup = SupplierGroup::where('id', $id)->first();
            return $this->responseBody(true, "loadSupplierGroup", "found", $SupplierGroup);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadSupplierGroup", "error", $exception->getMessage());
        }
    }
    public function loadParentGroups()
    {
        try {
            $SupplierGroup = SupplierGroup::where('isGroup',true)->get();

            return $this->responseBody(true, "loadParentGroups", '', $SupplierGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroups", '', $ex->getMessage());
        }
    }

}
