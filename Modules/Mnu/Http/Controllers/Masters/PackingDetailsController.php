<?php

namespace Modules\Mnu\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CRM\Entities\Address;
use Modules\Inventory\Entities\Airline;
use Modules\Inventory\Entities\Destination;
use Modules\Mnu\Entities\ExternalPackingList;
use Modules\Mnu\Entities\PackingBox;
use Modules\Mnu\Entities\PackingListHeader;
use Modules\Mnu\Entities\PickList;
use Modules\Mnu\Entities\WorkSheetDetail;
use Modules\Selling\Entities\Customer;

class PackingDetailsController extends Controller

{
    use commonFeatures, nameingSeries;
    public function loadCounts()
    {
    }
    public function loadWSnumbers()
    {
        try {

            $WorkSheetDetail =   WorkSheetDetail::where('refType', 'CO')->select('mainPlID')->distinct('mainPlID')->get();



            return $this->responseBody(true, "save", "loadWSnumbers found", $WorkSheetDetail);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadWSnumbers", $ex->getMessage());
        }
    }
    public function loadCustomers()
    {
        try {

            $Customer =   Customer::select('id', 'CusName')->distinct('id')->get();



            return $this->responseBody(true, "save", "loadCustomers found", $Customer);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadCustomers", $ex->getMessage());
        }
    }
    public function loadWorkSheets(Request $request)
    {
        try {
            $selectArray = [
                'mnu_ws_plan_dtl.mainPlID AS wsNumber',
                'mnu_ws_plan_dtl.plDate AS wsDate',
                'selling_customers.CusName AS customer',
                'mnu_ws_plan_dtl.refNo AS orderNumber',
                'selling_customer_order.customer_po_no AS poNumber',
                DB::raw("Sum( mnu_ws_plan_dtl.plannedQty )AS TotalQty"),
                DB::raw("Sum( mnu_ws_plan_dtl.plannedWeight )AS TotalWeight"),
                DB::raw("Sum( mnu_ws_plan_dtl.remainingQty )AS PendingQty"),
                DB::raw("Sum( mnu_ws_plan_dtl.RemainingWeight )AS PendingWeight"),
            ];

            $reportData =  DB::table('mnu_ws_plan_dtl')
                ->join('selling_customers', 'selling_customers.id', '=', 'mnu_ws_plan_dtl.customer')
                ->join('selling_customer_order', 'selling_customer_order.id', '=', 'mnu_ws_plan_dtl.refNo');

            if ($request->startDate != 0 && $request->endDate != 0) {
                $reportData = $reportData->whereBetween('mnu_ws_plan_dtl.plDate', [$request->startDate, $request->endDate]);
            }

            if ($request->has('wsNumber') && $request->wsNumber != null) {
                $reportData = $reportData->where('mnu_ws_plan_dtl.mainPlID', $request->wsNumber);
            }
            if ($request->has('customer') && $request->customer != null) {
                $reportData = $reportData->where('mnu_ws_plan_dtl.customer', $request->customer);
            }
            $reportData =   $reportData->where('mnu_ws_plan_dtl.refType', 'CO')
                ->select($selectArray)
                ->groupBy('mnu_ws_plan_dtl.mainPlID')
                ->get();

            return $this->responseBody(true, "save", "loadWorkSheets found", $reportData);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadWorkSheets", $ex->getMessage());
        }
    }
    public function loadWorksheetDtls($mainPlId)
    {
        try {

            $worksheetDtl =  DB::table('mnu_ws_plan_dtl')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_ws_plan_dtl.item')
                ->select([
                    'inventory_items.item_name',
                    'mnu_ws_plan_dtl.plannedQty',
                    'mnu_ws_plan_dtl.completedQty',
                    'mnu_ws_plan_dtl.id',
                ])
                ->where('mnu_ws_plan_dtl.mainPlID', $mainPlId)
                ->addSelect(DB::raw("(SELECT COUNT(*) FROM mnu_packing_box_hd WHERE mnu_packing_box_hd.ws_id = mnu_ws_plan_dtl.id AND is_add_to_gpl = TRUE) AS box_count"))
                ->get();



            return $this->responseBody(true, "loadWorksheetDtls", "found", $worksheetDtl);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadWorksheetDtls", "error", $ex->getMessage());
        }
    }
    public function loadNewGenPL(Request $request)
    {
        try {
            $PackingBox = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->whereIn('mnu_packing_box_hd.ws_id', $request->wsIdArr)
                ->where('mnu_packing_box_hd.is_add_to_gpl', false)
                ->select(
                    'mnu_packing_box_hd.box_no',
                    'inventory_items.item_name',
                    'mnu_packing_box_hd.noofpcs',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.id',
                )
                ->get();


            return $this->responseBody(true, "save", "loadNewGenPL found", $PackingBox);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadNewGenPL", $ex->getMessage());
        }
    }
    public function saveGpl(Request $request)
    {
        try {
            // return json_decode($request->BoxId);
            $ExternalPackingList = new ExternalPackingList();
            $ExternalPackingList->ws_id = $request->mainPlId;
            $ExternalPackingList->gpl_no = $this->nameSeris('General Packing List');
            $ExternalPackingList->no_of_boxes = $request->totalBoxes;
            $ExternalPackingList->net_weight_tot = $request->totNetWeight;
            $ExternalPackingList->gross_weight_tot = $request->totGrossWeight;
            $save = $ExternalPackingList->save();

            if ($save) {
                foreach (json_decode($request->BoxId) as $id) {
                    $PackingBox = PackingBox::find($id);
                    $PackingBox->gpl_no =  $ExternalPackingList->gpl_no;
                    $PackingBox->ext_pl_id = $ExternalPackingList->id;
                    $PackingBox->is_add_to_gpl = true;
                    $PackingBox->save();
                }
            }
            $fromTo = DB::table('mnu_packing_box_hd')
                ->where('ext_pl_id', $ExternalPackingList->id)
                ->select([
                    DB::raw('MIN(box_no) AS fromBox'),
                    DB::raw('MAX(box_no) AS toBox'),
                ])
                ->first();
            ExternalPackingList::where('id', $ExternalPackingList->id)
                ->update(['box_from' => $fromTo->fromBox, 'box_to' => $fromTo->toBox]);

            return $this->responseBody(true, "save", "saveGpl", 'saved');
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "saveGpl", $ex->getMessage());
        }
    }
    public function loadGpls($mainPlId)
    {
        try {

            $ExternalPackingList = DB::table('mnu_ext_packing_list_hd')
                ->leftJoin('mnu_packing_list_hd', 'mnu_packing_list_hd.id', '=', 'mnu_ext_packing_list_hd.pl_id')
                ->where('mnu_ext_packing_list_hd.ws_id', $mainPlId)
                ->select([
                    'mnu_ext_packing_list_hd.gpl_no AS PLno',
                    'mnu_ext_packing_list_hd.box_from AS from',
                    'mnu_ext_packing_list_hd.box_to AS to',
                    'mnu_ext_packing_list_hd.no_of_boxes AS qty',
                    'mnu_ext_packing_list_hd.net_weight_tot AS weight',
                    'mnu_packing_list_hd.pl_number AS EXPplNo',
                    'mnu_ext_packing_list_hd.id',
                    'mnu_ext_packing_list_hd.is_add_to_pl'
                ])
                ->get();
            return $this->responseBody(true, "save", "loadGpls", $ExternalPackingList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadGpls", $ex->getMessage());
        }
    }
    public function deleteGpl($id)
    {
        try {
            PackingBox::where('ext_pl_id',  $id)
                ->update([
                    'gpl_no' => null,
                    // 'ext_pl_id' => null,
                    'is_add_to_gpl' => false,
                ]);
            ExternalPackingList::where('id', $id)->delete();


            return $this->responseBody(true, "deleteGpl", "Gpl Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteGpl", "Something went wrong", $exception->getMessage());
        }
    }
    public function editGpl(Request $request, $id)
    {
        try {
            // return $id;
            $SelectedPackingBox = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->where('mnu_packing_box_hd.ext_pl_id', $id)
                ->where('mnu_packing_box_hd.is_add_to_gpl', true)
                ->select(
                    'mnu_packing_box_hd.box_no',
                    'inventory_items.item_name',
                    'mnu_packing_box_hd.noofpcs',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.id',
                )
                ->get();
            $PackingBox = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->whereIn('mnu_packing_box_hd.ws_id', $request->wsIdArr)
                ->where('mnu_packing_box_hd.is_add_to_gpl', false)
                ->select(
                    'mnu_packing_box_hd.box_no',
                    'inventory_items.item_name',
                    'mnu_packing_box_hd.noofpcs',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.id',
                )
                ->get();

            // return $id;
            $ext_pl_id = PackingBox::where('ext_pl_id', $id)
                ->where('is_add_to_gpl', true)
                ->select('ext_pl_id', 'gpl_no')
                ->first();
            // $gpl_no = PackingBox::where('ext_pl_id', $id)
            //     ->where('is_add_to_gpl', true)
            //     ->select('ext_pl_id')
            //     ->first()->ext_pl_id;
            return $this->responseBody(
                true,
                "save",
                "loadGpls",
                [
                    'SelectedPackingBox' => $SelectedPackingBox,
                    'PackingBox' => $PackingBox,
                    'ext_pl_id' => $ext_pl_id,
                ]
            );
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadGpls", $ex->getMessage());
        }
    }
    public function UpdateGpl(Request $request, $id)
    {
        try {

            $update =   PackingBox::where('ext_pl_id',  $id)
                ->update([
                    'gpl_no' => null,
                    'ext_pl_id' => null,
                    'is_add_to_gpl' => false,
                ]);
            $ExternalPackingList =  ExternalPackingList::find($id);
            $ExternalPackingList->no_of_boxes = $request->totalBoxes;
            $ExternalPackingList->net_weight_tot = $request->totNetWeight;
            $ExternalPackingList->gross_weight_tot = $request->totGrossWeight;
            $save = $ExternalPackingList->save();


            if ($save && $update) {
                foreach (json_decode($request->BoxId) as $id) {
                    $PackingBox = PackingBox::find($id);
                    $PackingBox->gpl_no =  $ExternalPackingList->gpl_no;
                    $PackingBox->ext_pl_id = $ExternalPackingList->id;
                    $PackingBox->is_add_to_gpl = true;
                    $PackingBox->save();
                }
            }
            $fromTo = DB::table('mnu_packing_box_hd')
                ->where('ext_pl_id', $ExternalPackingList->id)
                ->select([
                    DB::raw('MIN(box_no) AS fromBox'),
                    DB::raw('MAX(box_no) AS toBox'),
                ])
                ->first();
            ExternalPackingList::where('id', $ExternalPackingList->id)
                ->update(['box_from' => $fromTo->fromBox, 'box_to' => $fromTo->toBox]);

            return $this->responseBody(true, "save", "loadNewGenPL", 'saved');
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadNewGenPL", $ex->getMessage());
        }
    }
    public function loadNewExpPL($mainPlId)
    {
        try {

            $ExternalPackingList = DB::table('mnu_ext_packing_list_hd')
                ->where('mnu_ext_packing_list_hd.ws_id', $mainPlId)
                ->where('mnu_ext_packing_list_hd.is_add_to_pl', false)
                ->select([
                    'mnu_ext_packing_list_hd.gpl_no',
                    'mnu_ext_packing_list_hd.box_from AS from',
                    'mnu_ext_packing_list_hd.box_to AS to',
                    'mnu_ext_packing_list_hd.no_of_boxes AS qty',
                    'mnu_ext_packing_list_hd.net_weight_tot AS weight',
                    'mnu_ext_packing_list_hd.id'
                ])
                ->get();
            return $this->responseBody(true, "save", "loadNewExpPL", $ExternalPackingList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadNewExpPL", $ex->getMessage());
        }
    }
    public function updateExpPlSummary(Request $request)
    {
        try {
            $boxes = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->whereIn('mnu_packing_box_hd.gpl_no', $request->gplArr)
                ->select([
                    'mnu_packing_box_hd.box_no',
                    'inventory_items.item_name',
                    'mnu_packing_box_hd.noofpcs',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.gpl_no',
                    'mnu_packing_box_hd.id',
                ])
                ->get();
            return $this->responseBody(true, "save", "loadNewExpPL", $boxes);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadNewExpPL", $ex->getMessage());
        }
    }
    public function loadGplSummaryDetails(Request $request, $mainPlId)
    {
        try {
            $data = DB::table('mnu_production_dtl')
                ->whereIn('box_no', $request->arrBoxIds)
                ->select('lot_grn_no', 'production_batch_no')
                ->get();
            $dates = DB::table('mnu_ws_plan_dtl')
                ->where('mnu_ws_plan_dtl.mainPlID', $mainPlId)
                ->select([
                    DB::raw("MIN(mnfDate) AS mnfDate"),
                    DB::raw("MAX(expDate) AS expDate")
                ])
                ->get();
            return $this->responseBody(true, "save", "loadGplSummaryDetails", ["data" => $data, "dates" => $dates]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadGplSummaryDetails", $ex->getMessage());
        }
    }
    public function loadDestinations()
    {
        try {

            return $this->responseBody(true, "save", "loadDestinations", Destination::where('enabled', true)->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadDestinations", $ex->getMessage());
        }
    }
    public function loadAirlines()
    {
        try {

            return $this->responseBody(true, "save", "loadAirlines", Airline::where('enabled', true)->get());
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadAirlines", $ex->getMessage());
        }
    }
    public function loadCustomerAddress($mainPlId)
    {
        try {
            $address = DB::table('crm_customeraddress')
                ->join('mnu_ws_plan_dtl', 'mnu_ws_plan_dtl.customer', '=', 'crm_customeraddress.CusCode')
                ->join('crm_addresses', 'crm_addresses.id', '=', 'crm_customeraddress.AddressID')
                ->where('mnu_ws_plan_dtl.mainPlID', $mainPlId)
                ->select('crm_addresses.id', 'crm_addresses.AddressTitle')
                ->distinct('crm_addresses.id')
                ->get();

            return $this->responseBody(true, "save", "loadCustomerAddress", $address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadCustomerAddress", $ex->getMessage());
        }
    }
    public function loadCustomerNotify($mainPlId)
    {
        try {
            $Notify = DB::table('selling_customernotifyparty')
                ->join('mnu_ws_plan_dtl', 'mnu_ws_plan_dtl.customer', '=', 'selling_customernotifyparty.CusCode')
                ->join('crm_addresses', 'crm_addresses.id', '=', 'selling_customernotifyparty.notifypartyID')
                ->where('mnu_ws_plan_dtl.mainPlID', $mainPlId)
                ->select('crm_addresses.id', 'crm_addresses.AddressTitle')
                ->distinct('crm_addresses.id')
                ->get();

            return $this->responseBody(true, "save", "loadCustomerNotify", $Notify);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadCustomerNotify", $ex->getMessage());
        }
    }
    public function loadAddress($addressId)
    {
        try {
            $selectarr = [
                'crm_addresses.Addressline1',
                'crm_addresses.Addressline2',
                'crm_addresses.CityTown',
                'crm_addresses.PostalCode',
                'settings_countries.country_name',
            ];
            $address = DB::table('crm_addresses')
                ->leftJoin('settings_countries', 'settings_countries.id', '=', 'crm_addresses.Country')
                ->where('crm_addresses.id', (int)$addressId)
                ->select($selectarr)
                ->first();

            return $this->responseBody(true, "save", "loadAddress", $address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadAddress", $ex->getMessage());
        }
    }
    public function saveExpl(Request $request)
    {
        $validatedData = $request->validate([
            'mainPlId' => ['required'],
            'notify_party' => ['required'],
            'destination'  => ['required'],
        ]);

        try {
            $worksheet = WorkSheetDetail::where('mainPlID', $request->mainPlId)->select('refNo', 'customer')->first();
            $PackingListHeader = new PackingListHeader();
            $PackingListHeader->pl_number = $this->nameSeris('Export Packing List');
            $PackingListHeader->pl_date = $request->pl_date;
            $PackingListHeader->order_id =  $worksheet->refNo;
            $PackingListHeader->ws_id = $request->mainPlId;
            $PackingListHeader->cus_id =  $worksheet->customer;
            $PackingListHeader->consignee_id = $request->consignee;
            $PackingListHeader->consignee_name = Customer::where('id', $worksheet->customer)->select('CusName')->first()->CusName;
            $PackingListHeader->consignee_add1 = $request->consignee_addr1;
            $PackingListHeader->consignee_add2 = $request->consignee_addr2;
            $PackingListHeader->consignee_city_towm = $request->consignee_city;
            $PackingListHeader->consignee_country = $request->consignee_country;
            $PackingListHeader->consignee_postal_code = $request->consignee_postalcode;
            $PackingListHeader->notify_id = $request->notify_party;
            if ($request->has('notify_party')) {
                $PackingListHeader->notify_name = Address::where('id', $request->notify_party)->select('AddressTitle')->first()->AddressTitle;
            }
            $PackingListHeader->notify_add1 = $request->notify_addr1;
            $PackingListHeader->notify_add2 = $request->notify_addr2;
            $PackingListHeader->notify_city_towm = $request->notify_city;
            $PackingListHeader->notify_postal_code = $request->notify_postalcode;
            $PackingListHeader->notify_country = $request->notify_country;
            $PackingListHeader->packing_date = $request->productDate;
            $PackingListHeader->expire_date = $request->ExpireDate;
            $PackingListHeader->shipment_no = $request->shipment_no;
            $PackingListHeader->destination_id = $request->destination;
            if ($request->has('destination')) {
                $PackingListHeader->destination_code = Destination::where('id', $request->destination)->select('code')->first()->code;
            }
            $PackingListHeader->batch_nos_list = $request->ModalExpPL_batchNo;
            $PackingListHeader->grn_nos_list = $request->ModalExpPL_GrnNos;
            $PackingListHeader->awb_no = $request->awb_no;
            $PackingListHeader->flight_no = $request->flight_no;
            $PackingListHeader->flight_date = $request->flight_date;
            $PackingListHeader->air_line = $request->air_line;
            $PackingListHeader->Remarks = $request->Remarks;
            $PackingListHeader->export_date = $request->export_date;
            $PackingListHeader->eu_approval_no = $request->eu_approval_no;
            $PackingListHeader->production_manager = $request->production_manager;
            $PackingListHeader->packing_qc = $request->checkedby_name;
            $PackingListHeader->authorisedby_name = $request->authorization;
            $save = $PackingListHeader->save();
            if ($save) {
                foreach (json_decode($request->GplIds) as $id) {
                    $ExternalPackingList = ExternalPackingList::find($id);
                    $ExternalPackingList->is_add_to_pl = true;
                    $ExternalPackingList->pl_id =  $PackingListHeader->id;
                    $ExternalPackingList->modified_by =  Auth::user()->id;
                    $ExternalPackingList->save();
                }
                foreach (json_decode($request->BoxIds) as $id) {
                    $PackingBox = PackingBox::find($id);
                    $PackingBox->pl_id =  $PackingListHeader->id;
                    $PackingBox->is_add_to_pl = true;
                    $PackingBox->save();
                }
            }

            return $this->responseBody(true, "save", "saveExpl", 'saved');
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "saveExpl", $ex->getMessage());
        }
    }
    public function loadExpls($mainPlId)
    {
        try {

            $ExternalPackingList = DB::table('mnu_packing_list_hd')
                ->where('mnu_packing_list_hd.ws_id', $mainPlId)
                ->select([
                    'mnu_packing_list_hd.pl_number',
                    'mnu_packing_list_hd.pl_date',
                    'mnu_packing_list_hd.awb_no',
                    'mnu_packing_list_hd.flight_no',
                    'mnu_packing_list_hd.flight_date',
                    'mnu_packing_list_hd.id',
                    'mnu_packing_list_hd.is_invoiced',
                    'mnu_packing_list_hd.invoice_number',

                ])
                ->get();
            return $this->responseBody(true, "save", "loadExpls", $ExternalPackingList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadExpls", $ex->getMessage());
        }
    }
    public function deleteExpl($id)
    {
        try {
            ExternalPackingList::where('pl_id',  $id)
                ->update([
                    'pl_id' => null,
                    // 'ext_pl_id' => null,
                    'is_add_to_pl' => false,
                    'modified_by' => Auth::user()->id
                ]);
            PackingBox::where('pl_id',  $id)
                ->update([
                    'is_add_to_pl' => false,
                    'modified_by' => Auth::user()->id
                ]);
            PackingListHeader::where('id', $id)->delete();


            return $this->responseBody(true, "deleteGpl", "Epl Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteGpl", "Something went wrong", $exception->getMessage());
        }
    }
    public function editExpl($id)
    {
        try {
            // return $id;
            $ExternalPackingList = DB::table('mnu_ext_packing_list_hd')
                ->where('mnu_ext_packing_list_hd.pl_id', $id)
                ->where('mnu_ext_packing_list_hd.is_add_to_pl', false)
                ->select([
                    'mnu_ext_packing_list_hd.gpl_no',
                    'mnu_ext_packing_list_hd.box_from AS from',
                    'mnu_ext_packing_list_hd.box_to AS to',
                    'mnu_ext_packing_list_hd.no_of_boxes AS qty',
                    'mnu_ext_packing_list_hd.net_weight_tot AS weight',
                    'mnu_ext_packing_list_hd.id'
                ])
                ->get();
            $SelectedExternalPackingList = DB::table('mnu_ext_packing_list_hd')
                ->where('mnu_ext_packing_list_hd.pl_id', $id)
                ->where('mnu_ext_packing_list_hd.is_add_to_pl', true)
                ->select([
                    'mnu_ext_packing_list_hd.gpl_no',
                    'mnu_ext_packing_list_hd.box_from AS from',
                    'mnu_ext_packing_list_hd.box_to AS to',
                    'mnu_ext_packing_list_hd.no_of_boxes AS qty',
                    'mnu_ext_packing_list_hd.net_weight_tot AS weight',
                    'mnu_ext_packing_list_hd.id'
                ])
                ->get();
            $ExplDetails = DB::table('mnu_packing_list_hd')
                ->where('mnu_packing_list_hd.id', $id)
                ->select([
                    'mnu_packing_list_hd.pl_number',
                    'mnu_packing_list_hd.pl_date',
                    'mnu_packing_list_hd.ws_id',
                    'mnu_packing_list_hd.consignee_id',
                    'mnu_packing_list_hd.consignee_add1',
                    'mnu_packing_list_hd.consignee_add2',
                    'mnu_packing_list_hd.consignee_city_towm',
                    'mnu_packing_list_hd.consignee_country',
                    'mnu_packing_list_hd.consignee_postal_code',
                    'mnu_packing_list_hd.notify_id',
                    'mnu_packing_list_hd.notify_add1',
                    'mnu_packing_list_hd.notify_add2',
                    'mnu_packing_list_hd.notify_city_towm',
                    'mnu_packing_list_hd.notify_postal_code',
                    'mnu_packing_list_hd.notify_country',
                    'mnu_packing_list_hd.packing_date',
                    'mnu_packing_list_hd.expire_date',
                    'mnu_packing_list_hd.shipment_no',
                    'mnu_packing_list_hd.destination_id',
                    'mnu_packing_list_hd.batch_nos_list',
                    'mnu_packing_list_hd.grn_nos_list',
                    'mnu_packing_list_hd.awb_no',
                    'mnu_packing_list_hd.flight_no',
                    'mnu_packing_list_hd.flight_date',
                    'mnu_packing_list_hd.air_line',
                    'mnu_packing_list_hd.Remarks',
                    'mnu_packing_list_hd.export_date',
                    'mnu_packing_list_hd.eu_approval_no',
                    'mnu_packing_list_hd.production_manager',
                    'mnu_packing_list_hd.packing_qc',
                    'mnu_packing_list_hd.authorisedby_name',
                    'mnu_packing_list_hd.id',
                ])
                ->first();


            // $SelectedPackingBox = DB::table('mnu_packing_list_hd')
            //     ->where('mnu_packing_list_hd.id'.$id)
            //     ->get();

            return $this->responseBody(
                true,
                "save",
                "editExpl",
                [
                    'ExternalPackingList' => $ExternalPackingList,
                    'SelectedExternalPackingList' => $SelectedExternalPackingList,
                    'ExplDetails' => $ExplDetails
                ]
            );
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "editExpl", $ex->getMessage());
        }
    }
    public function UpdateExpl(Request $request)
    {
        $validatedData = $request->validate([
            'mainPlId' => ['required'],
            'notify_party' => ['required'],
            'destination'  => ['required'],
        ]);
        $id = $request->Explid;
        try {
            ExternalPackingList::where('pl_id',   $id)
                ->update([
                    'pl_id' => null,
                    // 'ext_pl_id' => null,
                    'is_add_to_pl' => false,
                    'modified_by' => Auth::user()->id
                ]);
            PackingBox::where('pl_id',  $id)
                ->update([
                    'is_add_to_pl' => false,
                    'modified_by' => Auth::user()->id
                ]);

            $worksheet = WorkSheetDetail::where('mainPlID', $request->mainPlId)->select('refNo', 'customer')->first();
            $PackingListHeader = PackingListHeader::find($id);
            $PackingListHeader->pl_date = $request->pl_date;
            $PackingListHeader->order_id =  $worksheet->refNo;
            $PackingListHeader->ws_id = $request->mainPlId;
            $PackingListHeader->cus_id =  $worksheet->customer;
            $PackingListHeader->consignee_id = $request->consignee;
            $PackingListHeader->consignee_name = Customer::where('id', $worksheet->customer)->select('CusName')->first()->CusName;
            $PackingListHeader->consignee_add1 = $request->consignee_addr1;
            $PackingListHeader->consignee_add2 = $request->consignee_addr2;
            $PackingListHeader->consignee_city_towm = $request->consignee_city;
            $PackingListHeader->consignee_country = $request->consignee_country;
            $PackingListHeader->consignee_postal_code = $request->consignee_postalcode;
            $PackingListHeader->notify_id = $request->notify_party;
            if ($request->has('notify_party')) {
                $PackingListHeader->notify_name = Address::where('id', $request->notify_party)->select('AddressTitle')->first()->AddressTitle;
            }
            $PackingListHeader->notify_add1 = $request->notify_addr1;
            $PackingListHeader->notify_add2 = $request->notify_addr2;
            $PackingListHeader->notify_city_towm = $request->notify_city;
            $PackingListHeader->notify_postal_code = $request->notify_postalcode;
            $PackingListHeader->notify_country = $request->notify_country;
            $PackingListHeader->packing_date = $request->productDate;
            $PackingListHeader->expire_date = $request->ExpireDate;
            $PackingListHeader->shipment_no = $request->shipment_no;
            $PackingListHeader->destination_id = $request->destination;
            if ($request->has('destination')) {
                $PackingListHeader->destination_code = Destination::where('id', $request->destination)->select('code')->first()->code;
            }
            $PackingListHeader->batch_nos_list = $request->ModalExpPL_batchNo;
            $PackingListHeader->grn_nos_list = $request->ModalExpPL_GrnNos;
            $PackingListHeader->awb_no = $request->awb_no;
            $PackingListHeader->flight_no = $request->flight_no;
            $PackingListHeader->flight_date = $request->flight_date;
            $PackingListHeader->air_line = $request->air_line;
            $PackingListHeader->Remarks = $request->Remarks;
            $PackingListHeader->export_date = $request->export_date;
            $PackingListHeader->eu_approval_no = $request->eu_approval_no;
            $PackingListHeader->production_manager = $request->production_manager;
            $PackingListHeader->packing_qc = $request->checkedby_name;
            $PackingListHeader->authorisedby_name = $request->authorization;
            $save = $PackingListHeader->save();
            if ($save) {
                foreach (json_decode($request->GplIds) as $id) {
                    $ExternalPackingList = ExternalPackingList::find($id);
                    $ExternalPackingList->is_add_to_pl = true;
                    $ExternalPackingList->pl_id =  $PackingListHeader->id;
                    $ExternalPackingList->modified_by =  Auth::user()->id;
                    $ExternalPackingList->save();
                }
                foreach (json_decode($request->BoxIds) as $id) {
                    $PackingBox = PackingBox::find($id);
                    $PackingBox->pl_id =  $PackingListHeader->id;
                    $PackingBox->is_add_to_pl = true;
                    $PackingBox->save();
                }
            }

            return $this->responseBody(true, "save", "UpdateExpl", 'saved');
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "UpdateExpl", $ex->getMessage());
        }
    }
    public function LOadPickListBoxes(Request $request,$pickListNum)
    {
        try {

            if(PickList::where('picklist_no',$pickListNum)->whereIn('worksheet_id',$request->wsIdArr)->exists()){
                $PackingBox = DB::table('mnu_pick_list_dtl')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->join('mnu_packing_box_hd', 'mnu_packing_box_hd.id', '=', 'mnu_pick_list_dtl.box_id')
                ->join('mnu_pick_list_hd', 'mnu_pick_list_hd.id', '=', 'mnu_pick_list_dtl.pick_list_hd_id')
                ->whereIn('mnu_pick_list_hd.worksheet_id', $request->wsIdArr)
                ->where('mnu_packing_box_hd.is_add_to_gpl', false)
                ->select(
                    'mnu_packing_box_hd.box_no',
                    'inventory_items.item_name',
                    'mnu_packing_box_hd.noofpcs',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.id',
                )
                ->get();
            }



            return $this->responseBody(true, "save", "loadNewGenPL found", $PackingBox);
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "loadNewGenPL", $ex->getMessage());
        }
    }
}
