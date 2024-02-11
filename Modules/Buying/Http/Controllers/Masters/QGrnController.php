<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Buying\Entities\GrnTicket;
use Modules\Buying\Entities\QGrn;
use Modules\Buying\Entities\Supplier;
use Modules\Settings\Entities\Currency;
use Modules\Sf\Entities\Boat;
use Modules\Sf\Entities\CatchMethod;
use Modules\Sf\Entities\FishCoolingMethod;
use Modules\Sf\Entities\Landingsite;
use Modules\Sf\Http\Controllers\FishCoolingMethodsController;

class QGrnController extends Controller
{
    use commonFeatures, nameingSeries;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            // Add relevant validation fields here
            'qgrn_date' => ['required'],
            'qgrn_type' => ['required'],
            'supplier_id' => ['required'],
            // Add more validation fields as needed
        ]);
        try {
            $qgrn = new QGrn();
            $qgrn->company_id = Auth::user()->company_id;
            $qgrn->qgrn_no = $this->nameSeris('qGRN No');
            $qgrn->qgrn_date = $request->qgrn_date;
            $qgrn->qgrn_type = $request->qgrn_type;
            $qgrn->batch_no = $request->batch_no;
            $qgrn->supplier_id = $request->supplier_id;
            $qgrn->supplier_ticket_id = $request->supplier_ticket_id;
            $qgrn->supplier_vehicle_no = $request->supplier_vehicle_no;
            $qgrn->boat_id = $request->boat_id;
            $qgrn->boat_registration_number = $request->boat_registration_number;
            $qgrn->boat_licence_no = $request->boat_licence_no;
            $qgrn->boat_licence_exp_date = $request->boat_licence_exp_date;
            $qgrn->boat_skipper_name = $request->boat_skipper_name;
            $qgrn->boat_number_of_crew = $request->boat_number_of_crew;
            $qgrn->boat_number_of_tanks = $request->boat_number_of_tanks;
            $qgrn->boat_trip_start_date = $request->boat_trip_start_date;
            $qgrn->boat_trip_end_date = $request->boat_trip_end_date;
            $qgrn->boat_cooling_method = $request->boat_cooling_method;
            $qgrn->boat_fishing_method_id = $request->boat_fishing_method_id;
            $qgrn->boat_landing_site_id = $request->boat_landing_site_id;
            $qgrn->unload_status = $request->unload_status;
            $qgrn->unload_start_time = $request->unload_start_time;
            $qgrn->unload_end_time = $request->unload_end_time;
            $qgrn->unload_end_user_id = $request->unload_end_user_id;
            $qgrn->finance_status = $request->finance_status;
            $qgrn->voucher_status = $request->voucher_status;
            $qgrn->finance_close_time = $request->finance_close_time;
            $qgrn->finance_close_user_id = $request->finance_close_user_id;
            $qgrn->finance_currency_id_pay = $request->finance_currency_id_pay;
            $qgrn->finance_gross_value_pay = $request->finance_gross_value_pay;
            $qgrn->finance_currency_id_base = $request->finance_currency_id_base;
            $qgrn->finance_gross_value_base = $request->finance_gross_value_base;
            $qgrn->costing_export_income = $request->costing_export_income;
            $qgrn->costing_localsale_income = $request->costing_localsale_income;
            $qgrn->total_qty = $request->total_qty;
            $qgrn->total_fish_weight = $request->total_fish_weight;
            $qgrn->unprocessed_pcs = $request->unprocessed_pcs;
            $qgrn->processed_pcs = $request->processed_pcs;
            $qgrn->transfer_pcs = $request->transfer_pcs;
            $qgrn->reject_pcs = $request->reject_pcs;
            $qgrn->receive_hold_reason = $request->receive_hold_reason;
            $qgrn->finance_close_reason = $request->finance_close_reason;
            $qgrn->voucher_close_reason = $request->voucher_close_reason;
            $qgrn->created_by = Auth::user()->id;
            $save = $qgrn->save();



            if ($save) {
                return $this->responseBody(true, "save", "QGrn saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            // Add relevant validation fields here
            'qgrn_date' => ['required'],
            'qgrn_type' => ['required'],
            'supplier_id' => ['required'],
            // Add more validation fields as needed
        ]);
        try {
            $qgrn = QGrn::find($request->id);
            $qgrn->qgrn_date = $request->qgrn_date;
            $qgrn->qgrn_type = $request->qgrn_type;
            $qgrn->batch_no = $request->batch_no;
            $qgrn->supplier_id = $request->supplier_id;
            $qgrn->supplier_ticket_id = $request->supplier_ticket_id;
            $qgrn->supplier_vehicle_no = $request->supplier_vehicle_no;
            $qgrn->boat_id = $request->boat_id;
            $qgrn->boat_registration_number = $request->boat_registration_number;
            $qgrn->boat_licence_no = $request->boat_licence_no;
            $qgrn->boat_licence_exp_date = $request->boat_licence_exp_date;
            $qgrn->boat_skipper_name = $request->boat_skipper_name;
            $qgrn->boat_number_of_crew = $request->boat_number_of_crew;
            $qgrn->boat_number_of_tanks = $request->boat_number_of_tanks;
            $qgrn->boat_trip_start_date = $request->boat_trip_start_date;
            $qgrn->boat_trip_end_date = $request->boat_trip_end_date;
            $qgrn->boat_cooling_method = $request->boat_cooling_method;
            $qgrn->boat_fishing_method_id = $request->boat_fishing_method_id;
            $qgrn->boat_landing_site_id = $request->boat_landing_site_id;
            $qgrn->unload_status = $request->unload_status;
            $qgrn->unload_start_time = $request->unload_start_time;
            $qgrn->unload_end_time = $request->unload_end_time;
            $qgrn->unload_end_user_id = $request->unload_end_user_id;
            $qgrn->finance_status = $request->finance_status;
            $qgrn->voucher_status = $request->voucher_status;
            $qgrn->finance_close_time = $request->finance_close_time;
            $qgrn->finance_close_user_id = $request->finance_close_user_id;
            $qgrn->finance_currency_id_pay = $request->finance_currency_id_pay;
            $qgrn->finance_gross_value_pay = $request->finance_gross_value_pay;
            $qgrn->finance_currency_id_base = $request->finance_currency_id_base;
            $qgrn->finance_gross_value_base = $request->finance_gross_value_base;
            $qgrn->costing_export_income = $request->costing_export_income;
            $qgrn->costing_localsale_income = $request->costing_localsale_income;
            $qgrn->total_qty = $request->total_qty;
            $qgrn->total_fish_weight = $request->total_fish_weight;
            $qgrn->unprocessed_pcs = $request->unprocessed_pcs;
            $qgrn->processed_pcs = $request->processed_pcs;
            $qgrn->transfer_pcs = $request->transfer_pcs;
            $qgrn->reject_pcs = $request->reject_pcs;
            $qgrn->receive_hold_reason = $request->receive_hold_reason;
            $qgrn->finance_close_reason = $request->finance_close_reason;
            $qgrn->voucher_close_reason = $request->voucher_close_reason;
            $qgrn->modified_by = Auth::user()->id;
            $save = $qgrn->save();

            if ($save) {
                return $this->responseBody(true, "save", "QGrn saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadQGrns()
    {
        try {
            $QGrn = QGrn::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadQGrns", "found", $QGrn);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQGrns", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $QGrn = QGrn::where('id', $id)->delete();
            return $this->responseBody(true, "User", "QGrn Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadQGrn($id)
    {
        try {
            $QGrn = QGrn::where('id', $id)->first();
            return $this->responseBody(true, "loadQGrn", "found", $QGrn);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadQGrn", "error", $exception->getMessage());
        }
    }
    public function loadDropDownData()
    {
        try {
            $Supplier = Supplier::where('enabled', true)->select('id', 'supplier_name')->get();
            $GrnTicket = GrnTicket::select('id', 'ticket_no')->get();
            $Boat = Boat::where('enabled', true)->select('id', 'BoatName')->get();
            $FishCoolingMethod = FishCoolingMethod::where('enabled', true)->select('id', 'MethodName')->get();
            $CatchMethod = CatchMethod::where('enabled', true)->select('id', 'CatchMethodName')->get();
            $Landingsite = Landingsite::where('enabled', true)->select('id', 'LandingSiteName')->get();
            $User = User::select('id', 'name')->get();
            $Currency = Currency::where('enabled', true)->select('id', 'currency_name')->get();

            return $this->responseBody(true, "loadDropDownData", '', [
                'Supplier' => $Supplier,
                'GrnTicket' => $GrnTicket,
                'Boat' => $Boat,
                'FishCoolingMethod' => $FishCoolingMethod,
                'CatchMethod' => $CatchMethod,
                'Landingsite' => $Landingsite,
                'financeUser' => $User,
                'unloadUser' => $User,
                'payCurrency' => $Currency,
                'baseCurrency' => $Currency,

            ]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDropDownData", '', $ex->getMessage());
        }
    }
}
