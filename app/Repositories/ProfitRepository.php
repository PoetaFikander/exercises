<?php


namespace App\Repositories;


use App\Models\Department;
use App\Models\Profit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ProfitRepository extends BaseRepository
{
    public function __construct(Profit $model)
    {
        $this->model = $model;
    }

    public function getDepartments()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[departments]");
        return $res;
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

    public function getWorkCardHeader($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCardHeader] ( :id )
            ", ['id' => $docId]
        );
        return $res[0];
    }

    public function getWorkCardActions($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCardActions] ( :id )
            ", ['id' => $docId]
        );
        return $res;
    }

    public function getWorkCardMaterials($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCardMaterials] ( :id )
            ", ['id' => $docId]
        );
        return $res;
    }

    public function getWorkCardServices($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCardServices] ( :id )
            ", ['id' => $docId]
        );
        return $res;
    }

    public function getWorkCardDoc($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCardDoc] ( :id )
            ", ['id' => $docId]
        );
        return $res;
    }


    public function getDoc($docId, $docTypeId)
    {
        $results = array();
        if ($docTypeId == 1002) {
            $results['header'] = $this->getWorkCardHeader($docId);
            $results['contents'] = array();
            $results['actions'] = $this->getWorkCardActions($docId);
            $results['materials'] = $this->getWorkCardMaterials($docId);
            $results['services'] = $this->getWorkCardServices($docId);
            $documents = array();
            $docs = $this->getWorkCardDoc($docId);
            foreach ($docs as $d) {
                if ((int)$d->doc_id > 0) {
                    $h = $this->getDocHeader($d->doc_id);
                    $documents[] = $h;
                }
            }
            $results['documents'] = $documents;
        } else {
            $results['header'] = $this->getDocHeader($docId);
            $results['contents'] = $this->getDocContents($docId, 0);
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
                    if ($item->art_id != 11543) {
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


    public function getContractsList($parameters = [])
    {
        $p = $parameters;
        $results = array();

        if (!count($p)) {
            $p = [
                'txtSearch' => '',
                'Type' => 'dev_name',
                'departmentId' => 0,
                'activeAgreement' => 1,
            ];
        } else {
            $p['txtSearch'] = array_key_exists('txtSearch', $p) ? $p['txtSearch'] : '';
            $p['Type'] = array_key_exists('Type', $p) ? $p['Type'] : 'dev_name';
            $p['departmentId'] = array_key_exists('departmentId', $p) ? $p['departmentId'] : 0;
            $p['activeAgreement'] = array_key_exists('activeAgreement', $p) ? ($p['activeAgreement'] ? 1 : 0) : 1;
        }

        $res = DB::connection('sqlsrv')->select(
            "EXEC [dbo].[getAgreementsList]
		            @txtSearch = :ts,
		            @Type = :t,
            		@departmentId = :di,
            		@activeAgreement = :aa
            ", [
                'ts' => $p["txtSearch"],
                't' => $p["Type"],
                'di' => $p["departmentId"],
                'aa' => $p["activeAgreement"]
            ]
        );

        $results['p'] = $p;
        $results['contracts'] = $res;
        return $results;
    }


    public function getContractData($agrId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitAgreementsList] where agr_id = :id 
            ", ['id' => $agrId]
        );
        return $res;
    }

    public function getContractDevices($agrId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitAgreementDevices] ( :id ) 
            ", ['id' => $agrId]
        );
        return $res;
    }


    public function getContractProfit($agrId, $dFrom, $dTo, $counterId)
    {
        //$profitType = 2;// kontrakty
        $results = array();
        $devices = $this->getContractDevices($agrId);
        //$results['devices'] = $devices;

        $devQuantity = count($devices);// ile urządzeń na umowie
        $this->incAgreementCounter($counterId, $devQuantity);

        $profits = array();
        $income = 0;
        $incomeAdd = 0;
        $cost = 0;

        foreach ($devices as $device) {
            $counter = $this->getAgreementCounter($counterId);
            $break = $counter->break;
            if ((int)$break === 0) {
                $profit = $this->getDeviceProfitCalc($device->dev_id, $agrId, $dFrom, $dTo);
                $cost += (float)$profit->cost;
                $income += (float)$profit->income;
                $incomeAdd += (float)$profit->income_add;
                $profits[] = $profit;
                $this->incAgreementCounter($counterId, --$devQuantity);
            } else {
                $profits = [];
                break;
            }
        }
        $results['profits'] = $profits;

        //----------------------------------------------
        $incomeAll = $income + $incomeAdd;
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
                'value' => $incomeAdd,
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
        $results['summary'] = $summary;

        return $results;
    }


    public function getProfit($profitType, $agrId, $devId = null, $dFrom = null, $dTo = null)
    {

        $results = array();
        // zwrot parametrów początkowych - kontrolnie
        $p = [
            'profitType' => $profitType,
            'agrId' => $agrId,
            'devId' => $devId,
            'dFrom' => $dFrom,
            'dTo' => $dTo,
        ];

        $profit = 0;                // zysk
        $gp = 0; //                 // % zysk
        $income = 0;                // przychód
        $cost = 0;                  // koszty
        $incomeAdditional = 0;      // dodatkowy przychód - wartość artykułów z płatnych zleceń ZL->WZ->FS
        $incomeAddItems = array();  // lista artykułów z płatnych zleceń ZL->WZ->FS

        $workCards = array();
        $agrWZ = array();
        $agrWZitems = array();
        $agrWZsummary = array();
        $agrFS = array();
        $agrFSitems = array();
        $agrFSsummary = array();
        $summary = array();


        switch ($profitType) {
            case 1: // device
                break;
            case 2: // contract
                // wejście

                break;
            default:
        }


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


    public function getDeviceProfitCalc($devId, $agrId, $dFrom, $dTo)
    {
        $res = DB::connection('sqlsrv')->select("
                 EXEC [dbo].[profitGetDeviceProfit]
                    @devId = :devid,
                    @agrId = :agrid,
                    @dFrom = :datefrom,
                    @dTo = :dateto
        ", [
                'devid' => $devId,
                'agrid' => $agrId,
                'datefrom' => $dFrom,
                'dateto' => $dTo,
            ]
        );
        return $res[0];
    }


    public function setAgreementCounter($counterId, $devQuantity)
    {
        $results = DB::connection('sqlsrv')->insert("
                INSERT INTO [dbo].[profit_agreement_counter]
                    ([id],[counter],[dev_quantity])
                VALUES
                (:i, :c, :q)
    	    ", ['i' => $counterId, 'c' => $devQuantity, 'q' => $devQuantity]);
        return $results;
    }


    public function updateAgreementCounter($counterId, $counter, $break, $devQuantity)
    {
        $results = DB::connection('sqlsrv')->update("
                UPDATE [dbo].[profit_agreement_counter]
                SET [counter] = :c,[dev_quantity] = :q, [break] = :b
                WHERE id = :i
    	    ", ['i' => $counterId, 'c' => $counter, 'q' => $devQuantity, 'b' => $break]);
        return $results;
    }


    public function incAgreementCounter($counterId, $counter)
    {
        $results = DB::connection('sqlsrv')->update("
                UPDATE [dbo].[profit_agreement_counter]
                SET [counter] = :c
                WHERE id = :i
    	    ", ['i' => $counterId, 'c' => $counter]);
        return $results;
    }

    public function breakAgreementCounter($counterId)
    {
        $results = DB::connection('sqlsrv')->update("
                UPDATE [dbo].[profit_agreement_counter]
                SET [counter] = 0, [break] = 1
                WHERE id = :i
    	    ", ['i' => $counterId]);
        return $results;
    }


    public function getAgreementCounter($counterId)
    {
        $results = DB::connection('sqlsrv')->select("
                select * from [dbo].[profit_agreement_counter] WHERE id = :i
    	    ", ['i' => $counterId]);
        return $results[0];
    }


    public function getDeviceProfitCalcOLD($devId, $agrId, $dFrom, $dTo)
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
        //$workCards = $this->getWorkCards($deviceId, $customerId, $dateFrom, $dateTo);

        // --- lista dokumentów kosztowych powiązanych
        // ze zleceniami wykonanymi w czasie trwania danej umowy
        $agrWZ = $this->getCostDoc($deviceId, $customerId, $dateFrom, $dateTo);
        //$agrWZ = array();

        // --- artykuły z WZ
        //$agrWZitems = array();

        //$agrWZsummaryV = array();
        //$agrWZsummaryQ = array();
        //$agrWZServName = array();
        //$agrWZsummary = array();

        foreach ($agrWZ as $d) {

            // ---- liczymy koszty
            $contents = $this->getDocContents($d->wz_id, 0);

            foreach ($contents as $item) {
                //$item->item_quantity = (float)$item->item_quantity;
                //$item->item_price = (float)$item->item_price;
                //$item->item_value = (float)$item->item_value;
                //$item->item_purchase_price = (float)$item->item_purchase_price;
                //$item->item_purchase_value = (float)$item->item_purchase_value;

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
                //$artCode = $item->art_code;
                //if (array_key_exists($artCode, $agrWZsummaryV)) {
                //    $agrWZsummaryV[$artCode] += $item->item_value;
                //    $agrWZsummaryQ[$artCode] += $item->item_quantity;
                //} else {
                //    $agrWZsummaryV[$artCode] = $item->item_value;
                //    $agrWZsummaryQ[$artCode] = $item->item_quantity;
                //    $agrWZServName[$artCode] = $item->art_name;
                //}
            }
        }

        //foreach ($agrWZServName as $key => $val) {
        //    $agrWZsummary[] = (object)[
        //        'art_code' => $key,
        //        'art_name' => $val,
        //        'item_quantity' => $agrWZsummaryQ[$key],
        //        'item_value' => $agrWZsummaryV[$key]
        //    ];
        //}


        // ---
        $agrFS = $this->getAgreementInvoices($agrId, $dateFrom, $dateTo);

        // ---
        //$agrFSitems = array();

        //$agrFSsummaryV = array();
        //$agrFSsummaryQ = array();
        //$agrServName = array();
        //$agrFSsummary = array();

        foreach ($agrFS as $doc) {
            $id = $doc->doc_id;
            $contents = $this->getDocContents($id, 1);
            // ogarniamy dane do wyświetlenie w tabeli
            foreach ($contents as $item) {
                if ($devSerialNo == $item->dev_serial_no) { // && $item->art_id != 11543
                    //
                    //$item->item_quantity = (float)$item->item_quantity;
                    //$item->item_price = (float)$item->item_price;
                    //$item->item_value = (float)$item->item_value;
                    //$item->item_purchase_price = (float)$item->item_purchase_price;
                    //$item->item_purchase_value = (float)$item->item_purchase_value;
                    //$agrFSitems[] = $item;

                    // przychód bez CNU id:11543
                    if ($item->art_id != 11543) {
                        $income += (float)$item->item_value;
                    }

                    // tabela podsumowująca usługi
                    //$artCode = $item->art_code;
                    //if (array_key_exists($artCode, $agrFSsummaryV)) {
                    //    $agrFSsummaryV[$artCode] += $item->item_value;
                    //    $agrFSsummaryQ[$artCode] += $item->item_quantity;
                    //} else {
                    //    $agrFSsummaryV[$artCode] = $item->item_value;
                    //    $agrFSsummaryQ[$artCode] = $item->item_quantity;
                    //    $agrServName[$artCode] = $item->art_name;
                    //}

                }
            }
        }

//        foreach ($agrServName as $key => $val) {
//            $agrFSsummary[] = (object)[
//                'art_code' => $key,
//                'art_name' => $val,
//                'item_quantity' => $agrFSsummaryQ[$key],
//                'item_value' => $agrFSsummaryV[$key]
//            ];
//        }

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
        //$results['workCards'] = $workCards;                             // zlecenia do umowy
        //$results['agrWZ'] = $agrWZ;                                     // dokumenty kosztowe do umowy
        //$results['agrWZitems'] = $agrWZitems;                           // elementy dokumentów kosztowych do umów
        //$results['agrWZsummary'] = $agrWZsummary;                       // podsumowanie elementów wydań wg artykułów
        //$results['agrFS'] = $agrFS;                                     // faktury wystawione do umowy
        //$results['agrFSitems'] = $agrFSitems;                           // elementy faktur do umów
        //$results['agrFSsummary'] = $agrFSsummary;                       // podsumowanie elementów faktur wg usług
        //$results['incomeAddItems'] = $incomeAddItems;
        $results['summary'] = $summary;                                 // podsumowanie kosztów i zysków urządzenia
        return $results;
    }


}
