<?php

namespace Modules\HRM\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\HRM\Entities\Designation;

class DesignationsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'DesignationCode' => ['required'],
            'DesignationName' => ['required'],
        ]);
        try {
            $Designation = new Designation();
            $Designation->DesignationCode = $request->DesignationCode;
            $Designation->DesignationName = $request->DesignationName;
            $Designation->list_index = $request->list_index;
            $Designation->enabled = $request->has('enabled');
            $Designation->created_by = Auth::user()->id;
            $save = $Designation->save();



            if ($save) {
                return $this->responseBody(true, "save", "Designation saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'DesignationCode' => ['required'],
            'DesignationName' => ['required'],
        ]);
        try {
            $Designation = Designation::find($request->id);
            $Designation->DesignationCode = $request->DesignationCode;
            $Designation->DesignationName = $request->DesignationName;
            $Designation->list_index = $request->list_index;
            $Designation->enabled = $request->has('enabled');
            $Designation->modified_by = Auth::user()->id;
            $save = $Designation->save();

            if ($save) {
                return $this->responseBody(true, "save", "Designation saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDesignations()
    {
        try {
            $Designation = Designation::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadDesignations", "found", $Designation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDesignations", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Designation = Designation::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Designation Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Designation = Designation::where('id', $id)->first();
            return $this->responseBody(true, "User", "Designation ", $Designation);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadDesignation($id)
    {
        try {
            $Designation = Designation::where('id', $id)->first();
            return $this->responseBody(true, "loadDesignation", "found", $Designation);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDesignation", "error", $exception->getMessage());
        }
    }
    public function loadParentGroups()
    {
        try {
            $Designation = Designation::where('isGroup',true)->get();

            return $this->responseBody(true, "loadParentGroups", '', $Designation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroups", '', $ex->getMessage());
        }
    }

}
