<?php

namespace Modules\Mnu\Http\Controllers\API;

use App\Http\common\nameingSeries;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Mnu\Entities\PackingBox;
use Modules\Mnu\Entities\PickList;
use Modules\Mnu\Entities\PickListDetail;
use Modules\Mnu\Entities\WorkSheetDetail;

class pickListController extends Controller
{
    use nameingSeries;
    public function create_update_pick_list(Request $request)
    {
        try {
            if ($request->has('id')) {
                if (PickList::where('id', $request->id)->exists()) {
                    $PickList = PickList::find($request->id);
                } else {
                    return response([
                        'status' => 'id Not found',
                        'code' => 204,
                        'message' => "Picklist not found to update"
                    ], 204);
                }
            } else {
                $PickList = new PickList();
            }
            $PickList->company_id = $request->company_id;
            $PickList->picklist_no = $this->nameSeris('Pick List');
            if ($request->has('customer')) {
                $PickList->customer = $request->customer;
            }
            if ($request->has('purpose')) {
                $PickList->purpose = $request->purpose;
            }
            if ($request->has('remarks')) {
                $PickList->remarks = $request->remarks;
            }
            if ($request->has('warehouse')) {
                $PickList->warehouse = $request->warehouse;
            }
            if ($request->has('workstation')) {
                $PickList->workstation = $request->workstation;
            }
            if ($request->has('worksheet_id') && $request->has('worksheet_no')) {
                $PickList->worksheet_id = $request->worksheet_id;
                $PickList->worksheet_no = $request->worksheet_no;
            } elseif ($request->has('worksheet_id')) {
                $PickList->worksheet_id = $request->worksheet_id;
                $PickList->worksheet_no = WorkSheetDetail::where('id', $request->worksheet_id)->first('plID')->plID;
            } elseif ($request->has('worksheet_no')) {
                $PickList->worksheet_no = $request->worksheet_no;
                $PickList->worksheet_id = WorkSheetDetail::where('plID', $request->worksheet_no)->first('id')->id;
            }
            if ($request->has('material_request')) {
                $PickList->material_request = $request->material_request;
            }
            $save = $PickList->save();

            if ($save) {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Picklist Created"
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
    public function scan_add_remove_boxes(Request $request)
    {
        try {
            if (PackingBox::where('box_barcode', $request->box_barcode)->exists()) {
                if (PickList::where('id', $request->pick_list_hd_id)->exists()) {
                    if ($request->is_remove == 1) {
                        if (PickListDetail::where('barcode_serial_no', $request->barcode_serial_no)->exists()) {
                            PickList::where('barcode_serial_no', $request->barcode_serial_no)->delete();
                        } else {
                            return response([
                                'status' => 'Box Not found',
                                'code' => 204,
                                'message' => "Box is not in Picklist"
                            ], 204);
                        }
                    } else {
                        if (PickListDetail::where('barcode_serial_no', $request->barcode_serial_no)->exists()) {
                            return response([
                                'status' => 'found',
                                'code' => 409,
                                'message' => "Already Added to Picklist"
                            ], 409);
                        } else {
                            $PickListDetail = new PickListDetail();
                            $PickListDetail->pick_list_hd_id = $request->pick_list_hd_id;
                            $PickListDetail->barcode_serial_no = $request->box_barcode;
                            $PickListDetail->box_id = PackingBox::where('box_barcode', $request->box_barcode)->first('id')->id;
                            $PickListDetail->warehouse = PickList::where('id', $request->pick_list_hd_id)->first('warehouse')->warehouse;
                            $PickListDetail->workstation = PickList::where('id', $request->pick_list_hd_id)->first('workstation')->workstation;
                            $PickListDetail->item = PackingBox::where('box_barcode', $request->box_barcode)->first('prod_id')->prod_id;
                            $PickListDetail->item = PackingBox::where('box_barcode', $request->box_barcode)->first('customer_item_id')->customer_item_id;
                            $PickListDetail->picked_qty = 1;
                            $PickListDetail->created_by = $request->picked_user;
                            $save = $PickListDetail->save();

                            if ($save) {
                                return response([
                                    'status' => 'Success',
                                    'code' => 200,
                                    'message' => "Added to Picklist"
                                ], 200);
                            }
                        }
                    }
                } else {
                    return response([
                        'status' => 'Picklist Not found',
                        'code' => 204,
                        'message' => "Picklist Not Found"
                    ], 204);
                }
            } else {
                return response([
                    'status' => 'box_barcode Not found',
                    'code' => 204,
                    'message' => "Box Not Found"
                ], 204);
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
