<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\Printer;
use Modules\Settings\Entities\Workstation;

class PrintersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'printer_name' => ['required'],
            'printer_port' => ['required'],
            'model' => ['required'],
            'WorkstationID' => ['required'],
        ]);
        if (Printer::where('printer_name', $request->printer_name)->exists()) {
            $this->validationError('printer_name', 'printer name Exists');
        }
        if (Printer::where('printer_id', $request->printer_id)->exists()) {
            $this->validationError('printer_id', 'printer id Exists');
        }
        if (Printer::where('printer_port', $request->printer_port)->exists()) {
            $this->validationError('printer_port', 'printer port in use');
        }
        try {
            $Printer = new Printer();
            $Printer->printer_name = $request->printer_name;
            $Printer->printer_port = $request->printer_port;
            $Printer->printer_id = $request->printer_id;
            $Printer->model = $request->model;
            $Printer->WorkstationID = $request->WorkstationID;
            $Printer->enabled = $request->has('enabled');
            $Printer->created_by = Auth::user()->id;
            $save = $Printer->save();



            if ($save) {
                return $this->responseBody(true, "save", "Printer saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'printer_name' => ['required'],
            'printer_port' => ['required'],
            'model' => ['required'],
            'WorkstationID' => ['required'],
        ]);
        $data = Printer::where('printer_name', $request->printer_name);
        $data1 = Printer::where('printer_id', $request->printer_id);
        $data2 = Printer::where('printer_port', $request->printer_port);

        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('printer_name', 'printer name Exists');

            }
        }
        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('printer_id', 'printer id Exists');

            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('printer_port', 'printer port in use');

            }
        }
        try {
            $Printer = Printer::find($request->id);
            $Printer->printer_name = $request->printer_name;
            $Printer->printer_port = $request->printer_port;
            $Printer->model = $request->model;
            $Printer->printer_id = $request->printer_id;
            $Printer->WorkstationID = $request->WorkstationID;
            $Printer->enabled = $request->has('enabled');
            $Printer->modified_by = Auth::user()->id;
            $save = $Printer->save();

            if ($save) {
                return $this->responseBody(true, "save", "Printer saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadPrinters()
    {
        try {
            $Printer = Printer::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadPrinters", "found", $Printer);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPrinters", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Printer = Printer::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Printer Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadPrinter($id)
    {
        try {
            $Printer = Printer::where('id', $id)->first();
            return $this->responseBody(true, "loadPrinter", "found", $Printer);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadPrinter", "error", $exception->getMessage());
        }
    }
    public function loadWorkstations()
    {
        try {
            $Workstation = Workstation::where('enabled',true)->select('id','WorkstationName')->get();

            return $this->responseBody(true, "loadWorkstations", '', $Workstation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadWorkstations", '', $ex->getMessage());
        }
    }
}
