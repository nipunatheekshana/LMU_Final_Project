<?php

namespace Modules\Buying\Http\Controllers\Reports;

use Exception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Buying\Entities\GRNDetail;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Buying\Entities\GRN;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class GRNExportSummary implements WithHeadings, WithStyles, WithColumnWidths, WithCustomStartCell
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $GRNno;
    function __construct($GRNno)
    {
        $this->GRNno = $GRNno;
    }
    public function startCell(): string
    {
        return 'A10';
    }

    public function headings(): array
    {
        return [
            'Customer',
            'Product',
            'Weight',
            'AWB No'
        ];
    }

    public function styles(Worksheet $spreadsheet)
    {
        //Page Size & Sclae
        $spreadsheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $spreadsheet->getPageSetup()->setFitToHeight(0);

        //Repeat Rows
        $spreadsheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 10);

        //Row Style
        $spreadsheet->getStyle('A3:D3')->getFont()->setBold(true)->setSize(15); //Company Name
        $spreadsheet->getStyle('A4:D4')->getFont()->setBold(true)->setSize(20); //Report Title
        $spreadsheet->getStyle('A5:D5')->getFont()->setBold(true)->setSize(15); //Report Subtitle

        $spreadsheet->getStyle('A7:A8')->getFont()->setBold(true);
        $spreadsheet->getStyle('C7')->getFont()->setBold(true);

        $spreadsheet->getStyle('A10:D10')->getFont()->setBold(true);


        $spreadsheet->getStyle('A10:D10')->getBorders();


        //ALignments
        $spreadsheet->getStyle('A10:D10')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $spreadsheet->getStyle('A3:D5')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $spreadsheet->getStyle('A7:D8')->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);


        //Setting Row Heights
        $spreadsheet->getRowDimension('1')->setRowHeight(0);
        $spreadsheet->getRowDimension('2')->setRowHeight(0);

        //Mergings
        $spreadsheet->mergeCells('A1:D1');

        $spreadsheet->mergeCells('A2:D2');

        $spreadsheet->mergeCells('A3:D3');
        $spreadsheet->mergeCells('A4:D4');
        $spreadsheet->mergeCells('A5:D5');
        $spreadsheet->mergeCells('A6:D6'); 

        $spreadsheet->mergeCells('A9:D9');




        // Text


        // $spreadsheet->getCell('A1')->setValue('2022-05-20 12:27 PM');
        // $spreadsheet->getCell('I1')->setValue('Page 01/01');

        $headerData = $this->GetHeaderdata();

        $spreadsheet->getCell('A3')->setValue('H&M Western (Pvt) Ltd');
        $spreadsheet->getCell('A4')->setValue('Export Summary');
        $spreadsheet->getCell('A5')->setValue('GRN Wise Disbursment Details');

        $spreadsheet->getCell('A7')->setValue('GRN #');
        $spreadsheet->getCell('B7')->setValue($headerData->grnno);

        $spreadsheet->getCell('A8')->setValue('Supplier');
        $spreadsheet->getCell('B8')->setValue($headerData->supplier_name);

        
        $spreadsheet->getCell('C7')->setValue('GRN Date');
        $spreadsheet->getCell('D7')->setValue($headerData->grndate);


       

        //body
        $data = $this->GetBodyData();
        $cell = 11;
        foreach ($data as $dataRow) {
            $spreadsheet->getCell("A$cell")->setValue($dataRow->lot_serial_no);
            $spreadsheet->getCell("B$cell")->setValue($dataRow->fish_type_id);
            $spreadsheet->getCell("C$cell")->setValue($dataRow->fish_type_id);
            $spreadsheet->getCell("D$cell")->setValue($dataRow->fish_type_id);

            $cell++;
        }

        // Setting Borders
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    // 'color' => ['argb' => 'FFFF0000'],
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ];
        $cell = $cell - 1;
        $spreadsheet->getStyle("A10:D$cell")->applyFromArray($styleArray);

        // Header & Footer
        $spreadsheet->getHeaderFooter()->setOddHeader('&L&D &T' . '&RPage &P of &N');
        $spreadsheet->getHeaderFooter()->setOddFooter('ISSUE NO     ' . 'DATE     ' . 'PREPARED BY     ' . 'APPROVED BY     ' . 'PAGE NO     ' . 'LOCATION');

    }


    public function columnWidths(): array
    {
        return [
            // Max - 90 for A4
            'A' => 30,       //Customer
            'B' => 30,       //Fish Species
            'C' => 15,      //Weight
            'D' => 25      //AWB No
        ];
    }



    public function backgroundColor()
    {
        // Return RGB color code.
        return '00300';
    }
    private function GetBodyData()
    {
        try {
            return GRNDetail::select('lot_serial_no', 'fish_type_id', 'lot_barcode', 'presentation', 'quality_grade', 'supplier_grade', 'item_size_id', 'net_weight', 'fish_temperature')
                ->where('lot_grnno',$this->GRNno)
                ->get();
        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }


    }
    private function GetHeaderdata()
    {
        try {
            $arr = [
                'buying_fish_grn_hd.grnno',
                'buying_suppliers.supplier_name',
                'buying_fish_grn_hd.grndate',
            ];
            return DB::table('buying_fish_grn_hd')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->where('buying_fish_grn_hd.grnno', $this->GRNno)
                ->select($arr)
                ->first();
        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }
}
