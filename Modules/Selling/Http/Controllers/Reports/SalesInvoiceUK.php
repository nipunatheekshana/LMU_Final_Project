<?php

namespace Modules\Selling\Http\Controllers\Reports;

use Exception;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;


class SalesInvoiceUK implements WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $EPLNo;
    function __construct($EPLNo)
    {
        $this->EPLNo = $EPLNo;
    }

    public function styles(Worksheet $spreadsheet)
    {
        //View Hide PDF Gridlines
        $spreadsheet->setShowGridlines(false);
        $spreadsheet->getStyle('A:Z')->getFont()->setName('DejaVuSans')->setSize(10);
        $spreadsheet->getStyle('A1:M2')->getAlignment()->setHorizontal('Center');
        $spreadsheet->getStyle('A:Z')->getAlignment()->setVertical('Center');

        // Setting Borders - Header
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ];
        $spreadsheet->getStyle("A1:M8")->applyFromArray($styleArray);

        $spreadsheet->getRowDimension('1')->setRowHeight(25);
        $spreadsheet->getRowDimension('2')->setRowHeight(30);
        $spreadsheet->getRowDimension('3')->setRowHeight(25);
        $spreadsheet->getRowDimension('4')->setRowHeight(25);
        $spreadsheet->getRowDimension('5')->setRowHeight(25);
        $spreadsheet->getRowDimension('6')->setRowHeight(25);
        $spreadsheet->getRowDimension('7')->setRowHeight(25);
        $spreadsheet->getRowDimension('8')->setRowHeight(25);
        $spreadsheet->getRowDimension('9')->setRowHeight(12);
        $spreadsheet->getRowDimension('10')->setRowHeight(12);


        //Set Column Widths
        $spreadsheet->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getColumnDimension('B')->setWidth(4);
        $spreadsheet->getColumnDimension('C')->setWidth(15);
        $spreadsheet->getColumnDimension('D')->setWidth(15);
        $spreadsheet->getColumnDimension('E')->setWidth(6);
        $spreadsheet->getColumnDimension('F')->setWidth(8);
        $spreadsheet->getColumnDimension('G')->setWidth(2);
        $spreadsheet->getColumnDimension('H')->setWidth(6);
        $spreadsheet->getColumnDimension('I')->setWidth(15);
        $spreadsheet->getColumnDimension('J')->setWidth(7);
        $spreadsheet->getColumnDimension('K')->setWidth(6);
        $spreadsheet->getColumnDimension('L')->setWidth(4);
        $spreadsheet->getColumnDimension('M')->setWidth(8);

        //Mergings
        $spreadsheet->mergeCells('A1:C1'); // PL No
        $spreadsheet->mergeCells('D1:J1'); // Company Name
        $spreadsheet->mergeCells('K1:M1'); // Page No

        $spreadsheet->mergeCells('A2:C2'); // Destination Code
        $spreadsheet->mergeCells('D2:J2'); // Export Packing List Title
        $spreadsheet->mergeCells('K2:M2'); // Empty

        $spreadsheet->mergeCells('A3:B4'); // Exporter
        $spreadsheet->mergeCells('C3:F4'); // Exporter Details

        $spreadsheet->mergeCells('G3:H3'); // Country of Origin
        $spreadsheet->mergeCells('I3:M3'); // Country of Origin Details

        $spreadsheet->mergeCells('G4:H4'); // Customer PO No
        $spreadsheet->mergeCells('I4:M4'); // Customer PO No Details

        $spreadsheet->mergeCells('A5:B5'); // Consignee
        $spreadsheet->mergeCells('C5:F5'); // Consignee Details

        $spreadsheet->mergeCells('G5:H5'); // Notify
        $spreadsheet->mergeCells('I5:M5'); // Notify Details

        $spreadsheet->mergeCells('A6:B6'); // Flight No
        $spreadsheet->mergeCells('C6:C6'); // Flight No Details

        $spreadsheet->mergeCells('D6:D6'); // Flight Date
        $spreadsheet->mergeCells('E6:F6'); // Flight Date Details

        $spreadsheet->mergeCells('G6:I6'); // Total Boxes
        $spreadsheet->mergeCells('G7:I8'); // Total Boxes Details

        $spreadsheet->mergeCells('J6:M6'); // Total Net Weight
        $spreadsheet->mergeCells('J7:M8'); // Total Boxes Details

        $spreadsheet->mergeCells('A7:B7'); // AWB No
        $spreadsheet->mergeCells('C7:F7'); // Flight No Details

        $spreadsheet->mergeCells('A8:B8'); // AWB No
        $spreadsheet->mergeCells('C8:F8'); // Flight No Details

        $spreadsheet->mergeCells('A9:A9'); // Table Header- Box No
        $spreadsheet->mergeCells('B9:D9'); // Table Header- Product
        $spreadsheet->mergeCells('E9:E9'); // Table Header- Pcs
        $spreadsheet->mergeCells('F9:F9'); // Table Header- Weight
        $spreadsheet->mergeCells('G9:G9'); // Table Header- Empty
        $spreadsheet->mergeCells('H9:H9'); // Table Header- Box No
        $spreadsheet->mergeCells('I9:K9'); // Table Header- Product
        $spreadsheet->mergeCells('L9:L9'); // Table Header- Pcs
        $spreadsheet->mergeCells('M9:M9'); // Table Header- Weight

        $headerData = $this->GetHeaderdata();

        // Set Header
        $spreadsheet->setCellValue('A1', $headerData->pl_number)->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $spreadsheet->setCellValue('D1', 'JOHN SEA FOODS (PVT) LTD')->getStyle('D1')->getFont()->setBold(true)->setSize(12);
        $spreadsheet->setCellValue('K1', 'Page 1 of 4');

        $spreadsheet->setCellValue('A2', 'DEN')->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $spreadsheet->setCellValue('D2', 'EXPORT PACKING LIST')->getStyle('D2')->getFont()->setBold(true)->setSize(14);

        // Set the exporter and customer addresses
        $spreadsheet->setCellValue('A3', 'Exporter')->getStyle('A3')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C3', 'JOHN SEA FOODS (PVT) LTD, Kosgahawatta, De Silva Mawatha, Kaluwarippuwa, Tel : (+94) 0312242700/ (+94) 766906188, E-mail : marketingjsf@sltnet.lk');
        $spreadsheet->getStyle('C3')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('G3', 'Country of Origin')->getStyle('G3')->getFont()->setBold(true);
        $spreadsheet->setCellValue('I3', 'SRI LANKA');
        $spreadsheet->getStyle('I3')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('G4', 'Cus PO#')->getStyle('G4')->getFont()->setBold(true);
        $spreadsheet->setCellValue('I4', '564820');
        $spreadsheet->getStyle('I4')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('A5', 'Consignee')->getStyle('A5')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C5', 'W.G. den Heijer ZN, Vissershavenweg 50 2583 , DK Den Haag, Holland');
        $spreadsheet->getStyle('C5')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('G5', 'Notify')->getStyle('G5')->getFont()->setBold(true);
        $spreadsheet->setCellValue('I5', 'W.G. den Heijer ZN, Vissershavenweg 50 2583 , DK Den Haag, Holland');
        $spreadsheet->getStyle('I5')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('A6', 'Flight No')->getStyle('A6')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C6', 'EK 649 / EK 147');
        $spreadsheet->getStyle('C6')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('D6', 'Flight Date')->getStyle('D6')->getFont()->setBold(true);
        $spreadsheet->setCellValue('E6', '2023-02-08');
        $spreadsheet->getStyle('E6')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('A7', 'AWB No')->getStyle('A7')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C7', '176-32764351');
        $spreadsheet->getStyle('C7')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('A8', 'PL Date')->getStyle('A8')->getFont()->setBold(true);
        $spreadsheet->setCellValue('C8', '2023-02-07');
        $spreadsheet->getStyle('C8')->getAlignment()->setHorizontal('left');

        $spreadsheet->setCellValue('G6', 'Total Boxes Qty')->getStyle('G6')->getFont()->setBold(true);
        $spreadsheet->setCellValue('G7', '182')->getStyle('G7')->getFont()->setSize(25);
        $spreadsheet->getStyle('G7')->getAlignment()->setHorizontal('center');

        $spreadsheet->setCellValue('J6', 'Total Net Weight')->getStyle('J6')->getFont()->setBold(true);
        $spreadsheet->setCellValue('J7', '2489.160')->getStyle('J7')->getFont()->setSize(25);
        $spreadsheet->getStyle('J7')->getAlignment()->setHorizontal('center');

        // Main Boxes List
        $headerRow = 10;
        $tableHeader = ['Box#', 'Product', '', '', 'Qty', 'Weight', '', 'Box#', 'Product', '', '', 'Qty', 'Weight'];
        foreach ($tableHeader as $key => $value) {
            $cell = chr(65 + $key) . $headerRow;
            $spreadsheet->setCellValue($cell, $value);
            $spreadsheet->getStyle($cell)->getFont()->setBold(true);
            $spreadsheet->getStyle($cell)->getAlignment()->setHorizontal('center');
        }
        $spreadsheet->getRowDimension($headerRow)->setRowHeight(20);

        // Merge Row Data Cells
        $spreadsheet->mergeCells('B' . $headerRow . ':D' . $headerRow);
        $spreadsheet->mergeCells('I' . $headerRow . ':K' . $headerRow);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ]
        ];
        $spreadsheet->getStyle('A' . $headerRow . ':F' . $headerRow)->applyFromArray($styleArray);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ]
        ];
        $spreadsheet->getStyle('H' . $headerRow . ':M' . $headerRow)->applyFromArray($styleArray);

        $items = [
            ['1', 'TUNA H&G AAA', '', '', '12', '81.500', '', '2', 'TUNA H&G AAA', '', '', '5', '45.310'],
            ['3', 'RED SNAPER WHOLE', '', '', '15', '54.500', '', '4', 'TUNA H&G AAA', '', '', '5', '4.644'],
            ['5', 'TUNA H&G AAA', '', '', '34', '34.500', '', '6', 'TUNA H&G AAA', '', '', '5', '48.860'],
            ['7', 'TUNA H&G AAA', '', '', '61', '1.45', '', '8', 'RED SNAPER WHOLE', '', '', '5', '56.235'],
            ['9', 'MET-TUNA AAA CHUNK ', '', '', '12', '75.500', '', '10', 'TUNA H&G AAA', '', '', '5', '9.310'],
            ['11', 'TUNA H&G AAA', '', '', '20', '64.250', '', '12', 'RED SNAPER WHOLE', '', '', '5', '65.420'],
            ['13', 'TUNA H&G AAA', '', '', '15', '38.500', '', '14', 'TUNA H&G AAA', '', '', '5', '42.390'],
            ['15', 'TUNA H&G AAA', '', '', '18', '42.250', '', '16', 'RED SNAPER WHOLE', '', '', '5', '12.945'],
            ['17', 'TUNA H&G AAA', '', '', '25', '87.750', '', '18', 'TUNA H&G AAA', '', '', '5', '29.160'],
            ['19', 'MET-TUNA AAA CHUNK ', '', '', '10', '63.500', '', '20', 'TUNA H&G AAA', '', '', '5', '8.990'],
            ['21', 'TUNA H&G AAA', '', '', '17', '57.750', '', '22', 'RED SNAPER WHOLE', '', '', '5', '71.820'],
            ['23', 'TUNA H&G AAA', '', '', '22', '37.500', '', '24', 'TUNA H&G AAA', '', '', '5', '29.870'],
            ['25', 'TUNA H&G AAA', '', '', '19', '58.500', '', '26', 'RED SNAPER WHOLE', '', '', '5', '48.690'],
            ['27', 'TUNA H&G AAA', '', '', '26', '1.75', '', '28', 'TUNA H&G AAA', '', '', '5', '69.020'],
            ['29', 'MET-TUNA AAA CHUNK ', '', '', '9', '78.500', '', '30', 'TUNA H&G AAA', '', '', '5', '20.180'],
            ['31', 'TUNA H&G AAA', '', '', '14', '72.750', '', '32', 'RED SNAPER WHOLE', '', '', '5', '67.590'],
            ['33', 'TUNA H&G AAA', '', '', '15', '38.500', '', '34', 'TUNA H&G AAA', '', '', '5', '42.390'],
            ['35', 'TUNA H&G AAA', '', '', '18', '42.250', '', '36', 'RED SNAPER WHOLE', '', '', '5', '12.945'],
            ['37', 'TUNA H&G AAA', '', '', '25', '87.750', '', '38', 'TUNA H&G AAA', '', '', '5', '29.160'],
            ['39', 'MET-TUNA AAA CHUNK ', '', '', '10', '63.500', '', '40', 'TUNA H&G AAA', '', '', '5', '8.990'],
            ['41', 'TUNA H&G AAA', '', '', '17', '57.750', '', '42', 'RED SNAPER WHOLE', '', '', '5', '71.820'],
            ['43', 'TUNA H&G AAA', '', '', '22', '37.500', '', '44', 'TUNA H&G AAA', '', '', '5', '29.870'],
            ['45', 'TUNA H&G AAA', '', '', '19', '58.500', '', '46', 'RED SNAPER WHOLE', '', '', '5', '48.690'],
            ['47', 'TUNA H&G AAA', '', '', '26', '1.75', '', '48', 'TUNA H&G AAA', '', '', '5', '69.020'],
            ['49', 'MET-TUNA AAA CHUNK ', '', '', '9', '78.500', '', '50', 'TUNA H&G AAA', '', '', '5', '20.180']
        ];
        foreach ($items as $item) {
            $row = $headerRow + 1;
            foreach ($item as $key => $value) {
                $cell = chr(65 + $key) . $row;
                $row2 = $headerRow + 1;
                // Merge Row Data Cells
                $spreadsheet->mergeCells('B' . $row2 . ':D' . $row2);
                $spreadsheet->mergeCells('I' . $row2 . ':K' . $row2);
                // Align
                $spreadsheet->getStyle('A' . $row2 . ':A' . $row2)->getAlignment()->setHorizontal('center');
                $spreadsheet->getStyle('B' . $row2 . ':D' . $row2)->getAlignment()->setHorizontal('left');
                $spreadsheet->getStyle('E' . $row2 . ':E' . $row2)->getAlignment()->setHorizontal('center');
                $spreadsheet->getStyle('F' . $row2 . ':F' . $row2)->getAlignment()->setHorizontal('right');
                $spreadsheet->getStyle('H' . $row2 . ':H' . $row2)->getAlignment()->setHorizontal('center');
                $spreadsheet->getStyle('I' . $row2 . ':K' . $row2)->getAlignment()->setHorizontal('left');
                $spreadsheet->getStyle('L' . $row2 . ':L' . $row2)->getAlignment()->setHorizontal('center');
                $spreadsheet->getStyle('M' . $row2 . ':M' . $row2)->getAlignment()->setHorizontal('right');
                // Set Value to Cell
                $spreadsheet->setCellValue($cell, $value);

                // Setting Borders - Rows
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                        ],
                    ]
                ];
                $spreadsheet->getStyle('A' . $row2 . ':F' . $row2)->applyFromArray($styleArray);

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                        ],
                    ]
                ];
                $spreadsheet->getStyle('H' . $row2 . ':M' . $row2)->applyFromArray($styleArray);

                $spreadsheet->getRowDimension($row2)->setRowHeight(25);
            }
            $headerRow++;
        }

        // Summary Section

        $lastRow = $headerRow;
        $headerRow += 2;

        $spreadsheet->mergeCells('A' . $headerRow . ':B' . $headerRow);
        $spreadsheet->mergeCells('C' . $headerRow . ':I' . $headerRow);
        $spreadsheet->mergeCells('J' . $headerRow . ':K' . $headerRow);
        $spreadsheet->mergeCells('L' . $headerRow . ':M' . $headerRow);

        $spreadsheet->setCellValue('A' . $headerRow, 'Fish Code');
        $spreadsheet->setCellValue('C' . $headerRow, 'Item Name');
        $spreadsheet->setCellValue('J' . $headerRow, 'No of Boxes');
        $spreadsheet->setCellValue('L' . $headerRow, 'Net Weight');

        $spreadsheet->getStyle('A' . $headerRow . ':M' . $headerRow)->getFont()->setBold(true);
        $spreadsheet->getStyle('A' . $headerRow . ':M' . $headerRow)->getAlignment()->setHorizontal('center');

        $spreadsheet->getRowDimension($headerRow)->setRowHeight(20);

        // Setting Borders - Header
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ]
            ]
        ];
        $spreadsheet->getStyle('A' . $headerRow . ':M' . $headerRow)->applyFromArray($styleArray);


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

        $row = $headerRow + 1;

        foreach ($summary as $itemName => $values) {

            // Set Merges
            $spreadsheet->mergeCells('A' . $row . ':B' . $row);
            $spreadsheet->mergeCells('C' . $row . ':I' . $row);
            $spreadsheet->mergeCells('J' . $row . ':K' . $row);
            $spreadsheet->mergeCells('L' . $row . ':M' . $row);

            $spreadsheet->getStyle('A' . $row . ':B' . $row)->getAlignment()->setHorizontal('center');
            $spreadsheet->getStyle('J' . $row . ':K' . $row)->getAlignment()->setHorizontal('center');

            $spreadsheet->setCellValue('A' . $row, "YFT");
            $spreadsheet->setCellValue('C' . $row, $itemName);
            $spreadsheet->setCellValue('J' . $row, $values['pcsQuantity']);
            $spreadsheet->setCellValue('L' . $row, $values['weight']);

            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                    ],
                ]
            ];
            $spreadsheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($styleArray);

            $spreadsheet->getRowDimension($row)->setRowHeight(25);




            // Calculate total values
            $totalPcsQuantity = 0;
            $totalWeight = 0;
            foreach ($summary as $values) {
                $totalPcsQuantity += $values['pcsQuantity'];
                $totalWeight += $values['weight'];
            }




            $row++;
        }
        // Total Row
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ]
        ];

        $spreadsheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($styleArray);

        $spreadsheet->mergeCells('A' . $row . ':I' . $row);
        $spreadsheet->mergeCells('J' . $row . ':K' . $row);
        $spreadsheet->mergeCells('L' . $row . ':M' . $row);

        $spreadsheet->getStyle('A' . $row . ':I' . $row)->getAlignment()->setHorizontal('center');
        $spreadsheet->getStyle('J' . $row . ':K' . $row)->getAlignment()->setHorizontal('center');
        $spreadsheet->getStyle('L' . $row . ':M' . $row)->getAlignment()->setHorizontal('right');
        $spreadsheet->getStyle('A' . $row . ':M' . $row)->getFont()->setBold(true);

        $spreadsheet->getRowDimension($row)->setRowHeight(20);

        $spreadsheet->setCellValue('A' . $row, "TOTAL");
        $spreadsheet->setCellValue('J' . $row, $totalPcsQuantity);
        $spreadsheet->setCellValue('L' . $row, $totalWeight);
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
                ->where('mnu_packing_list_hd.id', $this->EPLNo)
                ->select($arr)
                ->first();
        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }
}
