<?php

namespace Modules\Mnu\Http\Controllers\Masters;

// Reports
use Modules\Mnu\Http\Controllers\Reports\ExportPackingList;
use Modules\Mnu\Http\Controllers\Reports\DetailedPackingList;

// Others
use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Mnu\Entities\PackingBox;

class PackingDetailsReportsController extends Controller
{
    use commonFeatures;

    public function getReport($reportType, $EplId)
    {
        try {

            switch ((int)$reportType) {
                case 1:
                
                    return $this->responseBody(true, 'Report', 'Found', $this->ExportPackingListXLSX($EplId));
                    break;

                case 2:
                    return $this->responseBody(true, 'Report', 'Found', $this->ExportPackingListPDF($EplId));
                    break;

                case 3:
                    return $this->responseBody(true, 'Report', 'Found', $this->DetailedPackingListXLSX($EplId));
                    break;

                case 4:
                    return $this->responseBody(true, 'Report', 'Found', $this->DetailedPackingListPDF($EplId));
                    break;

                default:
                    return $this->responseBody(false, 'Report', 'Report not found', null);
                    break;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // Reports
    protected function ExportPackingListXLSX($EplId)
    {
        Excel::store(new ExportPackingList($EplId), 'Export Packing List.xlsx', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Export Packing List.xlsx']);
    }

    protected function ExportPackingListPDF($EplId)
    {
        Excel::store(new ExportPackingList($EplId), 'Export Packing List.pdf', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Export Packing List.pdf']);
    }

    protected function DetailedPackingListXLSX($EplId)
    {
        Excel::store(new DetailedPackingList($EplId), 'Detailed Packing List.xlsx', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Detailed Packing List.xlsx']);
    }

    protected function DetailedPackingListPDF($EplId)
    {
        Excel::store(new DetailedPackingList($EplId), 'Detailed Packing List.pdf', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Detailed Packing List.pdf']);
    }
}
