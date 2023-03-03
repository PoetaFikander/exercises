<?php


namespace App\Repositories;


use App\Models\Profit;
use Illuminate\Support\Facades\DB;


class ProfitRepository extends BaseRepository
{
    public function __construct(Profit $model)
    {
        $this->model = $model;
    }

    /*
     * ---- urządzenia
     */

    /**
     * lista urządzeń - sortowanie + paginacja
     *
     * @param array $parameters
     * @return array
     */
    public function getDevicesList($parameters = [])
    {
        $p = $parameters;
        $results = array();

        if (!count($p)) {
            $p = [
                'txtSearch' => '',
                'Type' => 'dev_name',
                'activeDevice' => 1,
                'activeAgreement' => 1,
            ];
        } else {
            $p['txtSearch'] = array_key_exists('txtSearch', $p) ? $p['txtSearch'] : '';
            $p['Type'] = array_key_exists('Type', $p) ? $p['Type'] : 'dev_name';
            $p['activeDevice'] = array_key_exists('activeDevice', $p) ? ($p['activeDevice'] ? 1 : 0) : 1;
            $p['activeAgreement'] = array_key_exists('activeAgreement', $p) ? ($p['activeAgreement'] ? 1 : 0) : 1;
        }

        $res = DB::connection('sqlsrv')->select(
            "EXEC [dbo].[getDevicesList] 
		            @txtSearch = :ts,
		            @Type = :t,
            		@activeDevice = :ad,
            		@activeAgreement = :aa
            ", [
                'ts' => $p["txtSearch"],
                't' => $p["Type"],
                'ad' => $p["activeDevice"],
                'aa' => $p["activeAgreement"]
            ]
        );

