<?php

namespace Modules\Buying\Http\Controllers\API;

use App\Http\common\activityLog;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\GRNDetail;
use Modules\Buying\Entities\QGrn;

class QGRNController extends Controller

{
    use activityLog;
    public function save_qgrn_header(Request $request)
    {
        DB::beginTransaction();

        try {

            $qgrn = $request->has('id') ? QGrn::findOrFail($request->id) : new QGrn();
            $qgrn->fill($request->only([
                'qgrn_date',
                'supplier_id',
                'supplier_vehicle_no',
                'boat_registration_number',
                'boat_licence_no',
                'unload_status',
                'finance_status',
                'total_fish_weight',
                'total_qty',
                'boat_trip_start_date',
                'boat_trip_end_date',
                'boat_landing_site_id',
            ]));
            $qgrn->qgrn_no = $qgrn->qgrn_no ?? $this->nameSeris('qGRN No');
            $qgrn->company_id = $qgrn->company_id ?? Auth::user()->company_id;
            $qgrn->created_by = Auth::user()->id;
            $qgrn->save();
            DB::commit();

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => $qgrn->wasRecentlyCreated ? 'qGrn Ticket created' : 'qGrn Ticket updated',
                'data' => ['id' => $qgrn->id, 'ticket_no' => $qgrn->qgrn_no],
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
    public function transfer_grn_fish_to_qgrn(Request $request)
    {
        try {
            $lot_barcode = $request->input('lot_barcode');
            $QGRId = $request->input('id');
            $q_fish_weight = $request->input('q_fish_weight');

            $QGRNST = QGrn::where('id', $QGRId)->value('unload_status');

            if ($QGRNST == 0) {
                $result = GRNDetail::selectRaw('IFNULL(COUNT(lot_barcode), 0) as FishCount, fish_type_id')
                    ->where('lot_barcode', $lot_barcode)
                    ->groupBy('fish_type_id')
                    ->first();

                $QFISHNO = $result->FishCount > 0 ? GRNDetail::where('q_grn_status', 1)
                    ->where('q_grnno', $QGRId)
                    ->where('fish_type_id', $result->fish_type_id)
                    ->max('q_fish_no') + 1 : 0;

                if ($QFISHNO > 0) {
                    DB::beginTransaction();

                    GRNDetail::where('lot_barcode', $lot_barcode)
                        ->update([
                            'q_fish_weight' => $q_fish_weight,
                            'q_grn_status' => 1,
                            'q_grnno' => $QGRId,
                            'q_fish_no' => $QFISHNO
                        ]);

                    DB::commit();
                }
            } else {
                return response([
                    'status' => 'error',
                    'code' => 200,
                    'message' => 'Data not saved',

                ], 500);
            }

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'Fish transfered',

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
    public function get_qgrn_fish_details(Request $request)
    {
        try {
            $data = GRNDetail::where('company_id', $request->company_id)
                ->where('q_grnno', $request->qgrn_id)
                ->when($request->has('grn_id'), function ($query) use ($request) {
                    $query->where('grn_id', $request->grn_id);
                })
                ->when($request->has('id'), function ($query) use ($request) {
                    $query->where('id', $request->id);
                })
                ->when($request->has('fish_type_id'), function ($query) use ($request) {
                    $query->where('fish_type_id', $request->fish_type_id);
                })
                ->when($request->has('quality_grade'), function ($query) use ($request) {
                    $query->where('quality_grade', $request->quality_grade);
                })
                ->when($request->has('presentation'), function ($query) use ($request) {
                    $query->where('presentation', $request->presentation);
                })
                ->when($request->has('item_Status'), function ($query) use ($request) {
                    $query->where('item_Status', $request->item_Status);
                });

            if ($data->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No QGRN Details Found',
                ], 204);
            }

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'QGRN Details Found',
                'total_qty' => $data->count('id'),
                'total_weight' => $data->sum('net_weight'),
                'average_weight' => $data->avg('net_weight'),
                'data' => $data->get(),
            ], 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function get_qgrn_hd_list(Request $request)
    {
        try {
            $data = QGrn::where('company_id', $request->company_id)
                ->when($request->has('id'), function ($query) use ($request) {
                    $query->where('id', $request->id);
                })
                ->when($request->has('grnfromdate') && $request->has('grntilldate'), function ($query) use ($request) {
                    $query->whereBetween('qgrn_date', [$request->grnfromdate, $request->grntilldate]);
                })
                ->when($request->has('supplier_id'), function ($query) use ($request) {
                    $query->where('supplier_id', $request->supplier_id);
                })
                ->when($request->has('grn_type'), function ($query) use ($request) {
                    $query->where('grn_type', $request->grn_type);
                })
                ->when($request->has('unload_status'), function ($query) use ($request) {
                    $query->where('unload_status', $request->unload_status);
                });

            if ($data->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No QGRNs Found',
                ], 204);
            }

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'QGRNs  Found',
                'total_qty' => $data->count('id'),
                'data' => $data->get(),
            ], 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    public function get_fish_qgrn_status(Request $request)
    {
        try {
            $data = GRNDetail::where('lot_barcode', $request->fish_barcode)
                ->select([
                    'q_grnno',
                    'q_grn_status',
                    'q_fish_no',
                    'q_fish_grade',
                    'q_fish_weight',
                ])
                ->first();

            if (!$data) {
                return response([
                    'status' => 'No Content',
                    'code' => 404,
                    'message' => 'No QGRNs Found',
                ], 404);
            }

            $response = [
                'status' => 'ok',
                'code' => 200,
                'message' => $data->q_grnno ? 'Assigned to QGRN' : 'Not Assigned to QGRN',
                'data' => $data->q_grnno ? [
                    'is_assigned' => 1,
                    'q_grn_status' => $data->q_grn_status,
                    'q_grnno' => $data->q_grnno,
                    'q_fish_no' => $data->q_fish_no,
                    'q_fish_grade' => $data->q_fish_grade,
                    'q_fish_weight' =>  $data->q_fish_weight,
                ] : [
                    'is_assigned' => 0,
                ],
            ];

            return response($response, 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
    // public function transfer_qgrn_fish_to_qgrn(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $GRNDetail =  DB::table('buying_fish_grn_dtl')
    //             ->leftJoin('buying_fish_qgrn_hd', 'buying_fish_qgrn_hd.id', '=', 'buying_fish_grn_dtl.q_grnno')
    //             ->where('buying_fish_grn_dtl.lot_barcode', $request->fish_barcode)
    //             ->select(
    //                 [
    //                     'buying_fish_grn_dtl.q_grn_status',
    //                     'buying_fish_grn_dtl.item_Status',
    //                     'buying_fish_grn_dtl.id',
    //                     'buying_fish_qgrn_hd.qgrn_no'
    //                 ]
    //             )->first();


    //         if ($GRNDetail->q_grn_status != 0) {
    //             return response([
    //                 'status' => 'Error',
    //                 'code' => 500,
    //                 'message' => "Cannot Transfer. Previous QGRN No : $GRNDetail->qgrn_no is Not in “Open” Status",
    //             ], 500);
    //         } elseif ($GRNDetail->item_Status != 0) {
    //             $status = '';
    //             switch ($GRNDetail->item_Status) {
    //                 case 1:
    //                     $status = 'Processed';
    //                     break;
    //                 case 2:
    //                     $status = 'Hold';
    //                     break;
    //                 case 3:
    //                     $status = 'Rejected';
    //                     break;
    //                 case 4:
    //                     $status = 'Transferred';
    //                     break;

    //                 default:
    //                     # code...
    //                     break;
    //             }
    //             return response([
    //                 'status' => 'Error',
    //                 'code' => 500,
    //                 'message' => "Cannot Transfer. Lot already : $status",
    //             ], 500);
    //         } else {

    //             $result = GRNDetail::selectRaw('IFNULL(COUNT(lot_barcode), 0) as FishCount, fish_type_id')
    //                 ->where('lot_barcode', $request->fish_barcode)
    //                 ->groupBy('fish_type_id')
    //                 ->first();

    //             $QFISHNO = $result->FishCount > 0 ? GRNDetail::where('q_grn_status', 1)
    //                 ->where('q_grnno', $request->qgrn_id)
    //                 ->where('fish_type_id', $result->fish_type_id)
    //                 ->max('q_fish_no') + 1 : 0;

    //             $data = GRNDetail::find($GRNDetail->id);
    //             $data->q_grnno = $request->has('qgrn_id') ? $request->qgrn_id : null;
    //             $data->q_fish_grade = $request->has('q_fish_grade') ? $request->q_fish_grade : null;
    //             $data->q_fish_weight = $request->has('q_fish_weight') ? $request->q_fish_weight : null;
    //             $data->q_fish_no =  $QFISHNO;
    //             $data->modified_by = Auth::user()->id;
    //             $save = $data->save();

    //             $qgrn_no = QGrn::where('id', $request->qgrn_id)->first('qgrn_no')->qgrn_no;
    //             if ($save) {
    //                 $this->logActivity('fa fa-check-square-o', 'success', "Removed from QGRN No : $GRNDetail->qgrn_no & Assigned to QGRN No :$qgrn_no", 'packingBox', $request->id);
    //             }
    //         }
    //         DB::commit();

    //         return response([
    //             'status' => 'Success',
    //             'code' => 200,
    //             'message' => 'Assigned to QGRN',
    //             "qfishno" =>  $QFISHNO
    //         ], 200);
    //     } catch (Exception $ex) {
    //         DB::rollback();

    //         return response([
    //             'status' => 'Error',
    //             'code' => 500,
    //             'message' => $ex->getMessage(),
    //         ], 500);
    //     }
    // }
    public function transfer_qgrn_fish_to_qgrn(Request $request)
    {
        DB::beginTransaction();

        try {
            $GRNDetail = DB::table('buying_fish_grn_dtl')
                ->leftJoin('buying_fish_qgrn_hd', 'buying_fish_qgrn_hd.id', '=', 'buying_fish_grn_dtl.q_grnno')
                ->where('buying_fish_grn_dtl.lot_barcode', $request->fish_barcode)
                ->select('buying_fish_grn_dtl.q_grn_status', 'buying_fish_grn_dtl.item_Status', 'buying_fish_grn_dtl.id', 'buying_fish_qgrn_hd.qgrn_no')
                ->first();

            if ($GRNDetail->q_grn_status != 0) {
                return response()->json(['status' => 'Error', 'code' => 500, 'message' => "Cannot Transfer. Previous QGRN No: $GRNDetail->qgrn_no is Not in “Open” Status"], 500);
            }

            if ($GRNDetail->item_Status != 0) {
                $status = ['Processed', 'Hold', 'Rejected', 'Transferred'][$GRNDetail->item_Status - 1];
                return response()->json(['status' => 'Error', 'code' => 500, 'message' => "Cannot Transfer. Lot already: $status"], 500);
            }

            $result = GRNDetail::selectRaw('IFNULL(COUNT(lot_barcode), 0) as FishCount, fish_type_id')
                ->where('lot_barcode', $request->fish_barcode)
                ->groupBy('fish_type_id')
                ->first();

            $QFISHNO = $result->FishCount > 0 ? GRNDetail::where('q_grn_status', 1)
                ->where('q_grnno', $request->qgrn_id)
                ->where('fish_type_id', $result->fish_type_id)
                ->max('q_fish_no') + 1 : 0;

            $data = GRNDetail::find($GRNDetail->id);
            $data->q_grnno = $request->filled('qgrn_id') ? $request->qgrn_id : null;
            $data->q_fish_grade = $request->filled('q_fish_grade') ? $request->q_fish_grade : null;
            $data->q_fish_weight = $request->filled('q_fish_weight') ? $request->q_fish_weight : null;
            $data->q_fish_no = $QFISHNO;
            $data->modified_by = Auth::user()->id;
            $save = $data->save();

            $qgrn_no = QGrn::where('id', $request->qgrn_id)->value('qgrn_no');
            if ($save) {
                $this->logActivity('fa fa-check-square-o', 'success', "Removed from QGRN No: $GRNDetail->qgrn_no & Assigned to QGRN No: $qgrn_no", 'packingBox', $request->id);
            }

            DB::commit();

            return response()->json(['status' => 'Success', 'code' => 200, 'message' => 'Assigned to QGRN', 'qfishno' => $QFISHNO], 200);
        } catch (Exception $ex) {
            DB::rollback();

            return response()->json(['status' => 'Error', 'code' => 500, 'message' => $ex->getMessage()], 500);
        }
    }

}
