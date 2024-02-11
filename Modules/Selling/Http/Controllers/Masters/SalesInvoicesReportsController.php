<?php

namespace Modules\Selling\Http\Controllers\Masters;

// Reports
use Modules\Selling\Http\Controllers\Reports\ExportPackingList;
use Modules\Selling\Http\Controllers\Reports\SalesInvoiceGeneral;

// Others
use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Mnu\Entities\PackingBox;

class SalesInvoicesReportsController extends Controller
{
    use commonFeatures;

    public function getReport($reportType, $InvId)
    {
        try {

            switch ((int)$reportType) {
                case 1:

                    return $this->responseBody(true, 'Report', 'Found', $this->SalesInvoiceGeneralXLSX($InvId));
                    break;

                case 2:
                    return $this->responseBody(true, 'Report', 'Found', $this->SalesInvoiceGeneralPDF($InvId));
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
    protected function SalesInvoiceGeneralXLSX($InvId)
    {
        Excel::store(new SalesInvoiceGeneral($InvId), 'Sales Invoice General.xlsx', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Sales Invoice General.xlsx']);
    }

    protected function SalesInvoiceGeneralPDF($InvId)
    {
        Excel::store(new SalesInvoiceGeneral($InvId), 'Sales Invoice General.pdf', 'temp_report_drive');
        return (['url' => '/temp_reports/' . 'Sales Invoice General.pdf']);
    }

}
