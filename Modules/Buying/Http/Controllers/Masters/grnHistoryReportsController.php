<?php

namespace Modules\Buying\Http\Controllers\Masters;

use Modules\Buying\Http\Controllers\Reports\TestReport;
use Modules\Buying\Http\Controllers\Reports\GRNFishDetails;
use Modules\Buying\Http\Controllers\Reports\GRNProductionSheet;
use Modules\Buying\Http\Controllers\Reports\GRNExportSummary;
use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class grnHistoryReportsController extends Controller
{
    use commonFeatures;

    public function getReport($reportId,$GRNno)
    {
        try {
            switch ((int)$reportId) {
                case 1:
                    return $this->responseBody(true,'Report','Found',$this->grnreportOne($GRNno));
                    break;

                case 2:
                    return $this->responseBody(true,'Report','Found',$this->grnreportTwo($GRNno));
                    break;

                case 3:
                    return $this->responseBody(true,'Report','Found',$this->grnreportThree($GRNno));
                    break;

                case 4:
                    return $this->responseBody(true,'Report','Found',$this->grnreportFour($GRNno));
                    break;

                case 5:
                    return $this->responseBody(true,'Report','Found',$this->grnreportFive($GRNno));
                    break;

                case 6:
                    return $this->responseBody(true,'Report','Found',$this->grnreportSix($GRNno));
                    break;

                default:
                    return $this->responseBody(false,'Report','Report not found',null);
                    break;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    protected function grnreportOne($GRNno)
    {
        Excel::store(new GRNFishDetails($GRNno), 'GRN Fish Details.xlsx', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'GRN Fish Details.xlsx']);
    }

    protected function grnreportTwo($GRNno)
    {
        Excel::store(new GRNFishDetails($GRNno), 'GRN Fish Details.pdf', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'GRN Fish Details.pdf']);
    }

    protected function grnreportThree($GRNno)
    {
        Excel::store(new GRNProductionSheet($GRNno), 'Production Sheet.xlsx', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Production Sheet.xlsx']);
    }

    protected function grnreportFour($GRNno)
    {
        Excel::store(new GRNProductionSheet($GRNno), 'Production Sheet.pdf', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Production Sheet.pdf']);
    }

    protected function grnreportFive($GRNno)
    {
        Excel::store(new GRNExportSummary($GRNno), 'Export Summary.xlsx', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Export Summary.xlsx']);
    }

    protected function grnreportSix($GRNno)
    {
        Excel::store(new GRNExportSummary($GRNno), 'Export Summary.pdf', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Export Summary.pdf']);
    }
}
