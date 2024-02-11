<?php

namespace Modules\Mnu\Http\Controllers\API;

use App\Http\common\activityLog;
use App\Http\common\nameingSeries;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\DeliveryNote;
use Modules\Inventory\Entities\DeliveryTrip;
use Modules\Mnu\Entities\PackingBox;
use Modules\Settings\Entities\Driver;
use Modules\Settings\Entities\Vehicle;

class distributionController extends Controller
{
    use nameingSeries, activityLog;
    public function get_vehicles(Request $request)
    {
        try {
            $query =  Vehicle::where('company_id', $request->company_id)->where('enabled', $request->enabled);


            if ($request->has('id')) {
                $query->where('id', $request->id);
            }

            $result = $query->get();
            $count = $result->count();

            if ($count == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Vehicle Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Vehicle(s) Found',
                    'data' => $result,
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function get_drivers(Request $request)
    {
        try {
            $query =  Driver::where('company_id', $request->company_id)->where('enabled', $request->enabled);


            if ($request->has('id')) {
                $query->where('id', $request->id);
            }

            $result = $query->get();
            $count = $result->count();

            if ($count == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Driver Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Driver(s) Found',
                    'data' => $result,
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function get_delivery_trips(Request $request)
    {
        try {
            $query =  DeliveryTrip::where('company_id', $request->company_id);

            if ($request->has('depature_date_from')) {
                $query->whereBetween('estimated_arrival_date_time', [$request->depature_date_from, $request->depature_date_to]);
            }

            if ($request->has('driver')) {
                $query->where('driver', $request->driver);
            }
            if ($request->has('vehicle')) {
                $query->where('vehicle', $request->vehicle);
            }
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            if ($request->has('id')) {
                $query->where('id', $request->id);
            }

            $result = $query->get();
            $count = $result->count();

            if ($count == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Delivery Trip Found',
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'DeliveryTrip(s) Found',
                    'data' => $result,
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function load_box(Request $request)
    {
        try {
            $query =  PackingBox::where('id', $request->boxid)
                ->where('box_barcode', $request->box_barcode)
                ->where('delivery_trip_id', $request->delivery_trip_id)
                ->where('loaded_user_id', $request->delivery_trip_id);

            if ($query->where('is_loaded', true)->exists()) {
                return response([
                    'status' => 'Alredy Loaded',
                    'code' => 204,
                    'message' => 'Already loaded to Delivery Trip No :' . $query->first('delivery_trip_id')->delivery_trip_id,
                ], 204);
            } else {
                $query->update([
                    'is_loaded' => true,
                    'loaded_datetime' => Carbon::now()->toDateTimeString(),
                ]);
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Box loaded Successfully Found',
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function unload_all_boxes(Request $request)
    {
        try {
            $query =  PackingBox::where('delivery_trip_id', $request->delivery_trip_id)->update(['is_loaded', false]);



            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'Boxes Unloaded Successfully Found',
            ], 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function close_loading(Request $request)
    {
        DB::beginTransaction();
        try {

            $result = DB::table('mnu_packing_box_hd')->where('delivery_trip_id', $request->delivery_trip_id)
                ->join('mnu_ws_plan_dtl', 'mnu_ws_plan_dtl.id', '=', 'mnu_packing_box_hd.ws_id')
                ->select([
                    'mnu_ws_plan_dtl.customer',
                    DB::raw('COUNT(mnu_packing_box_hd.id) AS total_qty'),
                    DB::raw("SUM( mnu_packing_box_hd.box_gross_weight ) AS total_gross_weight"),
                    DB::raw('GROUP_CONCAT(mnu_packing_box_hd.id) AS ids') // add this line to get the ids of the grouped rows
                ])
                ->groupBy('mnu_ws_plan_dtl.customer')
                ->get();
            foreach ($result as $data) {
                $DeliveryNote = new DeliveryNote();
                $DeliveryNote->company_id = Auth::user()->company_id;
                $DeliveryNote->delivery_note_no = $this->nameSeris('Delivery note');
                $DeliveryNote->delivery_trip_id = $request->delivery_trip_id;
                $DeliveryNote->customer = $data->customer;
                $DeliveryNote->date = Carbon::now()->toDateString();
                $DeliveryNote->total_qty = $data->total_qty;
                $DeliveryNote->total_gross_weight = $data->total_gross_weight;
                $DeliveryNote->created_by = Auth::user()->id;
                $save = $DeliveryNote->save();
                if ($save) {
                    // return explode(',', $data->ids);
                    foreach (explode(',', $data->ids) as $id) {
                        $PackingBox = PackingBox::find($id);
                        $PackingBox->delivery_note_id = $DeliveryNote->id;
                        $PackingBox->save();
                    }
                }
            }
            DeliveryTrip::where('id', $request->delivery_trip_id)->update(['status' => 1]);


            DB::commit();


            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'Box loaded Successfully Found',
            ], 200);
        } catch (Exception $ex) {
            DB::rollback();
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function unload_box(Request $request)
    {
        DB::beginTransaction();

        try {
            $query = '';


            if ($request->has('boxid')) {
                $query =  PackingBox::where('id', $request->boxid);
            }
            if ($request->has('box_barcode')) {
                $query =  PackingBox::where('box_barcode', $request->box_barcode);
            }
            if ($query->first('is_loaded')->is_loaded == 0) {
                return response([
                    'status' => 'Not loaded',
                    'code' => 500,
                    'message' => 'Cannot Unload. Not Loaded to Delivery Trip yet ',
                ], 500);
            }
            $ids = $query->select('id', 'delivery_trip_id')->first();

            $query = $query->update([
                'is_loaded' => false,
                'loaded_datetime' => null,
                'loaded_user_id' => null,
                'delivery_trip_id' => null,
                'delivery_note_id' => null,

            ]);


            $this->logActivity('fa fa-up', 'success', "Unloaded from Delivery Trip $ids->delivery_trip_id", 'packingBox', $ids->id);
            DB::commit();

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'Box unloaded successfully ',
            ], 200);
        } catch (Exception $ex) {
            DB::rollback();

            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function save_update_delivery_trip_header(Request $request)
    {
        DB::beginTransaction();

        try {
            // return $request->all();
            $msg = '';
            if ($request->has('id')) {
                $query =  DeliveryTrip::find('id', $request->id);
                $msg = 'Delivery trip updated';
            } else {
                $query = new  DeliveryTrip();
                $msg = 'Delivery trip created';
            }
            $query->company_id = $request->companyId;
            $query->driver = $request->driver;
            $query->vehicle = $request->vehicle;
            $query->estimated_depature_date_time = $request->estimated_depature_date_time;
            $query->estimated_arrival_date_time = $request->estimated_arrival_date_time;
            $query->delivery_location_address = $request->delivery_location_address;
            $query->status = $request->status;
            $query->save();

            DB::commit();

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => $msg,
            ], 200);
        } catch (Exception $ex) {
            DB::rollback();

            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
}
