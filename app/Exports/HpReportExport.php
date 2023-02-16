<?php

namespace App\Exports;

use App\Models\HpReport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class HpReportExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    protected $reportId;

    public function __construct($reportId)
    {
        $this->reportId = $reportId;
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->{'Country'},
            $row->{'Partner ID'},
            $row->{'Partner Name'},
            $row->{'Start period'},
            $row->{'End period'},
            $row->{'HP Product Number'},
            $row->{'Total Sellin Units'},
            $row->{'Inventory Units'},
            $row->{'Sales Units'},
            $row->{'Transaction Date'},
            $row->{'Channel Partner to Customer Invoice ID'},

            $row->{'Sold-to Customer ID'},
            $row->{'Sold To Customer Name'},
            $row->{'Sold To Company Tax ID'},
            $row->{'Sold To Address Line 1'},
            $row->{'Sold To Address Line 2'},
            $row->{'Sold To City'},
            $row->{'Sold To Postal Code'},
            $row->{'Sold To Country Code'},

            $row->{'Ship-to Customer ID'},
            $row->{'Ship To Customer Name'},
            $row->{'Ship To Company Tax ID'},
            $row->{'Ship To Address Line 1'},
            $row->{'Ship To Address Line 2'},
            $row->{'Ship To City'},
            $row->{'Ship To Postal Code'},
            $row->{'Ship To Country Code'},

            $row->{'Online'},
            $row->{'Customer Online Order Date'},
            $row->{'Sell From ID'},
            $row->{'Product Serial ID assigned by HP'},

            $row->{'Deal/Promo ID #1'},
            $row->{'Bundle ID #1'},
            $row->{'Deal/Promo ID #2'},
            $row->{'Bundle ID #2'},
            $row->{'Deal/Promo ID #3'},
            $row->{'Bundle ID #3'},
            $row->{'Deal/Promo ID #4'},
            $row->{'Bundle ID #4'},
            $row->{'Deal/Promo ID #5'},
            $row->{'Bundle ID #5'},
            $row->{'Deal/Promo ID #6'},
            $row->{'Bundle ID #6'},

            $row->{'Contract ID'},
            $row->{'Contract start date'},
            $row->{'Contract end date'},
            $row->{'Drop ship Flag'},
            $row->{'Partner Internal transaction ID'},
            $row->{'Partner Requested Rebate Amount'},
            $row->{'Partner Reference'},
            $row->{'Partner Comment'},
            $row->{'Partner Product Name'},

        ];
    }

    public function query()
    {
        // TODO: Implement query() method.
        //$res = HpReport::getReport($this->reportId);
        $res = HpReport::where('report_id', $this->reportId);
        //dd($res);
        return $res;
    }

    public function headings(): array
    {
        return [
            'Country', //A
            'Partner ID',
            'Partner Name',
            'Start period',
            'End period',
            'HP Product Number',
            'Total Sellin Units', //G
            'Inventory Units',
            'Sales Units',
            'Transaction Date', //J
            'Channel Partner to Customer Invoice ID',

            'Sold-to Customer ID',
            'Sold To Customer Name',
            'Sold To Company Tax ID',
            'Sold To Address Line 1',
            'Sold To Address Line 2',
            'Sold To City',
            'Sold To Postal Code',
            'Sold To Country Code',

            'Ship-to Customer ID',
            'Ship To Customer Name',
            'Ship To Company Tax ID',
            'Ship To Address Line 1',
            'Ship To Address Line 2',
            'Ship To City',
            'Ship To Postal Code',
            'Ship To Country Code',

            'Online',
            'Customer Online Order Date',
            'Sell From ID',
            'Product Serial ID assigned by HP',

            'Deal/Promo ID #1',
            'Bundle ID #1',
            'Deal/Promo ID #2',
            'Bundle ID#2',
            'Deal/Promo ID #3',
            'Bundle ID#3',
            'Deal/Promo ID #4',
            'Bundle ID#4',
            'Deal/Promo ID #5',
            'Bundle ID#5',
            'Deal/Promo ID #6',
            'Bundle ID#6',

            'Contract ID',
            'Contract start date',
            'Contract end date',
            'Drop ship Flag',
            'Partner Internal transaction ID',
            'Partner Requested Rebate Amount',
            'Partner Reference',
            'Partner Comment',
            'Partner Product Name', //AZ
        ];

        // nagłówki wszystkie kolumny z tabeli
        //return array_keys($this->query()->first()->toArray());
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER_00,
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
            'N' => NumberFormat::FORMAT_TEXT,
            'O' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,
            'Q' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,
            'S' => NumberFormat::FORMAT_TEXT,
            'T' => NumberFormat::FORMAT_TEXT,
            'U' => NumberFormat::FORMAT_TEXT,
            'V' => NumberFormat::FORMAT_TEXT,
            'W' => NumberFormat::FORMAT_TEXT,
            'X' => NumberFormat::FORMAT_TEXT,
            'Y' => NumberFormat::FORMAT_TEXT,
            'Z' => NumberFormat::FORMAT_TEXT,
            'AA' => NumberFormat::FORMAT_TEXT,
            'AB' => NumberFormat::FORMAT_TEXT,
            'AC' => NumberFormat::FORMAT_TEXT,
            'AD' => NumberFormat::FORMAT_TEXT,
            'AE' => NumberFormat::FORMAT_TEXT,
            'AF' => NumberFormat::FORMAT_TEXT,
            'AG' => NumberFormat::FORMAT_TEXT,
            'AH' => NumberFormat::FORMAT_TEXT,
            'AI' => NumberFormat::FORMAT_TEXT,
            'AJ' => NumberFormat::FORMAT_TEXT,
            'AK' => NumberFormat::FORMAT_TEXT,
            'AL' => NumberFormat::FORMAT_TEXT,
            'AM' => NumberFormat::FORMAT_TEXT,
            'AN' => NumberFormat::FORMAT_TEXT,
            'AO' => NumberFormat::FORMAT_TEXT,
            'AP' => NumberFormat::FORMAT_TEXT,
            'AQ' => NumberFormat::FORMAT_TEXT,
            'AR' => NumberFormat::FORMAT_TEXT,
            'AS' => NumberFormat::FORMAT_TEXT,
            'AT' => NumberFormat::FORMAT_TEXT,
            'AU' => NumberFormat::FORMAT_TEXT,
            'AV' => NumberFormat::FORMAT_TEXT,
            'AW' => NumberFormat::FORMAT_TEXT,
            'AX' => NumberFormat::FORMAT_TEXT,
            'AY' => NumberFormat::FORMAT_TEXT,
            'AZ' => NumberFormat::FORMAT_TEXT,
        ];
    }

}