        $results['p'] = $p;
        $results['devices'] = $res;
        return $results;
    }


    public function getDeviceData($devId, $agrId)
    {
        $results = DB::connection('sqlsrv')->select("
            SELECT * FROM [dbo].[profitGetDeviceData]( :devid, :agrid )
	    ", ['devid' => $devId, 'agrid' => $agrId]);
        return $results[0];
    }


    public function getProfitParameter($devId, $dFrom, $dTo)
    {
        $p = DB::connection('sqlsrv')->select(
            "EXEC [dbo].[profitGetProfitParameter] 
                    @dev_id = :id, 
                    @dFrom = :dfrom,
                    @dTo = :dto
            ", [
                'id' => $devId,
                'dfrom' => $dFrom,
                'dto' => $dTo,
            ]
        );
        return $p[0];
    }


    public function getWorkCards($id, $customerId, $dateFrom, $dateTo)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCards] (:id, :custid, :df, :dt) order by [wc_register_date]
            ", ['id' => $id, 'custid' => $customerId, 'df' => $dateFrom, 'dt' => $dateTo]
        );
        return $res;
    }


    public function getCostDoc($id, $customerId, $dateFrom, $dateTo)
    {
        $res = DB::connection('sqlsrv')->select("
                 EXEC [dbo].[profitGetDoc] @id = :id, @customerId = :custid, @dateFrom = :df, @dateTo = :dt
            ", ['id' => $id, 'custid' => $customerId, 'df' => $dateFrom, 'dt' => $dateTo]
        );
        return $res;
    }


    public function getDocContents($docId, $withAddon = 0)
    {
        $res = DB::connection('sqlsrv')->select("
                EXEC [dbo].[profitGetDocContentsProc] @docId = :id, @withAddon = :wa
            ", ['id' => $docId, 'wa' => $withAddon]
        );
        return $res;
    }


    public function getDocHeader($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetDocHeader] ( :id )
            ", ['id' => $docId]
        );
        return $res[0];
    }


    public function getAgreementInvoices($agrId, $dateFrom, $dateTo)
    {
        $res = DB::connection('sqlsrv')->select("
                 EXEC [dbo].[profitGetAgreementInvoices]
                    @agreementId = :id,
                    @dateFrom = :datefrom,
                    @dateTo = :dateto
        ", [
                'id' => $agrId,
                'datefrom' => $dateFrom,
                'dateto' => $dateTo,
            ]
        );
        return $res;
    }


    public function getDoc($docId, $docTypeId)
    {
        $results = array();

        switch ($docTypeId) {
            case 5: // PW
                break;
            case 6: // RW
                break;
            case 7: // FZ
                break;
            case 8: // FS
                $results['header'] = $this->getDocHeader($docId);
                $results['contents'] = $this->getDocContents($docId, 0);
                break;
            case 13: // ZS
                break;
            case 17: // MM+
                break;
            case 18: // MM-
                break;
            case 28: // WZ
                break;
            case 31: // PZ
                break;
            case 1002: // ZL
                break;
            default:
        }

        return $results;
    }


    public function getDeviceProfit($devId, $agrId, $dFrom, $dTo)
    {
        $results = array();
        $profit = 0; // zysk
        $gp = 0; //
        $income = 0; // przychód
        $cost = 0;
        $incomeAdditional = 0; // wartość artykułów z płatnych zleceń ZL->WZ->FS
        $incomeAddItems = array(); // lista artykułów z płatnych zleceń ZL->WZ->FS

        //----------------------------------------------

        // --- konwersja dat, walidacja
        $p = $this->getProfitParameter($devId, $dFrom, $dTo);
        $dateFrom = $p->dateFrom;
        $dateTo = $p->dateTo;

        // --- dane urządzenia i umowy
        $device = $this->getDeviceData($devId, $agrId);
        $deviceId = $device->dev_id;
        $devSerialNo = $device->dev_serial_no;
        $customerId = $device->customer_id;

        // --- lista zleceń wykonanych w czasie trwanie danej umowy
        $workCards = $this->getWorkCards($deviceId, $customerId, $dateFrom, $dateTo);

        // --- lista dokumentów kosztowych powiązanych
        // ze zleceniami wykonanymi w czasie trwania danej umowy
        $agrWZ = $this->getCostDoc($deviceId, $customerId, $dateFrom, $dateTo);
        //$agrWZ = array();

        // --- artykuły z WZ
        $agrWZitems = array();

        $agrWZsummaryV = array();
        $agrWZsummaryQ = array();
        $agrWZServName = array();
        $agrWZsummary = array();

        foreach ($agrWZ as $d) {

            // ---- liczymy koszty
            $contents = $this->getDocContents($d->wz_id, 0);

            foreach ($contents as $item) {
                $item->item_quantity = (float)$item->item_quantity;
                $item->item_price = (float)$item->item_price;
                $item->item_value = (float)$item->item_value;
                $item->item_purchase_price = (float)$item->item_purchase_price;
                $item->item_purchase_value = (float)$item->item_purchase_value;

                // gdy WZ ma FS dokument zalicza się do przychodu
                if ($d->fs_id > 0) {
                    $incomeAddItems[] = $item;
                    $incomeAdditional += (float)$item->item_value - (float)$item->item_purchase_value;
                    //$incomeAdditional += (float)$item->item_value; // bez odliczania kosztów zakupu
                } else {
                    $agrWZitems[] = $item;
                    $cost += (float)$item->item_purchase_value;
                }

                // tabela podsumowująca artykuły
                $artCode = $item->art_code;
                if (array_key_exists($artCode, $agrWZsummaryV)) {
                    $agrWZsummaryV[$artCode] += $item->item_value;
                    $agrWZsummaryQ[$artCode] += $item->item_quantity;
                } else {
                    $agrWZsummaryV[$artCode] = $item->item_value;
                    $agrWZsummaryQ[$artCode] = $item->item_quantity;
                    $agrWZServName[$artCode] = $item->art_name;
                }
            }
        }

        foreach ($agrWZServName as $key => $val) {
            $agrWZsummary[] = (object)[
                'art_code' => $key,
                'art_name' => $val,
                'item_quantity' => $agrWZsummaryQ[$key],
                'item_value' => $agrWZsummaryV[$key]
            ];
        }


        // ---
        $agrFS = $this->getAgreementInvoices($agrId, $dateFrom, $dateTo);

        // ---
        $agrFSitems = array();

        $agrFSsummaryV = array();
        $agrFSsummaryQ = array();
        $agrServName = array();
        $agrFSsummary = array();

        foreach ($agrFS as $doc) {
            $id = $doc->doc_id;
            $contents = $this->getDocContents($id, 1);
            // ogarniamy dane do wyświetlenie w tabeli
            foreach ($contents as $item) {
                if ($devSerialNo == $item->dev_serial_no) { // && $item->art_id != 11543
                    //
                    $item->item_quantity = (float)$item->item_quantity;
                    $item->item_price = (float)$item->item_price;
                    $item->item_value = (float)$item->item_value;
                    $item->item_purchase_price = (float)$item->item_purchase_price;
                    $item->item_purchase_value = (float)$item->item_purchase_value;
                    $agrFSitems[] = $item;

                    // przychód bez CNU id:11543
                    if($item->art_id != 11543) {
                        $income += (float)$item->item_value;
                    }

                    // tabela podsumowująca usługi
                    $artCode = $item->art_code;
                    if (array_key_exists($artCode, $agrFSsummaryV)) {
                        $agrFSsummaryV[$artCode] += $item->item_value;
                        $agrFSsummaryQ[$artCode] += $item->item_quantity;
                    } else {
                        $agrFSsummaryV[$artCode] = $item->item_value;
                        $agrFSsummaryQ[$artCode] = $item->item_quantity;
                        $agrServName[$artCode] = $item->art_name;
                    }

                }
            }
        }

        foreach ($agrServName as $key => $val) {
            $agrFSsummary[] = (object)[
                'art_code' => $key,
                'art_name' => $val,
                'item_quantity' => $agrFSsummaryQ[$key],
                'item_value' => $agrFSsummaryV[$key]
            ];
        }

        //----------------------------------------------
        $incomeAll = $income + $incomeAdditional;
        $profit = $incomeAll - $cost;

        if ($incomeAll != 0) {
            $gp = (($incomeAll - $cost) / $incomeAll) * 100;
        } else {
            $gp = 100;
        }

        $summary = [
            (object)[
                'name' => 'income',
                'value' => $income,
            ],
            (object)[
                'name' => 'incomeAdditional',
                'value' => $incomeAdditional,
            ],
            (object)[
                'name' => 'cost',
                'value' => $cost,
            ],
            (object)[
                'name' => 'profit',
                'value' => $profit,
            ],
            (object)[
                'name' => 'gp',
                'value' => $gp,
            ],
        ];

        //----------------------------------------------
        $results['param'] = $p;
        $results['workCards'] = $workCards;                             // zlecenia do umowy
        $results['agrWZ'] = $agrWZ;                                     // dokumenty kosztowe do umowy
        $results['agrWZitems'] = $agrWZitems;                           // elementy dokumentów kosztowych do umów
        $results['agrWZsummary'] = $agrWZsummary;                       // podsumowanie elementów wydań wg artykułów
        $results['agrFS'] = $agrFS;                                     // faktury wystawione do umowy
        $results['agrFSitems'] = $agrFSitems;                           // elementy faktur do umów
        $results['agrFSsummary'] = $agrFSsummary;                       // podsumowanie elementów faktur wg usług
        $results['incomeAddItems'] = $incomeAddItems;
        $results['summary'] = $summary;                                 // podsumowanie kosztów i zysków urządzenia
        return $results;
    }

}
