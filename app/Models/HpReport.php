<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class HpReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'report_id',
        'Country',
        'Partner ID',
        'Partner Name',
        'Start period',
        'End period',
        'HP Product Number',
        'Total Sellin Units',
        'Inventory Units',
        'Sales Units',
        'Transaction Date',
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
        'Partner Product Name',
    ];

}
