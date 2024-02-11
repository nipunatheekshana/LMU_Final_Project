<?php

namespace App\Http\common;

use Carbon\Carbon;
use Exception;
use Modules\Accounting\Entities\Invoice;
use Modules\Buying\Entities\GrnDetailPayRate;
use Modules\Buying\Entities\GrnTicket;
use Modules\Buying\Entities\QGrn;
use Modules\Inventory\Entities\DeliveryNote;
use Modules\Mnu\Entities\ExternalPackingList;
use Modules\Mnu\Entities\PackingListHeader;
use Modules\Mnu\Entities\RequirementDetail;
use Modules\Mnu\Entities\WorkSheetDetail;
use Modules\Quality\Entities\LabTestDtlComposition;
use Modules\Quality\Entities\LabTestHd;
use Modules\Selling\Entities\CustomerOrder;
use Modules\Settings\Entities\NamingSeries;

trait nameingSeries
{
    #############################################################################
    ############ update isExists Filter When Calling this Class #################
    #############################################################################

    public function nameSeris($formName)
    {
        try {
            $NamingSeries = NamingSeries::where('function', $formName)->select('namingFormat', 'currentValue', 'id')->first();
            $Arr = $this->makeFormatArry($NamingSeries->namingFormat);
            $ReConstructedArr = $this->guessFormatEliments($Arr);



            $number = 0;
            $x = true;
            while ($x) {
                $result = $this->makeSeris($ReConstructedArr, $NamingSeries->currentValue, $number);

                if (!$this->isExists($result, $formName)) {
                    $x = false;
                } else {
                    $number = $number + 1;
                }
            }
            $update = NamingSeries::find($NamingSeries->id);
            $update->currentValue = ($NamingSeries->currentValue) + $number;
            $update->save();

            return $result;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function makeFormatArry($format)
    {
        try {
            $Arr = explode('.', $format, 10000); //devide string in to an arry with '.'
            return $Arr;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    private function guessFormatEliments($Arr)
    {
        try {
            for ($i = 0; $i < count($Arr); $i++) {

                switch ($Arr[$i]) {
                    case 'YY':
                        $Arr[$i] = Carbon::now()->format('y');
                        break;
                    case 'YYYY':
                        $Arr[$i] = Carbon::now()->format('Y');
                        break;
                    case 'MM':
                        $Arr[$i] = Carbon::now()->format('m');
                        break;
                    case 'DD':
                        $Arr[$i] = Carbon::now()->format('d');
                        break;
                    default:
                        $Arr[$i] = $Arr[$i];
                        break;
                }
            }
            return $Arr;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    private function makeSeris($arr, $curentval, $number)
    {
        try {
            $string = '';
            for ($i = 0; $i < count($arr); $i++) {

                if (strpos($arr[$i], '#') !== false) { //go through the arr and check if it has #
                    $newArr = str_split($arr[$i]);
                    $is_number = false;
                    for ($j = 0; $j < count($newArr); $j++) { //if arr has # check all the characters are #
                        if ($newArr[$j] == '#') {
                            $is_number = true; //if all the characters are # it is a number
                        } else {
                            $arr[$i] = $arr[$i];
                            $is_number = false;
                            break;
                        }
                    }
                    if ($is_number) {
                        $arr[$i] = str_pad($curentval + $number, count($newArr), "0", STR_PAD_LEFT); //add matching '0' to the number
                    } else {
                        $arr[$i] = $arr[$i];
                    }
                }
                $string = $string . $arr[$i]; //reconstruct arry to a string
            }
            return $string;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    public function hasNumber($format)
    {
        $arr = $this->makeFormatArry($format);
        $is_number = false;

        for ($i = 0; $i < count($arr); $i++) {

            if (strpos($arr[$i], '#') !== false) { //go through the arr and check if it has #
                $newArr = str_split($arr[$i]);
                for ($j = 0; $j < count($newArr); $j++) { //if arr has # check all the characters are #
                    if ($newArr[$j] == '#') {
                        $is_number = true; //if all the characters are # it is a number
                    } else {
                        $is_number = false;
                        break;
                    }
                }
                if ($is_number) {
                    return $is_number;
                }
            }
        }
        return $is_number;
    }
    private function isExists($data, $formName)
    {
        try {
            $exist = false;
            switch ($formName) {
                case 'Customer Order':
                    if (CustomerOrder::where('order_number', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Requirement ID':
                    if (RequirementDetail::where('rqID', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Planning Number':
                    if (WorkSheetDetail::where('mainPlID', $data)->exists()) {
                        $exist = true;
                    }
                case 'Raw Material Cost ID':
                    if (GrnDetailPayRate::where('rm_cost_id', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'General Packing List':
                    if (ExternalPackingList::where('gpl_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Export Packing List':
                    if (PackingListHeader::where('pl_number', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Invoice':
                    if (Invoice::where('inv_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Lab Test':
                    if (LabTestHd::where('labTestNo', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Test Sample':
                    if (LabTestDtlComposition::where('sam_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Delivery note':
                    if (DeliveryNote::where('delivery_note_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'Pick List':
                    if (DeliveryNote::where('picklist_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'GRN ticket':
                    if (GrnTicket::where('ticket_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                case 'qGRN No':
                    if (QGrn::where('qgrn_no', $data)->exists()) {
                        $exist = true;
                    }
                    break;
                default:
                    $exist = false;
            }

            return $exist;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
