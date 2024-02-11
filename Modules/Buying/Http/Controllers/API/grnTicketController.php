<?php

namespace Modules\Buying\Http\Controllers\API;

use App\Http\common\nameingSeries;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\GrnTicket;
use Modules\Buying\Entities\GrnTicketBoatDetail;
use Modules\Buying\Entities\GrnTicketFishDetail;

class grnTicketController extends Controller
{
    use nameingSeries;
    public function create_update_grn_ticket(Request $request)
    {
        DB::beginTransaction();

        try {
            // return $request->all();
            $msg = '';
            if ($request->has('id')) {
                if (GrnTicket::where('id', $request->id)->exists()) {
                    $GrnTicket =  GrnTicket::find('id', $request->id);
                    $msg = 'Grn Ticket updated';
                    //deldete  grn ticket fish and boat details to update
                    GrnTicketFishDetail::where('grn_ticket_id', $request->id)->delete();
                    GrnTicketBoatDetail::where('grn_ticket_id', $request->id)->delete();
                } else {
                    return response([
                        'status' => 'Data Incomplete',
                        'code' => 500,
                        'message' => 'Company ID not present',
                    ], 500);
                }
            } else {
                $GrnTicket = new  GrnTicket();
                $msg = 'Grn Ticket created';
            }
            $GrnTicket->company_id = $request->company_id;
            $GrnTicket->ticket_no = $this->nameSeris('GRN ticket');
            $GrnTicket->ticket_date_time = $request->ticket_date_time;
            $GrnTicket->supplier_id = $request->supplier_id;
            $GrnTicket->grn_mode = $request->grn_mode;
            $GrnTicket->vehicle_no = $request->vehicle_no;
            $GrnTicket->ticket_status = $request->ticket_status;
            $GrnTicket->grn_status = $request->grn_status;
            $save = $GrnTicket->save();
            if ($save) {
                foreach ($request->fish_details as $fish_detail) {
                    $GrnTicketFishDetail = new GrnTicketFishDetail();
                    $GrnTicketFishDetail->grn_ticket_id = $GrnTicket->id;
                    $GrnTicketFishDetail->fish_species_id = $fish_detail->fish_species_id;
                    $GrnTicketFishDetail->fish_qty = $fish_detail->fish_qty;
                    $GrnTicketFishDetail->fish_weight = $fish_detail->fish_weight;
                    $GrnTicketFishDetail->save();
                }
                foreach ($request->boat_details as $boat_detail) {
                    $GrnTicketBoatDetail = new GrnTicketBoatDetail();
                    $GrnTicketBoatDetail->grn_ticket_id = $GrnTicket->id;
                    $GrnTicketBoatDetail->boat_id = $boat_detail->boat_id;
                    $GrnTicketBoatDetail->save();
                }
            }

            DB::commit();

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => $msg,
                'data' => ['id' => $GrnTicket->id, 'ticket_no' => $GrnTicket->ticket_no],

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
    public function get_grn_tickets(Request $request)
    {
        try {
            $data = DB::table('buying_grn_ticket_hd')
                ->leftJoin('buying_grn_ticket_fish_dtl', 'buying_grn_ticket_hd.id', '=', 'buying_grn_ticket_fish_dtl.grn_ticket_id')
                ->leftJoin('buying_grn_ticket_boat_dtl', 'buying_grn_ticket_hd.id', '=', 'buying_grn_ticket_boat_dtl.grn_ticket_id')
                ->select(
                    'buying_grn_ticket_hd.id',
                    'buying_grn_ticket_hd.company_id',
                    'buying_grn_ticket_hd.ticket_no',
                    'buying_grn_ticket_hd.ticket_date_time',
                    'buying_grn_ticket_hd.supplier_id',
                    'buying_grn_ticket_hd.grn_mode',
                    'buying_grn_ticket_hd.vehicle_no',
                    'buying_grn_ticket_hd.ticket_status',
                    'buying_grn_ticket_hd.grn_status',
                    DB::raw('CONCAT(JSON_OBJECT("fish_species_id", buying_grn_ticket_fish_dtl.fish_species_id, "fish_qty", buying_grn_ticket_fish_dtl.fish_qty, "fish_weight", buying_grn_ticket_fish_dtl.fish_weight)) as fish_details'),
                    DB::raw('CONCAT(JSON_OBJECT("boat_id", buying_grn_ticket_boat_dtl.boat_id)) as boat_details')
                )
                ->groupBy('buying_grn_ticket_hd.id')
                ->where('company_id', $request->company_id)
                ->whereBetween('grndate', [$request->date_from, $request->date_to])
                ->when($request->has('id'), function ($query) use ($request) {
                    $query->where('id', $request->id);
                })
                ->when($request->has('ticket_no'), function ($query) use ($request) {
                    $query->where('ticket_no', $request->ticket_no);
                })
                ->when($request->has('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->has('vehicle_no'), function ($query) use ($request) {
                    $query->where('vehicle_no', $request->vehicle_no);
                })
                ->when($request->has('fish_species'), function ($query) use ($request) {
                    $query->where('fish_species', $request->fish_species);
                })
                ->get();

            if ($data->isEmpty()) {
                return response([
                    'status' => 'No Content',
                    'code' => 204,
                    'message' => 'No GRN Details Found',
                ], 204);
            }

            return response([
                'status' => 'Success',
                'code' => 200,
                'message' => 'GRN Details Found',
                'data' => $data,
            ], 200);
        } catch (Exception $ex) {
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

}
