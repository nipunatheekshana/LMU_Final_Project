<?php

namespace Modules\Sf\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\GRNDetail;
use Modules\Settings\Entities\Company;
use Modules\Sf\Entities\Fishspecies;

class FishGRNController extends Controller
{
    public function save_fish_grn_header(Request $request)
    {
        try {
            DB::statement('call save_fish_grn_header(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@save_status)', array(
                $request->grnno,
                $request->grndate,
                $request->grn_type,
                $request->supplier_id,
                $request->supplier_ticket_id,
                $request->supplier_vehicle_no,
                $request->boat_id,
                $request->boat_skipper_name,
                $request->boat_number_of_crew,
                $request->boat_number_of_tanks,
                $request->boat_cooling_method,
                $request->boat_trip_start_date,
                $request->boat_trip_end_date,
                $request->boat_fishing_method_id,
                $request->boat_landing_site_id,
                $request->user_id,
                // $request->status,

            ));
            $results = DB::select('select @save_status as status');

            // echo ($results[0]->Xout);
            if ($results) {

                switch ($results[0]->status) {
                    case 0:
                        return response([
                            'status' => 'forbidden',
                            'code' => 403,
                            'message' => 'Licence Expired (Code 0)'
                        ], 403);
                        break;
                    case 1:
                        return response([
                            'status' => 'success',
                            'code' => 200,
                            'message' => 'Data Saved (Code 1)'
                        ], 200);
                        break;
                    case -1:
                        return response([
                            'status' => 'conflict',
                            'code' => 409,
                            'message' => 'Duplicate Record (Code -1)'
                        ], 409);
                        break;
                    default:
                        return  $results;
                        break;
                }
            } else {
                return 'fail';
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function save_fish_grn_details(Request $request)
    {
        try {
            $lotserialno = $this->getLotserialno($request->lotserialno, $request->serialNoMethod, $request->lotgrnno, $request->fishtypeid);
            if ($lotserialno == 'exist') {
                return response([
                    'status' => 'Serial No. exist',
                    'code' => 409,
                    'message' => 'Serial No. already exist'
                ], 409);
            }
            // else {
            //     return $lotserialno;
            // }

            DB::statement('call save_fish_grn_details(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@save_status)', array(
                $request->lotgrnno,
                $request->lotitemmode,
                $lotserialno,
                $request->fishtypeid,
                $request->qualitygrade,
                $request->presentation,
                $request->receivePcs,
                $request->scaleweight,
                $request->receiveweight,
                $request->dmgweight,
                $request->fishtemperature,
                $request->fishcomment,
                $request->fishselectorid,
                $request->mobileuserid,
                $request->boattankno,
                $request->boattanklayer,
                $request->boattanktemp,
                $request->catchdate,
                $request->groundtankid,
                $request->companyid,
                $request->workstationid,
                // $request->status,

            ));
            $results = DB::select('select @save_status as status');

            // echo ($results[0]->Xout);
            if ($results) {

                switch ($results[0]->status) {
                    case 1:
                        return response([
                            'status' => 'Created',
                            'code' => 201,
                            'message' => 'Fish detail Inserted (Code 1)',
                        ], 200);
                        break;
                    case 2:
                        return response([
                            'status' => 'Updated',
                            'code' => 200,
                            'message' => 'Fish detail Updated (Code 1)',
                        ], 200);
                        break;

                    default:
                        return  $results;
                        break;
                }
            } else {
                return 'fail';
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function get_catch_areas(Request $request)
    {
        try {
            $search = "''";
            if ($request->Search_like != '') {
                $search = $request->Search_like;
            }
            $result = DB::select("call get_catch_area( '$search')");

            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function get_catch_methods(Request $request)
    {
        try {
            $search = "''";
            if ($request->Search_like != '') {
                $search = $request->Search_like;
            }
            $result = DB::select("call get_catch_methods('$search')");
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function get_fish_list(Request $request)
    { {
            try {
                $search = "''";
                if ($request->Search_like != '') {
                    $search = $request->Search_like;
                }
                $result = DB::select("call get_fish_list('$search')");
                return $result;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
    public function get_fishing_boats(Request $request)
    { {
            try {
                $search_criteria = "''";
                $search_value = "''";

                if ($request->search_criteria != '') {
                    $search_criteria = $request->search_criteria;
                }
                if ($request->search_value != '') {
                    $search_value = $request->search_value;
                }
                $result = DB::select("call get_fishing_boats('$search_criteria','$search_value')");
                return $result;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
    public function get_landing_sites(Request $request)
    { {
            try {
                $search = "''";
                if ($request->Search_like != '') {
                    $search = $request->Search_like;
                }
                $result = DB::select("call get_landing_sites('$search')");
                return $result;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
    public function get_presentation_types(Request $request)
    { {
            try {
                $FishSpeciesID = "''";
                $Search_like = "''";

                if ($request->FishSpeciesID != '') {
                    $FishSpeciesID = $request->FishSpeciesID;
                }
                if ($request->Search_like != '') {
                    $Search_like = $request->Search_like;
                }
                $result = DB::select("call get_presentation_types('$FishSpeciesID','$Search_like')");
                return $result;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
    public function get_suppliers(Request $request)
    { {
            try {
                $search = "''";
                if ($request->Search_like != '') {
                    $search = $request->Search_like;
                }
                $result = DB::select("call get_suppliers('$search')");
                return $result;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }
    }
    private function getLotserialno(?string $serialNo, ?string $method, ?string $GrnNo, ?string $fishtypeid)
    {
        try {
            switch ($method) {
                case 1:
                    if (GRNDetail::where('lot_serial_no', $serialNo)->exists()) {
                        return 'exist';
                    } else {
                        return $serialNo;
                    }
                    break;
                case 2:
                    $grn = GRNDetail::where('lot_grnno', $GrnNo);
                    $lotserialno = Company::where('id', Auth::user()->company_id)->first('minFishSerialNo')->minFishSerialNo;
                    if ($grn->exists()) {
                        $lotserialno = $grn->max('lot_serial_no');
                        $lotserialno = $lotserialno + 1;
                    }
                    return $lotserialno;
                    break;
                case 3:
                    $grn = GRNDetail::where('lot_grnno', $GrnNo)->where('fish_type_id', $fishtypeid);
                    $lotserialno = Fishspecies::where('id', $fishtypeid)->first('minFishSerialNo')->minFishSerialNo;
                    if ($grn->exists()) {
                        $lotserialno = $grn->max('lot_serial_no');
                        $lotserialno = $lotserialno + 1;
                    }
                    return $lotserialno;
                    break;
                case 4:

                    $grn = GRNDetail::where('fish_type_id', $fishtypeid);
                    $lotserialno = Fishspecies::where('id', $fishtypeid)->first('minFishSerialNo')->minFishSerialNo;
                    if ($grn->exists()) {
                        $lotserialno = Fishspecies::where('id', $fishtypeid)->first('currentFishSerialNo')->currentFishSerialNo;
                        $lotserialno = $lotserialno + 1;
                    }
                    return $lotserialno;
                    break;
                case 5:
                    return $lotserialno = Company::where('id', Auth::user()->company_id)->first('currentFishSerialNo')->currentFishSerialNo + 1;
                    break;
                default:
                    return 'null';
                    break;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
