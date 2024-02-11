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

class GRNFishDetails implements WithHeadings, WithStyles, WithColumnWidths, WithDrawings, WithCustomStartCell
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
        return 'A13';
    }

    public function headings(): array
    {
        return [
            'Fish No',
            'Species',
            'Barcode',
            'Presentation',
            'Grade',
            'Size',
            'Net Weight',
            'Fish Temp.',
            'Boat Tank No',
            'Tank Temp.',
        ];
    }

    public function styles(Worksheet $spreadsheet)
    {
        //View Hide PDF Gridlines
        $spreadsheet->setShowGridlines(false);

        //Page Size & Sclae
        $spreadsheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $spreadsheet->getPageSetup()->setFitToHeight(0);

        //Repeat Rows
        $spreadsheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 13);

        //Row Style
        $spreadsheet->getStyle('C3')->getFont()->setName('Roboto')->setBold(true)->setSize(15);
        $spreadsheet->getStyle('C5')->getFont()->setName('Roboto')->setBold(true)->setSize(20);

        $spreadsheet->getStyle('A8:A11')->getFont()->setBold(true);
        $spreadsheet->getStyle('D8')->getFont()->setBold(true);
        $spreadsheet->getStyle('G8:G11')->getFont()->setBold(true);

        $spreadsheet->getStyle('A13:J13')->getFont()->setBold(true);


        $spreadsheet->getStyle('A13:J13')->getBorders();


        //ALignments
        $spreadsheet->getStyle('A13:J13')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $spreadsheet->getStyle('C3:J6')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $spreadsheet->getStyle('A8:J11')->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);


        //Setting Row Heights
        $spreadsheet->getRowDimension('1')->setRowHeight(0);
        $spreadsheet->getRowDimension('2')->setRowHeight(0);
        $spreadsheet->getRowDimension('7')->setRowHeight(15);
        $spreadsheet->getRowDimension('12')->setRowHeight(15);

        //Mergings
        $spreadsheet->mergeCells('A1:B1');
        $spreadsheet->mergeCells('C1:H1');
        $spreadsheet->mergeCells('I1:J1');

        $spreadsheet->mergeCells('A2:J2');

        $spreadsheet->mergeCells('A3:B6');

        $spreadsheet->mergeCells('C3:J4');
        $spreadsheet->mergeCells('C5:J5');
        $spreadsheet->mergeCells('C6:J6');

        $spreadsheet->mergeCells('A7:J7');

        $spreadsheet->mergeCells('B8:C8');
        $spreadsheet->mergeCells('E8:F8');
        $spreadsheet->mergeCells('H8:J8');

        $spreadsheet->mergeCells('B9:C9');
        $spreadsheet->mergeCells('E9:F9');
        $spreadsheet->mergeCells('H9:J9');

        $spreadsheet->mergeCells('B10:F10');
        $spreadsheet->mergeCells('H10:J10');

        $spreadsheet->mergeCells('B11:F11');
        $spreadsheet->mergeCells('H11:J11');

        $spreadsheet->mergeCells('A12:J12');




        // Text


        // $spreadsheet->getCell('A1')->setValue('2022-05-20 12:27 PM');
        // $spreadsheet->getCell('I1')->setValue('Page 01/01');

        $headerData = $this->GetHeaderdata();

        $spreadsheet->getCell('C3')->setValue('H&M Western (Pvt) Ltd');
        $spreadsheet->getCell('C5')->setValue('GOODS RECEIVED NOTE');
        $spreadsheet->getCell('C6')->setValue('Fish Details Report');

        $spreadsheet->getCell('A8')->setValue('GRN#');
        $spreadsheet->getCell('B8')->setValue($headerData->grnno);
        $spreadsheet->getCell('D8')->setValue('GRN Date');
        $spreadsheet->getCell('E8')->setValue($headerData->grndate);
        $spreadsheet->getCell('G8')->setValue('Boat Reg#');
        $spreadsheet->getCell('H8')->setValue($headerData->BoatRegNo);

        $spreadsheet->getCell('A9')->setValue('Batch#');
        $spreadsheet->getCell('B9')->setValue($headerData->batch_no);
        $spreadsheet->getCell('D9')->setValue('Method');
        $spreadsheet->getCell('E9')->setValue($headerData->CatchMethodName);
        $spreadsheet->getCell('G9')->setValue('Trip from');
        $spreadsheet->getCell('H9')->setValue($headerData->boat_trip_start_date);

        $spreadsheet->getCell('A10')->setValue('Supplier');
        $spreadsheet->getCell('B10')->setValue($headerData->supplier_name);
        $spreadsheet->getCell('G10')->setValue('Trip to');
        $spreadsheet->getCell('H10')->setValue($headerData->boat_trip_end_date);

        $spreadsheet->getCell('A11')->setValue('Skipper');
        $spreadsheet->getCell('B11')->setValue($headerData->boat_skipper_name);
        $spreadsheet->getCell('G11')->setValue('Crew #');
        $spreadsheet->getCell('H11')->setValue($headerData->boat_number_of_crew);

        //body
        $data = $this->GetBodyData();
        $cell = 14;
        foreach ($data as $dataRow) {
            $spreadsheet->getCell("A$cell")->setValue($dataRow->lot_serial_no);
            $spreadsheet->getCell("B$cell")->setValue($dataRow->FishCode);
            $spreadsheet->getCell("C$cell")->setValue($dataRow->lot_barcode);
            $spreadsheet->getCell("D$cell")->setValue($dataRow->presentation);
            $spreadsheet->getCell("E$cell")->setValue($dataRow->quality_grade);
            $spreadsheet->getCell("F$cell")->setValue($dataRow->SizeDescription);
            $spreadsheet->getCell("G$cell")->setValue($dataRow->net_weight);
            $spreadsheet->getCell("H$cell")->setValue($dataRow->fish_temperature);
            $spreadsheet->getCell("I$cell")->setValue($dataRow->boat_tank_no);
            $spreadsheet->getCell("J$cell")->setValue($dataRow->boat_tank_temp);

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
        $spreadsheet->getStyle("A13:J$cell")->applyFromArray($styleArray);

        // Header & Footer
        $spreadsheet->getHeaderFooter()->setOddHeader('&L&D &T' . '&RPage &P of &N');
        $spreadsheet->getHeaderFooter()->setOddFooter('ISSUE NO     ' . 'DATE     ' . 'PREPARED BY     ' . 'APPROVED BY     ' . 'PAGE NO     ' . 'LOCATION');


        // $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        // $drawing2->setName('PhpSpreadsheet logo');
        // $drawing2->setPath('/temp_reports/iso_footer.png');
        // $drawing2->setCoordinates('A3');
        // $spreadsheet->getHeaderFooter()->addImage($drawing2, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);

    }


    public function columnWidths(): array
    {
        return [
            // Max - 90 for A4
            'A' => 9,       //Fish No
            'B' => 13,       //Fish Species
            'C' => 15,      //Fish Barcode
            'D' => 13,      //Presentation Type
            'E' => 8,      //Supplier Grade
            'F' => 10,      //Size Category
            'G' => 10,      //Net Weight
            'H' => 7,      //Fish Temperature
            'I' => 10,      //Boat Tank No
            'J' => 7,      //Boat Tank Temperature
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/temp_reports/logo.png'));
        $drawing->setHeight(80);
        $drawing->setCoordinates('A3');

        return $drawing;
    }



    public function backgroundColor()
    {
        // Return RGB color code.
        return '00300';
    }
    private function GetBodyData()
    {
        // try {
        //     return GRNDetail::select('lot_serial_no', 'fish_type_id', 'lot_barcode', 'presentation', 'quality_grade', 'supplier_grade', 'item_size_id', 'net_weight', 'fish_temperature')
        //         ->where('lot_grnno',$this->GRNno)
        //         ->get();
        // } catch (Exception $Ex) {
        //     return $Ex->getMessage();
        // }


        try {
            return DB::table('buying_fish_grn_dtl')
                ->select(
                'buying_fish_grn_dtl.lot_serial_no',
                'sf_fish_species.FishCode',
                'buying_fish_grn_dtl.lot_barcode',
                'buying_fish_grn_dtl.presentation',
                'buying_fish_grn_dtl.quality_grade',
                'buying_grn_fish_size_matrix.SizeDescription',
                'buying_fish_grn_dtl.net_weight',
                'buying_fish_grn_dtl.fish_temperature',
                'buying_fish_grn_dtl.boat_tank_no',
                'buying_fish_grn_dtl.boat_tank_temp'
                )
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'buying_fish_grn_dtl.fish_type_id')
                ->leftJoin('buying_grn_fish_size_matrix', 'buying_grn_fish_size_matrix.id', '=', 'buying_fish_grn_dtl.item_size_id')
                ->where('buying_fish_grn_dtl.lot_grnno', $this->GRNno)
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
                'buying_fish_grn_hd.batch_no',
                'buying_suppliers.supplier_name',
                'buying_fish_grn_hd.boat_skipper_name',
                'buying_fish_grn_hd.grndate',
                'buying_fish_grn_hd.boat_trip_start_date',
                'buying_fish_grn_hd.boat_trip_end_date',
                'sf_catch_method.CatchMethodName',
                'buying_fish_grn_hd.boat_number_of_crew',
                'sf_boats.BoatRegNo',
            ];
            return DB::table('buying_fish_grn_hd')
                ->leftJoin('buying_suppliers', 'buying_suppliers.id', '=', 'buying_fish_grn_hd.supplier_id')
                ->leftJoin('sf_boats', 'sf_boats.id', '=', 'buying_fish_grn_hd.boat_id')
                ->leftJoin('sf_catch_method', 'sf_catch_method.id', '=', 'buying_fish_grn_hd.boat_fishing_method_id')
                ->where('buying_fish_grn_hd.grnno', $this->GRNno)
                ->select($arr)
                ->first();
        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }
}
