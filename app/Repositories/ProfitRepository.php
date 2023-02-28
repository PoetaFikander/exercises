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


    public function getDeviceData($id)
    {
        $results = DB::connection('sqlsrv')->select("
            SELECT * FROM [dbo].[profitGetDeviceData]( :id )
	    ", ['id' => $id]);
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


    public function getWorkCards($id, $dateFrom, $dateTo)
    {
        $workCards = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetWorkCards] (
                    :id,
                    :datefrom,
                    :dateto
                )
            ", [
                'id' => $id,
                'datefrom' => $dateFrom,
                'dateto' => $dateTo,
            ]
        );
        return $workCards;
    }


    public function getDoc($id, $dateFrom, $dateTo)
    {
        $wz = DB::connection('sqlsrv')->select("
                 EXEC [dbo].[profitGetDoc]
                    @id = :id,
                    @dateFrom = :datefrom,
                    @dateTo = :dateto
        ", [
                'id' => $id,
                'datefrom' => $dateFrom,
                'dateto' => $dateTo,
            ]
        );
        return $wz;
    }


    public function getDocContents($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT * FROM [dbo].[profitGetDocContents] ( :id )
            ", ['id' => $docId]
        );
        return $res;
    }


    public function getAgreementFSItems($docId)
    {
        $res = DB::connection('sqlsrv')->select("
                EXEC [dbo].[profitAgreementFSItemsProc]
		        @docId = :id
            ", ['id' => $docId]
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

        //        foreach ($res as $doc){
        //            $id = $doc->doc_id;
        //            $contents = $this->getDocContents($id);
        //            $doc->body = $contents;
        //        }

        return $res;
    }


    public function getDeviceProfit($devId, $agrId, $dFrom, $dTo)
    {
        $results = array();

        //----------------------------------------------

        // --- konwersja dat, walidacja
        $p = $this->getProfitParameter($devId, $dFrom, $dTo);

        // --- lista zleceń
        $workCards = $this->getWorkCards($p->dev_id, $p->dateFrom, $p->dateTo);

        // --- lista powiązanych dokumentów kosztowych
        // --- gdy WZ ma FS dokument zalicza się do profitu
        $agrWZ = $this->getDoc($p->dev_id, $p->dateFrom, $p->dateTo);

        // --- artykuły z WZ
        $agrWZitems = array();
        foreach ($agrWZ as $d) {
            $articles = $this->getDocContents($d->wz_id);
            foreach ($articles as $a) {
                $agrWZitems[] = $a;
            }
        }

        // ---
        $agrFS = $this->getAgreementInvoices($agrId, $p->dateFrom, $p->dateTo);

        // ---
        $agrFSitems = array();

        $agrFSsummaryV = array();
        $agrFSsummaryQ = array();
        $agrServName = array();

        $agrFSsummary = array();
        foreach ($agrFS as $doc) {
            $id = $doc->doc_id;
            $contents = $this->getAgreementFSItems($id);
            // ogarniamy dane do wyświetlenie w tabeli
            foreach ($contents as $item) {
                $item->item_quantity = (float)$item->item_quantity;
                $item->item_price = (float)$item->item_price;
                $item->item_value = (float)$item->item_value;
                $item->item_purchase_price = (float)$item->item_purchase_price;
                $item->item_purchase_value = (float)$item->item_purchase_value;
                $agrFSitems[] = $item;

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

        foreach ($agrServName as $key=>$val){
            $agrFSsummary[] = (object)[
                'art_code' =>$key,
                'art_name'=>$val,
                'item_quantity'=>$agrFSsummaryQ[$key],
                'item_value'=>$agrFSsummaryV[$key]
            ];
        }

        //----------------------------------------------


        //----------------------------------------------
        $results['param'] = $p;
        $results['workCards'] = $workCards;         // zlecenia do umowy
        $results['agrWZ'] = $agrWZ;                 // dokumenty kosztowe do umowy
        $results['agrWZitems'] = $agrWZitems;       // elementy dokumentów kosztowych do umów
        $results['agrFS'] = $agrFS;                 // faktury wystawione do umowy
        $results['agrFSitems'] = $agrFSitems;       // elementy faktur do umów
        $results['agrFSsummary'] = $agrFSsummary;   // podsumowanie elementów faktur wg usług
        return $results;
    }

}
