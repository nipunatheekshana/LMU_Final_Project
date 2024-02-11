<?php

namespace Modules\Mnu\Http\Controllers\Reports;

use Exception;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Modules\Mnu\Entities\PackingBox;

class DetailedPackingList implements WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $EplId;
    function __construct($EplId)
    {
        $this->EplId = $EplId;
    }

    public function styles(Worksheet $spreadsheet)
    {
        $pageNo = 1;

        //View Hide PDF Gridlines
        $spreadsheet->setShowGridlines(false);

        $spreadsheet->getStyle('A:Z')->getFont()->setName('DejaVuSans')->setSize(8);
        $spreadsheet->getStyle('A1:N6')->getFont()->setName('DejaVuSans')->setSize(10);

        $spreadsheet->getStyle('A1:N2')->getAlignment()->setHorizontal('Center');
        $spreadsheet->getStyle('A:Z')->getAlignment()->setVertical('Center');


        $spreadsheet->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getRowDimension('7')->setRowHeight(20);


        //Set Column Widths
        $spreadsheet->getColumnDimension('A')->setWidth(11);
        $spreadsheet->getColumnDimension('B')->setWidth(5);
        $spreadsheet->getColumnDimension('C')->setWidth(6);
        $spreadsheet->getColumnDimension('D')->setWidth(10);
        $spreadsheet->getColumnDimension('E')->setWidth(2);
        $spreadsheet->getColumnDimension('F')->setWidth(11);
        $spreadsheet->getColumnDimension('G')->setWidth(5);
        $spreadsheet->getColumnDimension('H')->setWidth(6);
        $spreadsheet->getColumnDimension('I')->setWidth(10);
        $spreadsheet->getColumnDimension('J')->setWidth(2);
        $spreadsheet->getColumnDimension('K')->setWidth(11);
        $spreadsheet->getColumnDimension('L')->setWidth(6);
        $spreadsheet->getColumnDimension('M')->setWidth(5);
        $spreadsheet->getColumnDimension('N')->setWidth(10);

        //Mergings
        $spreadsheet->mergeCells('A1:C1'); // PL No
        $spreadsheet->mergeCells('D1:K1'); // Company Name
        $spreadsheet->mergeCells('L1:N1'); // Page No

        $spreadsheet->mergeCells('A2:C2'); // Destination Code
        $spreadsheet->mergeCells('D2:K2'); // Export Packing List Title
        $spreadsheet->mergeCells('L2:N2'); // Empty

        $spreadsheet->mergeCells('A3:B3'); // Customer
        $spreadsheet->mergeCells('C3:G3'); // Customer Details

        $spreadsheet->mergeCells('H3:I3'); // Date
        $spreadsheet->mergeCells('J3:N3'); // Date Details

        $spreadsheet->mergeCells('A4:B4'); // Customer
        $spreadsheet->mergeCells('C4:G4'); // Customer Details

        $spreadsheet->mergeCells('H4:I4'); // Date
        $spreadsheet->mergeCells('J4:N4'); // Date Details

        $spreadsheet->mergeCells('A5:B5'); // Customer
        $spreadsheet->mergeCells('C5:G5'); // Customer Details

        $spreadsheet->mergeCells('H5:I5'); // Date
        $spreadsheet->mergeCells('J5:N5'); // Date Details

        $spreadsheet->mergeCells('A6:B6'); // Customer
        $spreadsheet->mergeCells('C6:G6'); // Customer Details

        $spreadsheet->mergeCells('H6:I6'); // Date
        $spreadsheet->mergeCells('J6:N6'); // Date Details

        $headerData = $this->GetHeaderdata();




        // Top Details

        $spreadsheet->setCellValue('A1', 'JSF/PD/001/II')->getStyle('A1')->getFont()->setBold(true)->setSize(10);
        $spreadsheet->getStyle("A1:A1")->getBorders()->getOutline()->setBorderStyle('thin');

        $spreadsheet->setCellValue('D1', 'JOHN SEA FOODS (PVT) LTD')->getStyle('D1')->getFont()->setBold(true)->setSize(12);

        $spreadsheet->setCellValue('L1', 'Page No : ' . $pageNo);
        $spreadsheet->getStyle('L1')->getAlignment()->setHorizontal('right');

        $spreadsheet->setCellValue('D2', 'DETAILED PACKING LIST')->getStyle('D2')->getFont()->setBold(true)->setSize(10);

        // Set Border Header
        $spreadsheet->getStyle("A3:N6")->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Set Customer
        $spreadsheet->setCellValue('A3', 'Customer')->getStyle('A3')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C3', 'W.G. den Heijer ZN');

        // Set Date
        $spreadsheet->setCellValue('H3', 'Date')->getStyle('H3')->getFont()->setBold(true);
        $spreadsheet->setCellValue('J3', '2023-05-01');

        // Set PL No
        $spreadsheet->setCellValue('A4', 'PL No')->getStyle('A4')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C4', 'PL65648');

        // Set PL Date
        $spreadsheet->setCellValue('H4', 'PL Date')->getStyle('H4')->getFont()->setBold(true);
        $spreadsheet->setCellValue('J4', '2023-05-01');

        // Set INV No
        $spreadsheet->setCellValue('A5', 'INV No')->getStyle('A5')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C5', '176-32764351');

        // Set INV Date
        $spreadsheet->setCellValue('H5', 'INV Date')->getStyle('H5')->getFont()->setBold(true);
        $spreadsheet->setCellValue('J5', '2023-05-01');

        // Set Cust Order No
        $spreadsheet->setCellValue('A6', 'Cust Order No')->getStyle('A6')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C6', 'SOD96565454');

        // Set INV Date
        $spreadsheet->setCellValue('H6', 'Cust PO No')->getStyle('H6')->getFont()->setBold(true);
        $spreadsheet->setCellValue('J6', '656505');

        $spreadsheet->getStyle('A3:N6')->getAlignment()->setHorizontal('left')->setIndent(1);



        // Tables - Main Title Row
        $spreadsheet->getStyle('A8:N8')->getAlignment()->setHorizontal('center');

        $spreadsheet->setCellValue('A8', 'GRN No')->getStyle('A8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('B8', 'Fish#')->getStyle('B8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C8', 'Pcs#')->getStyle('C8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('D8', 'Weight#')->getStyle('D8')->getFont()->setBold(true);
        $spreadsheet->getStyle("A8:D8")->getBorders()->getAllBorders()->setBorderStyle('thin');

        $spreadsheet->setCellValue('F8', 'GRN No')->getStyle('F8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('G8', 'Fish#')->getStyle('G8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('H8', 'Pcs#')->getStyle('H8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('I8', 'Weight')->getStyle('I8')->getFont()->setBold(true);
        $spreadsheet->getStyle("F8:I8")->getBorders()->getAllBorders()->setBorderStyle('thin');

        $spreadsheet->setCellValue('K8', 'GRN No')->getStyle('K8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('L8', 'Fish#')->getStyle('L8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('M8', 'Pcs#')->getStyle('M8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('N8', 'Weight')->getStyle('N8')->getFont()->setBold(true);
        $spreadsheet->getStyle("K8:N8")->getBorders()->getAllBorders()->setBorderStyle('thin');



        $items = [
            ['1', 'TUNA-H&G-AA', '', '', '12', '81.500', '', '2', 'TUNA H&G AAA', '', '', '5', '45.310']
        ];




        $box_hd = $this->GetBoxes();
        // $box_hd =[];


        $box_pcs = $this->GetBoxPcs();
        // $box_pcs = [];


        $row = 10;   // 52          (Add 46)
        $column = 65;  //65   70   75      (Add 5) (Last Deduct 10)
        $lastrow = 5;

        foreach ($box_hd as $box) {

            foreach ($box as $key => $value) {
                $cell = chr($column + $key) . $row;
                // Merge Row Data Cells
                $spreadsheet->mergeCells(chr($column + 1) . $row . ':' . chr($column + 3) . $row);
                // Set Value to Cell
                $spreadsheet->setCellValue($cell, $value)->getStyle($cell)->getFont()->setBold(true);;
                $spreadsheet->getStyle($cell)->getAlignment()->setHorizontal('center');
                $spreadsheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle('thin');
                $spreadsheet->getRowDimension($row)->setRowHeight(10);
            }
            $row = $row + 1;

            // Set Last Row
            if ($row >= $lastrow) {
                $lastrow = $row;
            }

            if ($row % 52  == 0) {
                $column = $column + 5;
                $row = $row - 42;
            }

            if ($column == 80) {
                $column = 65;
                $row = $row + 52;
                $pageNo++;

                $spreadsheet->mergeCells('A' . $row - 9 . ':C' . $row - 9); // PL No
                $spreadsheet->mergeCells('D' . $row - 9 . ':K' . $row - 9); // Company Name
                $spreadsheet->mergeCells('L' . $row - 9 . ':N' . $row - 9); // Page No

                $spreadsheet->mergeCells('A' . $row - 8 . ':C' . $row - 8); // Destination Code
                $spreadsheet->mergeCells('D' . $row - 8 . ':K' . $row - 8); // Export Packing List Title
                $spreadsheet->mergeCells('L' . $row - 8 . ':N' . $row - 8); // Empty

                $spreadsheet->mergeCells('A' . $row - 7 . ':B' . $row - 7); // Customer
                $spreadsheet->mergeCells('C' . $row - 7 . ':G' . $row - 7); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 7 . ':I' . $row - 7); // Date
                $spreadsheet->mergeCells('J' . $row - 7 . ':N' . $row - 7); // Date Details

                $spreadsheet->mergeCells('A' . $row - 6 . ':B' . $row - 6); // Customer
                $spreadsheet->mergeCells('C' . $row - 6 . ':G' . $row - 6); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 6 . ':I' . $row - 6); // Date
                $spreadsheet->mergeCells('J' . $row - 6 . ':N' . $row - 6); // Date Details

                $spreadsheet->mergeCells('A' . $row - 5 . ':B' . $row - 5); // Customer
                $spreadsheet->mergeCells('C' . $row - 5 . ':G' . $row - 5); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 5 . ':I' . $row - 5); // Date
                $spreadsheet->mergeCells('J' . $row - 5 . ':N' . $row - 5); // Date Details

                $spreadsheet->mergeCells('A' . $row - 4 . ':B' . $row - 4); // Customer
                $spreadsheet->mergeCells('C' . $row - 4 . ':G' . $row - 4); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 4 . ':I' . $row - 4); // Date
                $spreadsheet->mergeCells('J' . $row - 4 . ':N' . $row - 4); // Date Details

                $spreadsheet->getStyle('A' . $row - 9 . ':N' . $row - 8)->getAlignment()->setHorizontal('center');
                $spreadsheet->getRowDimension($row - 9)->setRowHeight(20);
                $spreadsheet->getRowDimension($row - 8)->setRowHeight(20);

                // Top Details

                $spreadsheet->setCellValue('A' . $row - 9, 'JSF/PD/001/II')->getStyle('A' . $row - 9)->getFont()->setBold(true)->setSize(10);
                $spreadsheet->getStyle('A' . $row - 9)->getBorders()->getOutline()->setBorderStyle('thin');

                $spreadsheet->setCellValue('D' . $row - 9, 'JOHN SEA FOODS (PVT) LTD')->getStyle('D' . $row - 9)->getFont()->setBold(true)->setSize(13);

                $spreadsheet->setCellValue('L' . $row - 9, 'Page No : ' . $pageNo);
                $spreadsheet->getStyle('L' . $row - 9)->getAlignment()->setHorizontal('right');

                $spreadsheet->setCellValue('D' . $row - 8, 'DETAILED PACKING LIST')->getStyle('D' . $row - 8)->getFont()->setBold(true)->setSize(10);

                $spreadsheet->getRowDimension($row - 7)->setRowHeight(15);
                $spreadsheet->getRowDimension($row - 6)->setRowHeight(15);
                $spreadsheet->getRowDimension($row - 5)->setRowHeight(15);
                $spreadsheet->getRowDimension($row - 4)->setRowHeight(15);

                // Set Border Header
                $spreadsheet->getStyle('A' . $row - 7 . ':N' . $row - 4)->getBorders()->getAllBorders()->setBorderStyle('thin');

                // Set Customer
                $spreadsheet->setCellValue('A' . $row - 7, 'Customer')->getStyle('A' . $row - 7)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 7, 'W.G. den Heijer ZN');

                // Set Date
                $spreadsheet->setCellValue('H' . $row - 7, 'Date')->getStyle('H' . $row - 7)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 7, '2023-05-01');

                // Set PL No
                $spreadsheet->setCellValue('A' . $row - 6, 'PL No')->getStyle('A' . $row - 6)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 6, 'PL65648');

                // Set PL Date
                $spreadsheet->setCellValue('H' . $row - 6, 'PL Date')->getStyle('H' . $row - 6)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 6, '2023-05-01');

                // Set INV No
                $spreadsheet->setCellValue('A' . $row - 5, 'INV No')->getStyle('A' . $row - 5)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 5, '176-32764351');

                // Set INV Date
                $spreadsheet->setCellValue('H' . $row - 5, 'INV Date')->getStyle('H' . $row - 5)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 5, '2023-05-01');

                // Set Cust Order No
                $spreadsheet->setCellValue('A' . $row - 4, 'Cust Order No')->getStyle('A' . $row - 4)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 4, 'SOD96565454');

                // Set INV Date
                $spreadsheet->setCellValue('H' . $row - 4, 'Cust PO No')->getStyle('H' . $row - 4)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 4, '656505');

                $spreadsheet->getStyle('A' . $row - 7 . ':N' . $row - 4)->getAlignment()->setHorizontal('left')->setIndent(1);



                // Tables - Main Title Row
                $spreadsheet->getStyle('A' . $row - 2 . ':N' . $row - 2)->getAlignment()->setHorizontal('center');

                $spreadsheet->setCellValue('A' . $row - 2, 'GRN No')->getStyle('A' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('B' . $row - 2, 'Fish#')->getStyle('B' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 2, 'Pcs#')->getStyle('C' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('D' . $row - 2, 'Weight#')->getStyle('D' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->getStyle('A' . $row - 2 . ':D' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');

                $spreadsheet->setCellValue('F' . $row - 2, 'GRN No')->getStyle('F' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('G' . $row - 2, 'Fish#')->getStyle('G' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('H' . $row - 2, 'Pcs#')->getStyle('H' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('I' . $row - 2, 'Weight')->getStyle('I' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->getStyle('F' . $row - 2 . ':I' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');

                $spreadsheet->setCellValue('K' . $row - 2, 'GRN No')->getStyle('K' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('L' . $row - 2, 'Fish#')->getStyle('L' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('M' . $row - 2, 'Pcs#')->getStyle('M' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('N' . $row - 2, 'Weight')->getStyle('N' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->getStyle('K' . $row - 2 . ':N' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');
            }

            foreach ($box_pcs as $key => $pcs) {
                if ($pcs[0] == $box[0]) {
                    // skip the first element of $pcs
                    for ($i = 1; $i < count($pcs); $i++) {
                        $cell = chr($column - 1 + $i) . $row;
                        $spreadsheet->setCellValue($cell, $pcs[$i]);
                        $spreadsheet->getStyle($cell)->getAlignment()->setHorizontal('center');
                        $spreadsheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle('thin');
                        $spreadsheet->getRowDimension($row)->setRowHeight(10);
                    }
                    $row = $row + 1;

                    // Set Last Row
                    if ($row >= $lastrow) {
                        $lastrow = $row;
                    }

                    if ($row % 52  == 0) {
                        $column = $column + 5;
                        $row = $row - 42;
                    }


                    // if ($row < 50) {
                    //     if ($row % 52  == 0) {
                    //         $column = $column + 5;
                    //         $row = $row - 42;
                    //     }
                    // }
                    // else {
                    //     if ($row % 52  == 0) {
                    //         $column = $column + 5;
                    //         $row = $row - 45;
                    //     }
                    // }



                    if ($column == 80) {
                        $column = 65;
                        $row = $row + 52;
                        $pageNo++;

                        $spreadsheet->mergeCells('A' . $row - 9 . ':C' . $row - 9); // PL No
                        $spreadsheet->mergeCells('D' . $row - 9 . ':K' . $row - 9); // Company Name
                        $spreadsheet->mergeCells('L' . $row - 9 . ':N' . $row - 9); // Page No

                        $spreadsheet->mergeCells('A' . $row - 8 . ':C' . $row - 8); // Destination Code
                        $spreadsheet->mergeCells('D' . $row - 8 . ':K' . $row - 8); // Export Packing List Title
                        $spreadsheet->mergeCells('L' . $row - 8 . ':N' . $row - 8); // Empty

                        $spreadsheet->getStyle('A' . $row - 9 . ':N' . $row - 8)->getAlignment()->setHorizontal('center');
                        $spreadsheet->getRowDimension($row - 9)->setRowHeight(20);
                        $spreadsheet->getRowDimension($row - 8)->setRowHeight(20);

                        $spreadsheet->mergeCells('A' . $row - 7 . ':B' . $row - 7); // Customer
                        $spreadsheet->mergeCells('C' . $row - 7 . ':G' . $row - 7); // Customer Details

                        $spreadsheet->mergeCells('H' . $row - 7 . ':I' . $row - 7); // Date
                        $spreadsheet->mergeCells('J' . $row - 7 . ':N' . $row - 7); // Date Details

                        $spreadsheet->mergeCells('A' . $row - 6 . ':B' . $row - 6); // Customer
                        $spreadsheet->mergeCells('C' . $row - 6 . ':G' . $row - 6); // Customer Details

                        $spreadsheet->mergeCells('H' . $row - 6 . ':I' . $row - 6); // Date
                        $spreadsheet->mergeCells('J' . $row - 6 . ':N' . $row - 6); // Date Details

                        $spreadsheet->mergeCells('A' . $row - 5 . ':B' . $row - 5); // Customer
                        $spreadsheet->mergeCells('C' . $row - 5 . ':G' . $row - 5); // Customer Details

                        $spreadsheet->mergeCells('H' . $row - 5 . ':I' . $row - 5); // Date
                        $spreadsheet->mergeCells('J' . $row - 5 . ':N' . $row - 5); // Date Details

                        $spreadsheet->mergeCells('A' . $row - 4 . ':B' . $row - 4); // Customer
                        $spreadsheet->mergeCells('C' . $row - 4 . ':G' . $row - 4); // Customer Details

                        $spreadsheet->mergeCells('H' . $row - 4 . ':I' . $row - 4); // Date
                        $spreadsheet->mergeCells('J' . $row - 4 . ':N' . $row - 4); // Date Details

                        // Top Details

                        $spreadsheet->setCellValue('A' . $row - 9, 'JSF/PD/001/II')->getStyle('A' . $row - 9)->getFont()->setBold(true)->setSize(10);
                        $spreadsheet->getStyle('A' . $row - 9)->getBorders()->getOutline()->setBorderStyle('thin');

                        $spreadsheet->setCellValue('D' . $row - 9, 'JOHN SEA FOODS (PVT) LTD')->getStyle('D' . $row - 9)->getFont()->setBold(true)->setSize(13);

                        $spreadsheet->setCellValue('L' . $row - 9, 'Page No : ' . $pageNo);
                        $spreadsheet->getStyle('L' . $row - 9)->getAlignment()->setHorizontal('right');

                        $spreadsheet->setCellValue('D' . $row - 8, 'DETAILED PACKING LIST')->getStyle('D' . $row - 8)->getFont()->setBold(true)->setSize(10);

                        $spreadsheet->getRowDimension($row - 7)->setRowHeight(15);
                        $spreadsheet->getRowDimension($row - 6)->setRowHeight(15);
                        $spreadsheet->getRowDimension($row - 5)->setRowHeight(15);
                        $spreadsheet->getRowDimension($row - 4)->setRowHeight(15);

                        // Set Border Header
                        $spreadsheet->getStyle('A' . $row - 7 . ':N' . $row - 4)->getBorders()->getAllBorders()->setBorderStyle('thin');

                        // Set Customer
                        $spreadsheet->setCellValue('A' . $row - 7, 'Customer')->getStyle('A' . $row - 7)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('C' . $row - 7, 'W.G. den Heijer ZN');

                        // Set Date
                        $spreadsheet->setCellValue('H' . $row - 7, 'Date')->getStyle('H' . $row - 7)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('J' . $row - 7, '2023-05-01');

                        // Set PL No
                        $spreadsheet->setCellValue('A' . $row - 6, 'PL No')->getStyle('A' . $row - 6)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('C' . $row - 6, 'PL65648');

                        // Set PL Date
                        $spreadsheet->setCellValue('H' . $row - 6, 'PL Date')->getStyle('H' . $row - 6)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('J' . $row - 6, '2023-05-01');

                        // Set INV No
                        $spreadsheet->setCellValue('A' . $row - 5, 'INV No')->getStyle('A' . $row - 5)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('C' . $row - 5, '176-32764351');

                        // Set INV Date
                        $spreadsheet->setCellValue('H' . $row - 5, 'INV Date')->getStyle('H' . $row - 5)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('J' . $row - 5, '2023-05-01');

                        // Set Cust Order No
                        $spreadsheet->setCellValue('A' . $row - 4, 'Cust Order No')->getStyle('A' . $row - 4)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('C' . $row - 4, 'SOD96565454');

                        // Set INV Date
                        $spreadsheet->setCellValue('H' . $row - 4, 'Cust PO No')->getStyle('H' . $row - 4)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('J' . $row - 4, '656505');

                        $spreadsheet->getStyle('A' . $row - 7 . ':N' . $row - 4)->getAlignment()->setHorizontal('left')->setIndent(1);



                        // Tables - Main Title Row
                        $spreadsheet->getStyle('A' . $row - 2 . ':N' . $row - 2)->getAlignment()->setHorizontal('center');

                        $spreadsheet->setCellValue('A' . $row - 2, 'GRN No')->getStyle('A' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('B' . $row - 2, 'Fish#')->getStyle('B' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('C' . $row - 2, 'Pcs#')->getStyle('C' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('D' . $row - 2, 'Weight#')->getStyle('D' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->getStyle('A' . $row - 2 . ':D' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');

                        $spreadsheet->setCellValue('F' . $row - 2, 'GRN No')->getStyle('F' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('G' . $row - 2, 'Fish#')->getStyle('G' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('H' . $row - 2, 'Pcs#')->getStyle('H' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('I' . $row - 2, 'Weight')->getStyle('I' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->getStyle('F' . $row - 2 . ':I' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');

                        $spreadsheet->setCellValue('K' . $row - 2, 'GRN No')->getStyle('K' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('L' . $row - 2, 'Fish#')->getStyle('L' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('M' . $row - 2, 'Pcs#')->getStyle('M' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->setCellValue('N' . $row - 2, 'Weight')->getStyle('N' . $row - 2)->getFont()->setBold(true);
                        $spreadsheet->getStyle('K' . $row - 2 . ':N' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');
                    }
                }
            }
            $row = $row + 1;

            // Set Last Row
            if ($row >= $lastrow) {
                $lastrow = $row;
            }

            if ($row % 52  == 0) {
                $column = $column + 5;
                $row = $row - 42;
            }

            if ($column == 80) {
                $column = 65;
                $row = $row + 52;
                $pageNo++;

                $spreadsheet->mergeCells('A' . $row - 9 . ':C' . $row - 9); // PL No
                $spreadsheet->mergeCells('D' . $row - 9 . ':K' . $row - 9); // Company Name
                $spreadsheet->mergeCells('L' . $row - 9 . ':N' . $row - 9); // Page No

                $spreadsheet->mergeCells('A' . $row - 8 . ':C' . $row - 8); // Destination Code
                $spreadsheet->mergeCells('D' . $row - 8 . ':K' . $row - 8); // Export Packing List Title
                $spreadsheet->mergeCells('L' . $row - 8 . ':N' . $row - 8); // Empty

                $spreadsheet->getStyle('A' . $row - 9 . ':N' . $row - 8)->getAlignment()->setHorizontal('center');
                $spreadsheet->getRowDimension($row - 9)->setRowHeight(20);
                $spreadsheet->getRowDimension($row - 8)->setRowHeight(20);

                $spreadsheet->mergeCells('A' . $row - 7 . ':B' . $row - 7); // Customer
                $spreadsheet->mergeCells('C' . $row - 7 . ':G' . $row - 7); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 7 . ':I' . $row - 7); // Date
                $spreadsheet->mergeCells('J' . $row - 7 . ':N' . $row - 7); // Date Details

                $spreadsheet->mergeCells('A' . $row - 6 . ':B' . $row - 6); // Customer
                $spreadsheet->mergeCells('C' . $row - 6 . ':G' . $row - 6); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 6 . ':I' . $row - 6); // Date
                $spreadsheet->mergeCells('J' . $row - 6 . ':N' . $row - 6); // Date Details

                $spreadsheet->mergeCells('A' . $row - 5 . ':B' . $row - 5); // Customer
                $spreadsheet->mergeCells('C' . $row - 5 . ':G' . $row - 5); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 5 . ':I' . $row - 5); // Date
                $spreadsheet->mergeCells('J' . $row - 5 . ':N' . $row - 5); // Date Details

                $spreadsheet->mergeCells('A' . $row - 4 . ':B' . $row - 4); // Customer
                $spreadsheet->mergeCells('C' . $row - 4 . ':G' . $row - 4); // Customer Details

                $spreadsheet->mergeCells('H' . $row - 4 . ':I' . $row - 4); // Date
                $spreadsheet->mergeCells('J' . $row - 4 . ':N' . $row - 4); // Date Details

                // Top Details

                $spreadsheet->setCellValue('A' . $row - 9, 'JSF/PD/001/II')->getStyle('A' . $row - 9)->getFont()->setBold(true)->setSize(10);
                $spreadsheet->getStyle('A' . $row - 9)->getBorders()->getOutline()->setBorderStyle('thin');

                $spreadsheet->setCellValue('D' . $row - 9, 'JOHN SEA FOODS (PVT) LTD')->getStyle('D' . $row - 9)->getFont()->setBold(true)->setSize(13);

                $spreadsheet->setCellValue('L' . $row - 9, 'Page No : ' . $pageNo);
                $spreadsheet->getStyle('L' . $row - 9)->getAlignment()->setHorizontal('right');

                $spreadsheet->setCellValue('D' . $row - 8, 'DETAILED PACKING LIST')->getStyle('D' . $row - 8)->getFont()->setBold(true)->setSize(10);

                $spreadsheet->getRowDimension($row - 7)->setRowHeight(15);
                $spreadsheet->getRowDimension($row - 6)->setRowHeight(15);
                $spreadsheet->getRowDimension($row - 5)->setRowHeight(15);
                $spreadsheet->getRowDimension($row - 4)->setRowHeight(15);

                // Set Border Header
                $spreadsheet->getStyle('A' . $row - 7 . ':N' . $row - 4)->getBorders()->getAllBorders()->setBorderStyle('thin');

                // Set Customer
                $spreadsheet->setCellValue('A' . $row - 7, 'Customer')->getStyle('A' . $row - 7)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 7, 'W.G. den Heijer ZN');

                // Set Date
                $spreadsheet->setCellValue('H' . $row - 7, 'Date')->getStyle('H' . $row - 7)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 7, '2023-05-01');

                // Set PL No
                $spreadsheet->setCellValue('A' . $row - 6, 'PL No')->getStyle('A' . $row - 6)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 6, 'PL65648');

                // Set PL Date
                $spreadsheet->setCellValue('H' . $row - 6, 'PL Date')->getStyle('H' . $row - 6)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 6, '2023-05-01');

                // Set INV No
                $spreadsheet->setCellValue('A' . $row - 5, 'INV No')->getStyle('A' . $row - 5)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 5, '176-32764351');

                // Set INV Date
                $spreadsheet->setCellValue('H' . $row - 5, 'INV Date')->getStyle('H' . $row - 5)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 5, '2023-05-01');

                // Set Cust Order No
                $spreadsheet->setCellValue('A' . $row - 4, 'Cust Order No')->getStyle('A' . $row - 4)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 4, 'SOD96565454');

                // Set INV Date
                $spreadsheet->setCellValue('H' . $row - 4, 'Cust PO No')->getStyle('H' . $row - 4)->getFont()->setBold(true);
                $spreadsheet->setCellValue('J' . $row - 4, '656505');

                $spreadsheet->getStyle('A' . $row - 7 . ':N' . $row - 4)->getAlignment()->setHorizontal('left')->setIndent(1);

                // Tables - Main Title Row
                $spreadsheet->getStyle('A' . $row - 2 . ':N' . $row - 2)->getAlignment()->setHorizontal('center');

                $spreadsheet->setCellValue('A' . $row - 2, 'GRN No')->getStyle('A' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('B' . $row - 2, 'Fish#')->getStyle('B' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('C' . $row - 2, 'Pcs#')->getStyle('C' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('D' . $row - 2, 'Weight#')->getStyle('D' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->getStyle('A' . $row - 2 . ':D' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');

                $spreadsheet->setCellValue('F' . $row - 2, 'GRN No')->getStyle('F' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('G' . $row - 2, 'Fish#')->getStyle('G' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('H' . $row - 2, 'Pcs#')->getStyle('H' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('I' . $row - 2, 'Weight')->getStyle('I' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->getStyle('F' . $row - 2 . ':I' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');

                $spreadsheet->setCellValue('K' . $row - 2, 'GRN No')->getStyle('K' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('L' . $row - 2, 'Fish#')->getStyle('L' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('M' . $row - 2, 'Pcs#')->getStyle('M' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->setCellValue('N' . $row - 2, 'Weight')->getStyle('N' . $row - 2)->getFont()->setBold(true);
                $spreadsheet->getStyle('K' . $row - 2 . ':N' . $row - 2)->getBorders()->getAllBorders()->setBorderStyle('thin');
            }
        }

        // Summary Section

        $lastrow = $lastrow + 2;

        $spreadsheet->mergeCells('A' . $lastrow . ':B' . $lastrow);
        $spreadsheet->mergeCells('C' . $lastrow . ':J' . $lastrow);
        $spreadsheet->mergeCells('K' . $lastrow . ':L' . $lastrow);
        $spreadsheet->mergeCells('M' . $lastrow . ':N' . $lastrow);

        $spreadsheet->setCellValue('A' . $lastrow, 'Fish Code');
        $spreadsheet->setCellValue('C' . $lastrow, 'Item Name');
        $spreadsheet->setCellValue('K' . $lastrow, 'No of Boxes');
        $spreadsheet->setCellValue('M' . $lastrow, 'Net Weight');

        $spreadsheet->getStyle('A' . $lastrow . ':N' . $lastrow)->getFont()->setBold(true);
        $spreadsheet->getStyle('A' . $lastrow . ':N' . $lastrow)->getAlignment()->setHorizontal('center');

        $spreadsheet->getRowDimension($lastrow)->setRowHeight(20);

        // Setting Borders - Header
        $spreadsheet->getStyle('A' . $lastrow . ':M' . $lastrow)->getBorders()->getAllBorders()->setBorderStyle('thin');


        $summary = [];

        foreach ($items as $item) {
            $itemName = $item[1];
            $pcsQuantity = $item[4];
            $weight = $item[5];
            if (isset($summary[$itemName])) {
                $summary[$itemName]['pcsQuantity'] += 1;
                $summary[$itemName]['weight'] += $weight;
            } else {
                $summary[$itemName] = ['pcsQuantity' => 1, 'weight' => $weight];
            }
        }

        foreach ($items as $item) {
            $itemName = $item[8];
            $pcsQuantity = $item[11];
            $weight = $item[12];
            if (isset($summary[$itemName])) {
                $summary[$itemName]['pcsQuantity'] += 1;
                $summary[$itemName]['weight'] += $weight;
            } else {
                $summary[$itemName] = ['pcsQuantity' => 1, 'weight' => $weight];
            }
        }


        $lastrow = $lastrow + 1;

        foreach ($summary as $itemName => $values) {

            // Set Merges
            $spreadsheet->mergeCells('A' . $lastrow . ':B' . $lastrow);
            $spreadsheet->mergeCells('C' . $lastrow . ':J' . $lastrow);
            $spreadsheet->mergeCells('K' . $lastrow . ':L' . $lastrow);
            $spreadsheet->mergeCells('M' . $lastrow . ':N' . $lastrow);

            $spreadsheet->getStyle('A' . $lastrow . ':B' . $lastrow)->getAlignment()->setHorizontal('center');
            $spreadsheet->getStyle('C' . $lastrow . ':J' . $lastrow)->getAlignment()->setHorizontal('left')->setIndent(1);
            $spreadsheet->getStyle('K' . $lastrow . ':L' . $lastrow)->getAlignment()->setHorizontal('center');
            $spreadsheet->getStyle('M' . $lastrow . ':N' . $lastrow)->getAlignment()->setHorizontal('right')->setIndent(1);

            $spreadsheet->setCellValue('A' . $lastrow, "YFT");
            $spreadsheet->setCellValue('C' . $lastrow, $itemName);
            $spreadsheet->setCellValue('K' . $lastrow, $values['pcsQuantity']);
            $spreadsheet->setCellValue('M' . $lastrow, $values['weight']);

            $spreadsheet->getStyle('A' . $lastrow . ':N' . $lastrow)->getBorders()->getAllBorders()->setBorderStyle('thin');

            $spreadsheet->getRowDimension($lastrow)->setRowHeight(25);



            // Calculate total values
            $totalPcsQuantity = 0;
            $totalWeight = 0;
            foreach ($summary as $values) {
                $totalPcsQuantity += $values['pcsQuantity'];
                $totalWeight += $values['weight'];
            }

            $lastrow++;
        }

        // Total Row
        $spreadsheet->getStyle('A' . $lastrow . ':M' . $lastrow)->getBorders()->getAllBorders()->setBorderStyle('thin');

        $spreadsheet->mergeCells('A' . $lastrow . ':J' . $lastrow);
        $spreadsheet->mergeCells('K' . $lastrow . ':L' . $lastrow);
        $spreadsheet->mergeCells('M' . $lastrow . ':N' . $lastrow);

        $spreadsheet->getStyle('A' . $lastrow . ':L' . $lastrow)->getAlignment()->setHorizontal('center');
        $spreadsheet->getStyle('M' . $lastrow . ':N' . $lastrow)->getAlignment()->setHorizontal('right')->setIndent(1);
        $spreadsheet->getStyle('A' . $lastrow . ':M' . $lastrow)->getFont()->setBold(true);

        $spreadsheet->getRowDimension($lastrow)->setRowHeight(20);

        $spreadsheet->setCellValue('A' . $lastrow, "TOTAL");
        $spreadsheet->setCellValue('K' . $lastrow, $totalPcsQuantity);
        $spreadsheet->setCellValue('M' . $lastrow, $totalWeight);
    }




    private function GetBoxes()
    {
        try {
            $box_hd=[];
            $PackingBoxs=DB::table('mnu_packing_box_hd')
            ->where('mnu_packing_box_hd.pl_id',$this->EplId)
            ->join('inventory_items','inventory_items.id','=','mnu_packing_box_hd.prod_id')
            ->orderBy('mnu_packing_box_hd.box_no','asc')
            ->select([
                'mnu_packing_box_hd.box_no',
                'inventory_items.Item_Code'
            ])
            ->get();
            foreach ($PackingBoxs as $packingBox){
                array_push( $box_hd,[$packingBox->box_no,$packingBox->Item_Code]);
            }
            return $box_hd;

        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }
    private function GetBoxPcs(){
        try {
            $box_pcs=[];
            $Packingpcs=DB::table('mnu_production_dtl')
            ->join('mnu_packing_box_hd','mnu_packing_box_hd.id','=','mnu_production_dtl.box_id')
            ->where('mnu_packing_box_hd.pl_id',$this->EplId)
            ->orderBy('mnu_packing_box_hd.box_no','asc')
            ->select([
                'mnu_packing_box_hd.box_no',
                'mnu_production_dtl.lot_grn_no',
                'mnu_production_dtl.grn_lot_barcode',
                'mnu_production_dtl.PcsID',
                'mnu_production_dtl.pcs_weight',
            ])
            ->get();
            foreach ($Packingpcs as $Packingpc){
                array_push( $box_pcs,[$Packingpc->box_no,$Packingpc->lot_grn_no,$Packingpc->grn_lot_barcode,$Packingpc->PcsID,$Packingpc->pcs_weight]);
            }
            return $box_pcs;

        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }
    private function GetHeaderdata()
    {
        try {
            $arr = [
                'mnu_packing_list_hd.pl_number',
                'mnu_packing_list_hd.pl_date',
                'mnu_packing_list_hd.consignee_name',
                'mnu_packing_list_hd.consignee_add1',
                'mnu_packing_list_hd.consignee_add2',
                'mnu_packing_list_hd.consignee_city_towm',
                'mnu_packing_list_hd.consignee_postal_code',
                'mnu_packing_list_hd.consignee_country',
                'mnu_packing_list_hd.consignee_contact_nos',
                'mnu_packing_list_hd.consignee_email',
                'mnu_packing_list_hd.notify_name',
                'mnu_packing_list_hd.notify_add1',
                'mnu_packing_list_hd.notify_add2',
                'mnu_packing_list_hd.notify_city_towm',
                'mnu_packing_list_hd.notify_country',
                'mnu_packing_list_hd.notify_postal_code',
                'mnu_packing_list_hd.notify_contact_nos',
                'mnu_packing_list_hd.notify_email',
                'mnu_packing_list_hd.destination_code',
                'mnu_packing_list_hd.awb_no',
                'mnu_packing_list_hd.flight_no',
                'mnu_packing_list_hd.flight_date'
            ];
            return DB::table('mnu_packing_list_hd')
                ->where('mnu_packing_list_hd.id', $this->EplId)
                ->select($arr)
                ->first();
        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }
}
