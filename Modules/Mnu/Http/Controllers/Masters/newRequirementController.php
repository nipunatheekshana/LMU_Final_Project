<?php

namespace Modules\Mnu\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Item;
use Modules\Mnu\Entities\Requirement;
use Modules\Mnu\Entities\RequirementDetail;

class newRequirementController extends Controller
{
    use commonFeatures,nameingSeries;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'date' => ['required'],
            'rqDate' => ['required'],
            'remarks' => ['required'],

        ]);
        try {
            $Requirement = new Requirement();
            $Requirement->date = $request->date;
            $Requirement->rqDate = $request->rqDate;
            $Requirement->remarks = $request->remarks;
            $Requirement->status = 0;
            $Requirement->created_by = Auth::user()->id;
            $save = $Requirement->save();

            if ($save) {
                foreach ($request->arr as $Detail) {
                    $Detail = json_decode($Detail);
                    $procesAndWorkStation = Item::where('id', $Detail->item)->select('process', 'work_station')->first();

                    $RequirementDetail = new RequirementDetail();
                    $RequirementDetail->rqHeaderId = $Requirement->id;
                    $RequirementDetail->rqID = $this->nameSeris('Requirement ID');
                    $RequirementDetail->rqDate = $request->rqDate;
                    $RequirementDetail->planStatus = 0;
                    $RequirementDetail->prodStatus = 0;
                    $RequirementDetail->item = $Detail->item;
                    $RequirementDetail->itemCode = $Detail->itemCode;
                    $RequirementDetail->itemName = $Detail->itemName;
                    $RequirementDetail->refNo = $Requirement->id;
                    $RequirementDetail->refType = 'RQ';
                    $RequirementDetail->rqQty = $Detail->rqQty;
                    $RequirementDetail->rqWeight = $Detail->rqWeight;
                    $RequirementDetail->remainingQty = $Detail->rqQty;
                    $RequirementDetail->remainingWeight = $Detail->rqWeight;
                    $RequirementDetail->process = $procesAndWorkStation->process;
                    $RequirementDetail->work_station = $procesAndWorkStation->work_station;
                    $RequirementDetail->created_by = Auth::user()->id;
                    $RequirementDetail->save();
                }
            }

            if ($save) {
                return $this->responseBody(true, "save", "Requirement saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadItems()
    {
        try {
            // $Item = Item::where('is_bom_outer_item', true)->where('enabled', true)->select('id', 'item_name')->orderBy('id', 'ASC')
            //     ->get();
            $Item = DB::table('inventory_items')

                ->get();
            return $this->responseBody(true, "loadItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", '', $ex->getMessage());
        }
    }
    public function getItem($itemID)
    {
        try {
            $Item = Item::where('id', $itemID)->first();

            return $this->responseBody(true, "getItem", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "getItem", '', $ex->getMessage());
        }
    }
    public function loadToday()
    {
        try {
            $today = Carbon::now();

            return $this->responseBody(true, "loadToday", '', $today->toDateString());
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadToday", '', $ex->getMessage());
        }
    }

}
