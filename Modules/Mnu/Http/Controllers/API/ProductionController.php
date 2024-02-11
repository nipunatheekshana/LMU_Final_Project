<?php

namespace Modules\Mnu\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\GRNDetail;
use Modules\Mnu\Entities\ProductionDetail;
use Modules\Mnu\Entities\WorkSheetDetail;
use Modules\Selling\Entities\Customer;
use Modules\Buying\Entities\GRN;
use DateTime;

class ProductionController extends Controller
{
    public function save_production_dtl(Request $request)
    {
        try {
            $validated = $request->validate([
                'PcsID' => 'required|unique:mnu_production_dtl',            // Same as id
                'pcs_barcode' => 'required|unique:mnu_production_dtl',      // Should Auto Generate
                'grn_dtl_lot_id' => 'required|integer',                     // Passed from Mobile - Fish ID
                'grn_lot_barcode' => 'required',                            // Passed from Mobile - Fish Barcode
                'pcs_no' => 'required|integer',                             // Should Auto Increase same as GRN Fish Serial No
                'pcs_weight' => 'required|numeric',                         // Passed from Mobile
                'scaler_weight' => 'required',                              // Passed from Mobile
                'production_mob_id' => 'required',                          // Passed from Mobile
                'production_mob_user' => 'required',                        // Passed from Mobile
                'trim_supervisor' => 'required',                            // Passed from Mobile
                'trimmer' => 'required',                                    // Passed from Mobile
                'ws_id' => 'required',                                      // Passed from Mobile
                'cust_product_id' => 'required',                            // ??? Need to Fix this. customer_item table
                'product_grade' => 'required',                              // Passed from Mobile
                'created_by' => 'required',                                 // Passed from Mobile

                // add other validation rules as needed
            ]);

            // Get PCS Related GRN Details
            $FishGRNDetails = GRNDetail::select()
                ->leftJoin('buying_fish_grn_hd', 'buying_fish_grn_hd.id', '=', 'buying_fish_grn_dtl.grn_id')
                ->where('buying_fish_grn_dtl.id', $validated['grn_dtl_lot_id'])
                ->first();

            // Get Worksheet Details
            $WorksheetDetails = WorkSheetDetail::select()
                ->where('id', $validated['ws_id'])
                ->first();

            // Get Customer's Max Fish Age
            $FishMaxAgeCustomer = Customer::where('id', $WorksheetDetails->customer)
                ->first('max_fish_age')
                ->max_fish_age;

            // Convert the Fish GRN Date to a DateTime object
            $fishGRNDate = new DateTime($FishGRNDetails->grndate);

            // Get the current date
            $currentDate = new DateTime();

            // Calculate Actual Fish Age Days
            $actualFishAge = $currentDate->diff($fishGRNDate)->days;

            // If Max Fish Age Exists & Exceed Max Fish Age Return
            if ($actualFishAge > (int)$FishMaxAgeCustomer) {
                return response([
                    'status' => 'Not Saved',
                    'code' => 400,
                    'message' => 'Fish Age is ' . (int)$actualFishAge . ' Days. Customer Limit is ' . (int)$FishMaxAgeCustomer . ' Days.'
                ], 400);
            }

            $fishProduct = new ProductionDetail();
            $fishProduct->PcsID = $validated['PcsID'];                              // Same as id
            $fishProduct->pcs_barcode = $validated['pcs_barcode'];                  // OK
            $fishProduct->grn_dtl_lot_id = $validated['grn_dtl_lot_id'];            // OK
            $fishProduct->lot_grn_no = $FishGRNDetails->grnno;                      // OK
            $fishProduct->grn_lot_barcode = 1;                                      // Should Auto Generate
            $fishProduct->fish_type_id = $FishGRNDetails->fish_type_id;             // OK
            $fishProduct->lot_serial_no = $FishGRNDetails->lot_serial_no;           // OK
            $fishProduct->pcs_no = 1;                                               // Should Auto Increase same as GRN Fish Serial No
            $fishProduct->pcs_weight = $validated['pcs_weight'];                    // OK
            $fishProduct->scaler_weight = $validated['scaler_weight'];              // OK
            $fishProduct->is_master_loin = 0;                                       // OK
            $fishProduct->pcs_status = 0;                                           // OK
            $fishProduct->pcs_yield_status = 0;                                     // OK
            $fishProduct->previous_pcs_status = 0;                                  // OK
            $fishProduct->status_datetime = NOW();                                  // OK
            $fishProduct->is_add_to_yield = 0;                                      // OK
            $fishProduct->production_datetime = NOW();                              // OK
            $fishProduct->production_mob_id = $validated['production_mob_id'];      // OK
            $fishProduct->production_mob_user = $validated['production_mob_user'];  // OK
            $fishProduct->trim_supervisor = $validated['trim_supervisor'];          // OK
            $fishProduct->trimmer = $validated['trimmer'];                          // OK
            $fishProduct->ws_id = $validated['ws_id'];                              // OK
            $fishProduct->prb_no = $WorksheetDetails->mainPlID;                     // OK
            // $fishProduct->master_product_id = 1;
            $fishProduct->cust_id = $WorksheetDetails->customer;                    // OK
            $fishProduct->cust_product_id = $validated['cust_product_id'];              // OK
            // $fishProduct->packed_datetime = 1;
            // $fishProduct->packing_supervisor = 1;
            // $fishProduct->packing_mob_user = 1;
            // $fishProduct->packer = 1;
            // $fishProduct->box_no = 1;
            $fishProduct->is_add_to_pl = 0;                                         // OK
            // $fishProduct->pl_no = 1;
            $fishProduct->is_invoiced = 0;                                          // OK
            // $fishProduct->inv_no = 1;
            // $fishProduct->unit_rate_inv = 1;
            // $fishProduct->unit_rate_Inv_base_currency = 1;
            // $fishProduct->unit_value_inv = 1;
            // $fishProduct->unit_value_Inv_base_currency = 1;
            // $fishProduct->reject_mode = 1;
            // $fishProduct->reject_reason_code = 1;
            // $fishProduct->reject_reason_desc = 1;
            // $fishProduct->reject_datetime = 1;
            // $fishProduct->reject_user = 1;
            // $fishProduct->transfer_user = 1;
            // $fishProduct->transfer_datetime = 1;
            // $fishProduct->tranfer_to_loc = 1;
            $fishProduct->is_process_hold = 0;                                      // OK
            // $fishProduct->process_hold_reason_code = 1;
            // $fishProduct->process_hold_desc = 1;
            // $fishProduct->parent_type = 1;
            // $fishProduct->parent_pcs_id = 1;
            $fishProduct->production_batch_no = $WorksheetDetails->mainPlID;        // OK
            $fishProduct->stock_out_st = 0;                                         // OK
            // $fishProduct->stock_out_date = 1;
            $fishProduct->print_status = 0;                                         // OK
            // $fishProduct->rm_unit_cost_local = 1;
            // $fishProduct->rm_unit_cost_base_currency = 1;
            // $fishProduct->master_loin_id = 1;
            $fishProduct->product_grade = $validated['product_grade'];              // OK
            $fishProduct->is_frozen_product = 0;                                    // OK
            // $fishProduct->frozen_pcs_status = 1;
            // $fishProduct->frozen_pack_datetime = 1;
            // $fishProduct->frozen_box_tag = 1;
            $fishProduct->lock_status = 0;                                          // OK
            // $fishProduct->qr_id = 1;
            $fishProduct->created_by = 1;                                           // OK
            // $fishProduct->modified_by = 1;
            // $fishProduct->created_at = NOW();
            // $fishProduct->updated_at = 1;

            $fishProduct->save();

            return response([
                'status' => 'success',
                'code' => 200,
                'message' => 'Production Saved'
            ], 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function change_production_status(Request $request)
    {
        try {
            $update = WorkSheetDetail::where('id', $request->id)->update(['prodStatus' => $request->prodStatus]);
            if ($update) {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Production Hold Success"
                ], 200);
            } else {
                return response([
                    'status' => 'Not Found',
                    'code' => 404,
                    'message' => "ID Not Found"
                ], 404);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function search_fish(Request $request)
    {
        try {
            $GRNDetail =  GRNDetail::select('*');

            if ($request->has('grn_no')) {
                $GRNDetail = $GRNDetail->where('lot_grnno', 'like', '%' . $request->grn_no . '%');
            }
            if ($request->has('weight_like') && $request->has('deviation')) {
                $GRNDetail = $GRNDetail->whereBetween('net_weight', [(int)$request->weight_like - (int)$request->deviation, (int)$request->weight_like + (int)$request->deviation]);
            }
            if ($request->has('fish_type')) {
                $GRNDetail = $GRNDetail->where('fish_type_id', $request->fish_type);
            }
            if ($request->has('fish_barcode')) {
                $GRNDetail = $GRNDetail->where('lot_barcode', $request->fish_barcode);
            }

            $GRNDetail = $GRNDetail->get();

            if ($GRNDetail->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Fish found'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Fish found',
                    'data' => $GRNDetail
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function search_pcs(Request $request)
    {
        try {
            $ProductionDetail =  ProductionDetail::select('*');

            if ($request->has('ws_no')) {
                $ProductionDetail = $ProductionDetail->where('ws_no', 'like', '%' . $request->ws_no . '%');
            }
            if ($request->has('weight_like') && $request->has('deviation')) {
                $ProductionDetail = $ProductionDetail->whereBetween('pcs_weight', [(int)$request->weight_like - (int)$request->deviation, (int)$request->weight_like + (int)$request->deviation]);
            }
            if ($request->has('fish_barcode')) {
                $ProductionDetail = $ProductionDetail->where('grn_lot_barcode', $request->fish_barcode);
            }
            if ($request->has('pcs_barcode')) {
                $ProductionDetail = $ProductionDetail->where('pcs_barcode', $request->pcs_barcode);
            }
            if ($request->has('customer')) {
                $ProductionDetail = $ProductionDetail->where('cust_id', $request->customer);
            }
            if ($request->has('cust_product_id')) {
                $ProductionDetail = $ProductionDetail->where('cust_product_id', $request->cust_product_id);
            }
            if ($request->has('master_product_id')) {
                $ProductionDetail = $ProductionDetail->where('master_product_id', $request->master_product_id);
            }

            $ProductionDetail = $ProductionDetail->get();

            if ($ProductionDetail->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Pcs found'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Pcs found',
                    'data' => $ProductionDetail
                ], 200);
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
