<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\DeliveryNote;
use Modules\Inventory\Entities\DeliveryTrip;
use Modules\Selling\Entities\Customer;

class DeliveryTripController extends Controller

{
    use commonFeatures;

    public function save(Request $request)
    {
        // $validatedData = $request->validate([
        //     // 'DeliveryNoteName' => ['required'],
        //     // 'CompanyID' => ['required'],
        // ]);
        try {
            $DeliveryNote = new DeliveryNote();
            $DeliveryNote->company_id = Auth::user()->company_id;
            $DeliveryNote->delivery_note_no = $request->delivery_note_no;
            $DeliveryNote->delivery_trip_id = $request->delivery_trip_id;
            $DeliveryNote->customer = $request->customer;
            $DeliveryNote->date = $request->date;
            $DeliveryNote->total_qty = $request->total_qty;
            $DeliveryNote->total_gross_weight = $request->total_gross_weight;
            $DeliveryNote->created_by = Auth::user()->id;
            $save = $DeliveryNote->save();



            if ($save) {
                return $this->responseBody(true, "save", "DeliveryNote saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        // $validatedData = $request->validate([
        //     'DeliveryNoteName' => ['required'],
        //     'CompanyID' => ['required'],
        // ]);
        try {
            $DeliveryNote = DeliveryNote::find($request->id);
            $DeliveryNote->company_id = Auth::user()->company_id;
            $DeliveryNote->delivery_note_no = $request->delivery_note_no;
            $DeliveryNote->delivery_trip_id = $request->delivery_trip_id;
            $DeliveryNote->customer = $request->customer;
            $DeliveryNote->date = $request->date;
            $DeliveryNote->total_qty = $request->total_qty;
            $DeliveryNote->total_gross_weight = $request->total_gross_weight;
            $DeliveryNote->modified_by = Auth::user()->id;
            $save = $DeliveryNote->save();

            if ($save) {
                return $this->responseBody(true, "save", "DeliveryNote saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDeliveryNotes()
    {
        try {
            $DeliveryNote = DeliveryNote::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadDeliveryNotes", "found", $DeliveryNote);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDeliveryNotes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $DeliveryNote = DeliveryNote::where('id', $id)->delete();
            return $this->responseBody(true, "User", "DeliveryNote Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $DeliveryNote = DeliveryNote::where('id', $id)->first();
            return $this->responseBody(true, "User", "DeliveryNote ", $DeliveryNote);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadDeliveryNote($id)
    {
        try {
            $DeliveryNote = DeliveryNote::where('id', $id)->first();
            return $this->responseBody(true, "loadDeliveryNote", "found", $DeliveryNote);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDeliveryNote", "error", $exception->getMessage());
        }
    }
    public function loadDropDownData()
    {
        try {
            $DeliveryTrip = DB::table('inventory_delivery_trip')
            ->join('hrm_employees','hrm_employees.id','=','inventory_delivery_trip.driver')
            ->join('settings_vehicles','settings_vehicles.id','=','inventory_delivery_trip.vehicle')
            ->select('inventory_delivery_trip.id','hrm_employees.employee_name','settings_vehicles.license_plate')
            ->get();
            $Customer = Customer::select('CusName','id')->get();


            return $this->responseBody(
                true,
                "loadDeliveryNote",
                "found",
                [
                    'DeliveryTrip' => $DeliveryTrip,
                    'Customer'=>$Customer
                ]
            );
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDeliveryNote", "error", $exception->getMessage());
        }
    }
}
