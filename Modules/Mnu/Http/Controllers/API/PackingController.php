<?php

namespace Modules\Mnu\Http\Controllers\API;

use App\Http\common\activityLog;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Mnu\Entities\PackingBox;
use Modules\Mnu\Entities\ProductionDetail;

class PackingController extends Controller
{
    use activityLog;
    public function get_box_details_by_scan(Request $request)
    {
        try {
            $PackingBox =  PackingBox::where('box_barcode', $request->box_barcode)->first();
            if ($PackingBox) {
                $PackingBox =  $PackingBox->toArray();
                $ProductionDetail =  ProductionDetail::where('box_id', $PackingBox['id'])->get();
                if ($ProductionDetail) {
                    $ProductionDetail = $ProductionDetail->toArray();
                    $PackingBox['box_pcs'] = $ProductionDetail;
                }
            }


            if (count($PackingBox) == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Box found'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Box found',
                    'data' => $PackingBox
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
    public function finish_box(Request $request)
    {
        try {
            $PackingBox = PackingBox::where('id', $request->id)->update([
                'box_status' => 1,
                'box_gross_weight' => $request->box_gross_weight,
                'modified_by' => Auth::user()->id,
            ]);


            if ($PackingBox) {
                $this->logActivity('fa fa-times-circle', 'success', "Gross Weight Update to  $request->box_gross_weight", 'packingBox', $request->id);
                $this->logActivity('fa fa-check-square-o', 'success', 'Closed', 'packingBox', $request->id);

                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Box Close Success"
                ], 200);
            } else {
                return response([
                    'status' => 'Not Found',
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
    public function get_box_details(Request $request)
    {
        try {
            $PackingBox =  PackingBox::where('box_barcode', $request->box_barcode)->first();
            if ($PackingBox) {
                $PackingBox =  $PackingBox->toArray();
                $ProductionDetail =  ProductionDetail::where('box_id', $PackingBox['id'])->get();
                if ($ProductionDetail) {
                    $ProductionDetail = $ProductionDetail->toArray();
                    $PackingBox['box_pcs'] = $ProductionDetail;
                }
            }


            if (count($PackingBox) == 0) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No Box found'
                ], 204);
            } else {
                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => 'Box found',
                    'data' => $PackingBox
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
    public function reweigh_box(Request $request)
    {
        try {
            $PackingBox = PackingBox::where('id', $request->id);
            if ($PackingBox = PackingBox::where('id', $request->id)->first('is_add_to_gpl')->is_add_to_gpl) {
                return response([
                    'status' => 'Error',
                    'code' => 500,
                    'message' => 'Already added to GPL. Cannot Change Gross Weight'
                ], 500);
            } else {
                $PackingBox->update([
                    'box_gross_weight' => $request->box_gross_weight,
                    'modified_by' => Auth::user()->id,
                ]);
                if ($PackingBox) {
                    $this->logActivity('fa fa-times-circle', 'success', "Gross Weight Update to  $request->box_gross_weight", 'packingBox', $request->id);

                    return response([
                        'status' => 'Success',
                        'code' => 200,
                        'message' => "Box Reweigh Success"
                    ], 200);
                } else {
                    return response([
                        'status' => 'Not Found',
                        'code' => 204,
                        'message' => "Box Not Found"
                    ], 204);
                }
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function entire_box_unpack(Request $request)
    {
        try {
            $result = $this->BoxUnpackValidate($request);
            if ($result === true) {
                $PackingBox = '';
                if ($request->has('id')) {
                    $PackingBox = PackingBox::where('id', $request->id);
                } elseif ($request->has('box_barcode')) {
                    $PackingBox = PackingBox::where('box_barcode', $request->box_barcode);
                }
                $id = $PackingBox->first('id')->id;
                $ws_id = $PackingBox->first('ws_id')->ws_id;
                $box_no = $PackingBox->first('box_no')->box_no;


                $PackingBox->update([
                    'noofpcs' => 0,
                    'box_gross_weight' => 0,
                    'box_net_weight' => 0,
                    'box_status' => 0,
                ]);
                $this->logActivity('fa fa-th', 'danger', "Complete Box Unpacked", 'packingBox', $id);


                $ProductionDetail =   ProductionDetail::where('box_id', $request->id);
                $ProductionDetailId = $ProductionDetail->first('id')->id;

                $ProductionDetail->update([
                    'packed_datetime' => null,
                    'packing_supervisor' => null,
                    'packing_mob_user' => null,
                    'packer' => null,
                    'box_id' => null,
                ]);

                $this->logActivity('fa fa-th', 'danger', "Removed from Box No $box_no on Worksheet $ws_id", 'productionDtl', $ProductionDetailId);

                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Entire Box Unpacked"
                ], 200);
            } else {
                return $result;
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function box_pcs_unpack(Request $request)
    {
        try {
            $result = $this->BoxUnpackValidate($request);
            if ($result === true) {
                $PackingBox = '';
                if ($request->has('id')) {
                    $PackingBox = PackingBox::where('id', $request->id);
                } elseif ($request->has('box_barcode')) {
                    $PackingBox = PackingBox::where('box_barcode', $request->box_barcode);
                }
                // $noofpcs = $PackingBox->first('noofpcs')->noofpcs;
                $ws_id = $PackingBox->first('ws_id')->ws_id;
                $box_no = $PackingBox->first('box_no')->box_no;


                $PackingBox->update([
                    'noofpcs' => (int)$PackingBox->first('noofpcs')->noofpcs - 1,
                    'box_gross_weight' => null,
                    'box_net_weight' => (int)$PackingBox->first('box_net_weight')->box_net_weight - (int)ProductionDetail::where('id', $request->pcs_id)->first('pcs_weight')->pcs_weight,
                ]);


                $ProductionDetail =   ProductionDetail::where('id', $request->pcs_id);
                $ProductionDetailId = $ProductionDetail->first('id')->id;

                $ProductionDetail->update([
                    'packed_datetime' => null,
                    'packing_supervisor' => null,
                    'packing_mob_user' => null,
                    'packer' => null,
                    'box_no' => null,
                ]);

                $this->logActivity('fa fa-th', 'danger', "Removed from Box No $box_no on Worksheet $ws_id", 'productionDtl', $ProductionDetailId);

                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Pcs Unpacked from Box"
                ], 200);
            } else {
                return $result;
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function change_box_no(Request $request)
    {
        try {
            $result = $this->BoxUnpackValidate($request);
            if ($result === true) {

                $ToboxId = PackingBox::where('box_no', $request->to_box_no)->first('id')->id;
                PackingBox::where('box_no', $request->to_box_no)->update([
                    'box_no' => $request->from_box_no,
                ]);
                PackingBox::where('id', $request->id)->update([
                    'box_no' => $request->to_box_no,
                ]);

                $this->logActivity('fa fa-retweet', 'warning', "Box Number Changed from $request->from_box_no to $request->to_box_no", 'packingBox', $request->id);
                $this->logActivity('fa fa-retweet', 'warning', "Box Number Changed from $request->to_box_no to $request->from_box_no", 'packingBox', $ToboxId);

                return response([
                    'status' => 'Success',
                    'code' => 200,
                    'message' => "Box Number Changed/Exchanged"
                ], 200);
            } else {
                return $result;
            }
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    private function BoxUnpackValidate(Request $request)
    {
        $result = true;
        $PackingBox = PackingBox::select([
            'box_status',
            'is_add_to_gpl',
            'gpl_no',
            'is_invoiced',
            'inv_id'
        ]);

        if ($request->has('id')) {
            $PackingBox = $PackingBox->where('id', $request->id);
        } elseif ($request->has('box_barcode')) {
            $PackingBox = $PackingBox->where('box_barcode', $request->box_barcode);
        } else {
            $result = 'incompleate Request';
        }
        if ($PackingBox->exists()) {
            if ($PackingBox->first()->box_status != 0) {
                $result = 'Box Already Closed, Cancelled or Rejected';
            }
            if ($PackingBox->first()->is_add_to_gpl != 0) {
                $result = 'Cannot Unpack. Already Added to GP';
            }
            if ($PackingBox->first()->gpl_no != null) {
                $result = 'Cannot Unpack. Already Added to GPL';
            }
            if ($PackingBox->first()->is_invoiced != 0) {
                $result = 'Cannot Unpack. Already Invoiced';
            }
            if ($PackingBox->first()->inv_id != null) {
                $result = 'Cannot Unpack. Already Invoiced';
            }
        } else {
            $result =     response([
                'status' => 'Not Found',
                'code' => 404,
                'message' => "Box Not Found"
            ], 404);;
        }

        return $result;
    }

}
