<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Printer;
use Modules\Settings\Entities\Workstation;

class workstationsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'WorkstationName' => ['required'],
            'CompanyID' => ['required'],
        ]);
        try {
            $Workstation = new Workstation();
            $Workstation->CompanyID = $request->CompanyID;
            $Workstation->WorkstationName = $request->WorkstationName;
            $Workstation->WorkstationDescription = $request->WorkstationDescription;
            $Workstation->list_index = $request->list_index;
            $Workstation->default_printer = $request->default_printer;
            $Workstation->isInternal = $request->has('isInternal');
            $Workstation->is_waste_location = $request->has('is_waste_location');
            $Workstation->enabled = $request->has('enabled');
            $Workstation->created_by = Auth::user()->id;
            $save = $Workstation->save();



            if ($save) {
                return $this->responseBody(true, "save", "Workstation saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'WorkstationName' => ['required'],
            'CompanyID' => ['required'],
        ]);
        try {
            $Workstation = Workstation::find($request->id);
            $Workstation->CompanyID = $request->CompanyID;
            $Workstation->WorkstationName = $request->WorkstationName;
            $Workstation->WorkstationDescription = $request->WorkstationDescription;
            $Workstation->list_index = $request->list_index;
            $Workstation->default_printer = $request->default_printer;
            $Workstation->isInternal = $request->has('isInternal');
            $Workstation->is_waste_location = $request->has('is_waste_location');
            $Workstation->enabled = $request->has('enabled');
            $Workstation->modified_by = Auth::user()->id;
            $save = $Workstation->save();

            if ($save) {
                return $this->responseBody(true, "save", "Workstation saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadWorkstations()
    {
        try {
            $Workstation = Workstation::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadWorkstations", "found", $Workstation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadWorkstations", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Workstation = Workstation::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Workstation Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Workstation = Workstation::where('id', $id)->first();
            return $this->responseBody(true, "User", "Workstation ", $Workstation);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadWorkstation($id)
    {
        try {
            $Workstation = Workstation::where('id', $id)->first();
            return $this->responseBody(true, "loadWorkstation", "found", $Workstation);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadWorkstation", "error", $exception->getMessage());
        }
    }
    public function loadDropDownData()
    {
        try {
            $Company = Company::where('enabled',true)->select('id','companyName')->get();
            $Printer = Printer::where('enabled',true)->select('id','printer_name')->get();


            return $this->responseBody(true, "loadDropDownData", '', ['Company'=>$Company,'Printer'=>$Printer]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDropDownData", '', $ex->getMessage());
        }
    }

}
