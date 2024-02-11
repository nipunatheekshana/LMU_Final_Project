<?php

namespace Modules\Selling\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Selling\Entities\CustomerGroup;

class CustomerGroupMasterController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CusGroupName' => ['required'],
        ]);
        try {
            $CustomerGroup = new CustomerGroup();
            $CustomerGroup->CusGroupName = $request->CusGroupName;
            $CustomerGroup->ParentCusGroupID = $request->ParentCusGroupID;
            $CustomerGroup->list_index = $request->list_index;
            $CustomerGroup->isGroup = $request->has('isGroup');
            $CustomerGroup->enabled = $request->has('enabled');
            $CustomerGroup->created_by = Auth::user()->id;
            $save = $CustomerGroup->save();



            if ($save) {
                return $this->responseBody(true, "save", "CustomerGroup saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CusGroupName' => ['required'],
        ]);
        try {
            $CustomerGroup = CustomerGroup::find($request->id);
            $CustomerGroup->CusGroupName = $request->CusGroupName;
            $CustomerGroup->ParentCusGroupID = $request->ParentCusGroupID;
            $CustomerGroup->list_index = $request->list_index;
            $CustomerGroup->isGroup = $request->has('isGroup');
            $CustomerGroup->enabled = $request->has('enabled');
            $CustomerGroup->modified_by = Auth::user()->id;
            $save = $CustomerGroup->save();

            if ($save) {
                return $this->responseBody(true, "save", "CustomerGroup saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCustomerGroups()
    {
        try {
            $CustomerGroup = CustomerGroup::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadCustomerGroups", "found", $CustomerGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerGroups", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CustomerGroup = CustomerGroup::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CustomerGroup Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadcustomerGroupMaster($id)
    {
        try {
            $CustomerGroup = CustomerGroup::where('id', $id)->first();
            return $this->responseBody(true, "User", "CustomerGroup ", $CustomerGroup);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadParentGroups()
    {
        try {
            $CustomerGroup = CustomerGroup::where('isGroup', true)->where('enabled', true)->get();

            return $this->responseBody(true, "loadParentGroup", '', $CustomerGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroup", '', $ex->getMessage());
        }
    }
}
