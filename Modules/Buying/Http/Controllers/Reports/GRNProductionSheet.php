<?php

namespace Modules\Buying\Http\Controllers\Reports;

use Exception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Buying\Entities\GRNDetail;
use Modules\Buying\Entities\Views\GRNDetailsView;
use Modules\Buying\Entities\Views\GRNHeaderDetailsView;
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

class GRNProductionSheet implements WithHeadings, WithStyles, WithColumnWidths, WithCustomStartCell
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $GRNno;
    protected $endCell;

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
            'Fish#',
            'Type',
            'Pcs#',
            'Product',
            'Customer',
            'Pr Weight',
            '',
            'Fish#',
            'Type',
            'Pcs#',
            'Product',
            'Customer',
            'Pr Weight'
        ];
    }

    public function styles(Worksheet $spreadsheet)
    {
        //Page Size & Sclae
        $spreadsheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $spreadsheet->getPageSetup()->setFitToHeight(0);

        //Repeat Rows
        $spreadsheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 8);

        //Row Style
        $spreadsheet->getStyle('C3')->getFont()->setBold(true)->setSize(15);
        $spreadsheet->getStyle('C4')->getFont()->setBold(true)->setSize(20);
        $spreadsheet->getStyle('C5')->getFont()->setBold(true)->setSize(15);

        $spreadsheet->getStyle('A7:A8')->getFont()->setBold(true);
        $spreadsheet->getStyle('G7:G8')->getFont()->setBold(true);

        $spreadsheet->getStyle('A10:M10')->getFont()->setBold(true);


        $spreadsheet->getStyle('A10:M10')->getBorders();


        //ALignments
        $spreadsheet->getStyle('A10:M10')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $spreadsheet->getStyle('A3:M5')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $spreadsheet->getStyle('A7:M8')->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);


        //Setting Row Heights
        $spreadsheet->getRowDimension('1')->setRowHeight(0);
        $spreadsheet->getRowDimension('2')->setRowHeight(0);

        //Mergings
        $spreadsheet->mergeCells('A1:B1');
        $spreadsheet->mergeCells('C1:H1');
        $spreadsheet->mergeCells('I1:J1');

        $spreadsheet->mergeCells('A2:M2');

        $spreadsheet->mergeCells('A3:M3');
        $spreadsheet->mergeCells('A4:M4');
        $spreadsheet->mergeCells('A5:M5');
        $spreadsheet->mergeCells('A6:M6');

        $spreadsheet->mergeCells('B7:G7');
        $spreadsheet->mergeCells('B8:G8');

        $spreadsheet->mergeCells('I7:M7');
        $spreadsheet->mergeCells('I8:M8');


        $spreadsheet->mergeCells('A9:M9');




        // Text


        // $spreadsheet->getCell('A1')->setValue('2022-05-20 12:27 PM');
        // $spreadsheet->getCell('I1')->setValue('Page 01/01');

        $headerData = $this->GetHeaderdata();

        $spreadsheet->getCell('A3')->setValue('H&M Western (Pvt) Ltd');
        $spreadsheet->getCell('A4')->setValue('PRODUCTION SHEET');
        $spreadsheet->getCell('A5')->setValue('Production Details Report');

        $spreadsheet->getCell('A7')->setValue('GRN #');
        $spreadsheet->getCell('B7')->setValue($headerData->grnno);

        $spreadsheet->getCell('A8')->setValue('Supplier');
        $spreadsheet->getCell('B8')->setValue($headerData->supplier_name);


        $spreadsheet->getCell('H7')->setValue('GRN Date');
        $spreadsheet->getCell('I7')->setValue($headerData->grndate);




        //body
        $data = $this->GetBodyData();
        $cell = 11;
        $row=1;

        $A = "A";
        $B = "B";
        $C = "C";
        $D = "D";
        $E = "E";
        $F = "F";
        foreach ($data as $dataRow) {


            if ($this->isOdd($row)) {
                $A = "A";
                $B = "B";
                $C = "C";
                $D = "D";
                $E = "E";
                $F = "F";
            } else {
                $A = "H";
                $B = "I";
                $C = "J";
                $D = "K";
                $E = "L";
                $F = "M";
                $cell--;
            }

            $spreadsheet->getCell($A . $cell)->setValue($dataRow->lot_serial_no);
            $spreadsheet->getCell($B . $cell)->setValue($dataRow->fish_type_id);
            $spreadsheet->getCell($C . $cell)->setValue($dataRow->fish_type_id);
            $spreadsheet->getCell($D . $cell)->setValue($dataRow->fish_type_id);
            $spreadsheet->getCell($E . $cell)->setValue($dataRow->fish_type_id);
            $spreadsheet->getCell($F . $cell)->setValue($dataRow->fish_type_id);

            $cell++;
            $row++;
        }
        $this->endCell=$cell;
        $spreadsheet->getCell("A".$this->endCell+2)->setValue("$cell");

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
        $spreadsheet->getStyle("A10:M$cell")->applyFromArray($styleArray);

        // Header & Footer
        $spreadsheet->getHeaderFooter()->setOddHeader('&L&D &T' . '&RPage &P of &N');
        $spreadsheet->getHeaderFooter()->setOddFooter('ISSUE NO     ' . 'DATE     ' . 'PREPARED BY     ' . 'APPROVED BY     ' . 'PAGE NO     ' . 'LOCATION');
    }
    public function columnWidths(): array
    {
        return [
            // Max - 90 for A4
            'A' => 8,       //Fish No
            'B' => 8,       //Fish Species
            'C' => 8,      //Fish Barcode
            'D' => 8,      //Presentation Type
            'E' => 8,      //Supplier Grade
            'F' => 8,      //Size Category
            'G' => 2,      //Net Weight
            'H' => 8,      //Fish Temperature
            'I' => 8,      //Boat Tank No
            'J' => 8,      //Boat Tank Temperature
            'K' => 8,      //Boat Tank Temperature
            'L' => 8,      //Boat Tank Temperature
            'M' => 8,      //Boat Tank Temperature
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
                ->where('lot_grnno', $this->GRNno)
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
    private  function isOdd($number)
    {
        try {
            if (((int)$number % 2) == 0) {
                return false;
            } else {
                return true;
            }
            //code...
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
