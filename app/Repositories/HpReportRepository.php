<?php


namespace App\Repositories;


use App\Models\HpReport;
use App\Models\HpReportsInventory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class HpReportRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    //[projects].[dbo].[hp_reports_customers]
    public static function getCustomers()
    {
        $results = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_customers]
	    ");
        return $results;
    }

    public static function getCustomersFromAltumOLD()
    {
        $results = DB::connection('sqlsrv_altum')->select("
            select cust.Id [altum_id]
                    ,cust.Code [code]
                    ,cd.Name1 [name]
                    ,cd.TIN [tin]
            from dbo.Dic_Customers cust
                inner join dbo.Dic_CustomerData cd	on cd.CustomerId = cust.Id and cd.IsCurrent = 1
                inner join Attributes.Attributes aa on aa.ObjectID = cust.Id
                inner join SecAttributes.AttributeClasses ac on ac.AttributeClassID = aa.AttributeClassID
                left outer join Dictionaries.TranslationValues tv_ac on tv_ac.TranslationID = ac.NameTranslationID
                left outer join Dictionaries.TranslationValues tv on tv.TranslationID = aa.ValueTranslationID and tv.LanguageID=1
            where 1=1
                and aa.ObjectTypeID = 1 ---- obiekt kontrahent
                and aa.AttributeClassID = 41 ---- id atrybutu 'CustomerID'
	    ");
        return $results;
    }

    public function getCustomersFromAltum($name, $tin)
    {
        $results = DB::connection('sqlsrv_altum')->select("
            select top(10)
                    cust.Id [altum_id]
                    ,cust.Code [code]
                    ,cd.Name1 [name]
                    ,cd.TIN [tin]
            from dbo.Dic_Customers cust
                inner join dbo.Dic_CustomerData cd	on cd.CustomerId = cust.Id and cd.IsCurrent = 1
            where 1=1
                and cust.Activity = 1
                and cd.TIN <> ''
                and cd.TIN like concat('%',:tin,'%')
                and cd.Name1 like concat('%',:name,'%')
                and cust.Id not in (select altum_id from [projects].[dbo].[hp_reports_customers])
	    ", ['name' => $name, 'tin' => $tin]);
        return $results;
    }

    public function addCustomer($id)
    {
        $results = DB::connection('sqlsrv_altum')->insert("
                insert into [projects].[dbo].[hp_reports_customers](
                      [altum_id]
                      ,[code]
                      ,[name]
                      ,[tin]
                      ,[blocked_for_deletion]
                )
                select 
                     cust.Id [altum_id]
                    ,cust.Code [code]
                    ,cd.Name1 [name]
                    ,cd.TIN [tin]
                    ,0 [blocked_for_deletion]
                from dbo.Dic_Customers cust
                inner join dbo.Dic_CustomerData cd	on cd.CustomerId = cust.Id and cd.IsCurrent = 1
                where cust.Id = :id
    	    ", ['id' => $id]);
        return $results;
    }

    public function deleteCustomer($id)
    {
        $results = DB::connection('sqlsrv')->delete("
            delete from [dbo].[hp_reports_customers] where [altum_id] = :id
    	", ['id' => $id]);
        return $results;
    }


    public function getAltumArticles()
    {
        $results = DB::connection('sqlsrv_altum')->select("
                select 
                    a.Id [article_id]
                    ,a.Code [code]
                    ,a.Name [name]
                    ,a.CatalogueNumber [catalogue_number]
                from dbo.Dic_Articles a
                where 1=1
                    and a.Name like '%toner% HP %'
                    and a.Code like '%*R'
	    ");
        return $results;
    }

    public function compareArticles()
    {
        $results = DB::connection('sqlsrv_altum')->statement("
                select article_id into #t1
                from [projects].[dbo].[hp_reports_articles];
                
                insert into [projects].[dbo].[hp_reports_articles]
                (
                   [article_id]
                   ,[code]
                   ,[name]
                   ,[catalogue_number]
                )
                select 
                    a.Id [article_id]
                    ,a.Code [code]
                    ,a.Name [name]
                    ,a.CatalogueNumber [catalogue_number]
                from [dbo].[Dic_Articles] a
                where 1=1
                    and a.Name like '%toner% HP %'
                    and a.Code like '%*R'
                    and a.Id not in (select article_id from #t1);
                    
                drop table #t1;
	    ");
        return $results;
    }

    public function getArticle($id)
    {
        $results = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_articles] where article_id = :id
	    ", ['id' => $id]);
        return $results[0];
    }


    public static function getHpReportsInventoriesByReport($reportId)
    {
        $results = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_inventories] where report_id = :reportid
	    ", ['reportid' => $reportId]);
        return $results;
    }

    public function getArticleStocks($id)
    {
        $results = DB::connection('sqlsrv_altum')->select("
            SELECT
                l.ArticleID [id]
                ,art.Code [code]
                ,art.Name [name]
                ,l.FeaturesString [serial]
                ,mag.Symbol [mag_symbol]
                ,mag.Name [mag_name]
                ,s.Quantity [quantity]
                ,s.Reservations [reservations]
                ,s.Orders [orders]
                ,s.Value [purchase_value]
                ,case when s.Quantity > 0 then convert(decimal(19,2), s.Value/s.Quantity) else 0 end [unit_price]
                --,REPLACE(CONVERT(varchar,convert(decimal(19,2), s.Quantity)),'.',',') [ilosc]
                --,REPLACE(CONVERT(varchar,convert(decimal(19,2), s.Value)),'.',',') [wartoscZakupuZasobu]
                --,REPLACE(CONVERT(varchar,convert(decimal(19,2), (s.Value/s.Quantity))),'.',',') [cenaJednostkowa]
                ,format(ssi.StockDate, 'dd-MM-yyyy') [primary_doc_date]
                ,ssi.StockDocumentNumber [primary_doc]
                ,format(sss.StockDate, 'dd-MM-yyyy') [input_doc_date]
                ,sss.StockDocumentNumber [input_doc]
                --,isnull(ag.grupa,'Grupa głowna') [grupa]
                --,b.BarcodeValue
                --,l.LotID [lLotID]
                --,s.WarehouseID
            from Storage.Lots l
                inner join Storage.Stocks s on s.LotID = l.LotID
                inner join Sales.Subitems ssi on ssi.ID = s.InitialSubitemId
                inner join Sales.Subitems sss on sss.ID = s.SubitemId
                inner join dbo.Dic_Articles art on art.Id = l.ArticleID
                inner join SecDictionaries.Dic_Stores mag on mag.Id = s.WarehouseID
            where art.Id = :id
            order by mag.Name
            -- view        
            --select * from [dbo].[dks_articleStocks] where id = :id order by mag_name
	    ", ['id' => $id]);
        return $results;
    }

    public static function getFirstLastDayOfWeek($date = null)
    {
        $results = DB::connection('sqlsrv')->select(
            "EXEC [dbo].[getFirstLastDayOfWeek] @date = :date", ['date' => $date]
        );
        return $results[0];
    }

    public static function getArticleInOut($dateFrom, $dateTo, $docType = 28, $customerType = 0)
    {
        $results = DB::connection('sqlsrv_altum')->select("
            select
                a.Id [article_id]
                --,CONVERT(datetime, :date_from) [date_from]
                --,DATEADD(dd, 1, CONVERT(datetime, :date_to)) [date_to]
                ,ssh.NumberString [document_no]
                ,convert(varchar,ssh.DocumentDate,104) [document_date]
                ,convert(varchar,ssh.StoreOperationDate,104) [store_operation_date]
                ,a.Code [code]
                ,a.Name [name]
                ,a.CatalogueNumber [catalogue_number]
                --,convert(decimal(19,2), si.Quantity) [quantity]
                ,convert(decimal(19,2), sum(si.Quantity)) [quantity]
                ----------------------------
               	,dc.Code [customer_code]
                ,dcd.Name1 [customer_name]
                ,CONCAT('PL',dcd.TIN) [customer_tin]
                ,case when ad.ApartmentNumber <> '' 
                        then CONCAT(ad.Street, ' ', ad.BuildingNumber,'/',ad.ApartmentNumber)
                        else CONCAT(ad.Street, ' ', ad.BuildingNumber)
                    end [customer_address]
                ,ad.City [customer_city]
                ,ad.ZipCode [customer_zipcode]
                ,ad.Code [customer_countrycode]
                ------------------------------
                ,isnull(hrc.id,0) [contract_customer_id]
            from Sales.Items si
                join SecSales.Headers ssh on si.HeaderID = ssh.ID
                join dbo.Dic_Articles a on si.ArticleID = a.Id
                	--	------ #### dane kastomersa
                join Sales.DocumentCustomers sdc ON sdc.DocumentID = ssh.ID and sdc.CustomerTypeID = :cust
                join dbo.Dic_CustomerData dcd ON dcd.Id = sdc.CustomerDataID
                left join Address.AddressData ad ON ad.AddressDataID = sdc.AddressDataID
                join dbo.Dic_Country co on co.Id = ad.CountryID
                join dbo.Dic_Customers dc on dc.Id = dcd.CustomerID
                ---------- kastomersi z kontraktami    
                left join [projects].[dbo].[hp_reports_customers] hrc on hrc.altum_id = dc.Id
            where 1=1
                and a.Id in (select article_id from [projects].[dbo].[hp_reports_articles])
                and ssh.DocumentTypesID = :doct
                and ssh.StoreOperationDate Between CONVERT(DATETIME, :df) AND DATEADD(dd, 1, CONVERT(DATETIME, :dt))
            group by 
                a.Id, a.Code, a.Name, a.CatalogueNumber
                ,ssh.NumberString, ssh.DocumentDate, ssh.StoreOperationDate
                ,dc.Code
                ,dcd.Name1, dcd.TIN
                ,ad.ApartmentNumber, ad.Street, ad.BuildingNumber, ad.ApartmentNumber, ad.City, ad.ZipCode, ad.Code
                ,hrc.id
            order by a.CatalogueNumber
   	        ", ['doct' => $docType, 'cust' => $customerType, 'df' => $dateFrom, 'dt' => $dateTo]);
        return $results;
    }

    public static function getArticleInOutReport($dateFrom, $dateTo, $docType = 28, $customerType = 0)
    {
        $results = DB::connection('sqlsrv_altum')->select("
            select
                a.Id [article_id]
                --,CONVERT(datetime, :date_from) [date_from]
                --,DATEADD(dd, 1, CONVERT(datetime, :date_to)) [date_to]
                ,ssh.NumberString [document_no]
                ,convert(varchar,ssh.DocumentDate,104) [document_date]
                ,convert(varchar,ssh.StoreOperationDate,104) [store_operation_date]
                ,a.Code [code]
                ,a.Name [name]
                ,a.CatalogueNumber [catalogue_number]
                --,convert(decimal(19,2), si.Quantity) [quantity]
                ,convert(decimal(19,2), sum(si.Quantity)) [quantity]
                ----------------------------
               	,dc.Code [customer_code]
                ,dcd.Name1 [customer_name]
                ,CONCAT('PL',dcd.TIN) [customer_tin]
                ,case when ad.ApartmentNumber <> '' 
                        then CONCAT((case when ad.Street like 'ul.%' then REPLACE(ad.Street,'ul. ','') else ad.Street end), ' ', ad.BuildingNumber,'/',ad.ApartmentNumber)
                        else CONCAT((case when ad.Street like 'ul.%' then REPLACE(ad.Street,'ul. ','') else ad.Street end), ' ', ad.BuildingNumber)
                    end [customer_address]
                ,ad.City [customer_city]
                ,ad.ZipCode [customer_zipcode]
                ,co.Code [customer_countrycode]
                ------------------------------
                ,isnull(hrc.id,0) [contract_customer_id]
                ----- kontrakty --------------
           		,(select max(pah.InternalNumber) from pgiAgreements.Headers pah where pah.CustomerID = dc.Id) [contract_internal_number]
        		,(select REPLACE(CONVERT(varchar,pah.DateOfStart,111),'/','') from pgiAgreements.Headers pah 
			        where pah.InternalNumber = (select max(pah.InternalNumber) from pgiAgreements.Headers pah where pah.CustomerID = dc.Id)) 
			    [contract_start_date]
		        ,isnull((select REPLACE(CONVERT(varchar,pah.DateOfEnd,111),'/','') from pgiAgreements.Headers pah 
			        where pah.InternalNumber = (select max(pah.InternalNumber) from pgiAgreements.Headers pah where pah.CustomerID = dc.Id)),'')
			    [contract_end_date]
                
            from Sales.Items si
                join SecSales.Headers ssh on si.HeaderID = ssh.ID
                join dbo.Dic_Articles a on si.ArticleID = a.Id
                	--	------ #### dane kastomersa
                join Sales.DocumentCustomers sdc ON sdc.DocumentID = ssh.ID and sdc.CustomerTypeID = :cust
                join dbo.Dic_CustomerData dcd ON dcd.Id = sdc.CustomerDataID
                left join Address.AddressData ad ON ad.AddressDataID = sdc.AddressDataID
                left join dbo.Dic_Country co on co.Id = ad.CountryID
                join dbo.Dic_Customers dc on dc.Id = dcd.CustomerID
                
                ---------- kastomersi z kontraktami    
                left join [projects].[dbo].[hp_reports_customers] hrc on hrc.altum_id = dc.Id
            where 1=1
                and a.Id in (select altum_id from [projects].[dbo].[hp_reports_articles])
                and ssh.DocumentTypesID = :doct
                and ssh.StoreOperationDate Between CONVERT(DATETIME, :df) AND DATEADD(dd, 1, CONVERT(DATETIME, :dt))
            group by 
                a.Id, a.Code, a.Name, a.CatalogueNumber
                ,ssh.NumberString, ssh.DocumentDate, ssh.StoreOperationDate
                ,dc.Code, dc.Id
                ,dcd.Name1, dcd.TIN
                ,ad.ApartmentNumber, ad.Street, ad.BuildingNumber, ad.ApartmentNumber, ad.City, ad.ZipCode, co.Code
                ,hrc.id
            order by a.CatalogueNumber
   	        ", ['doct' => $docType, 'cust' => $customerType, 'df' => $dateFrom, 'dt' => $dateTo]);
        return $results;
    }

    // =======================================================================================================================
    // =======================================================================================================================
    // =======================================================================================================================
    // =======================================================================================================================

    public function generateHpReport($date, $previousReportId)
    {
        //var_dump($previousReportId);
        $result = (object)array();
        $data = array();
        $reportId = $this->getHpReportMaxId()->maxReportId + 1;
        $weekData = $this->getWeekData($date);

        $weekStart = $weekData->w_start;
        $weekEnd = $weekData->w_end;
        $weekNo = $weekData->w_no;
        $weekYear = $weekData->year;

        $reportNo = (int)$this->getHpReportMaxNo($weekNo, $weekYear)->maxReportNo + 1;

        /**
         * --------- Zasoby
         */
        $previousInventories = $this->getHpReportsInventories($weekNo, $weekYear, $previousReportId);
        $inventoriesArticelId = array();
        foreach ($previousInventories as $inventory) {
            array_push($inventoriesArticelId, $inventory->article_id);
        }

        // ------------------------------------------------------
        $result->weekData = $weekData;
        $result->reportId = $reportId;
        $result->reportNo = $reportNo;
        $result->previousReportId = $previousReportId;
        $result->previousInventories = $previousInventories;
        // ------------------------------------------------------

        if (!(count($previousInventories) > 0)) {
            //
            //todo obsługa braku zapasów
            //
        } else {
            //
            // lista wszystkich raportowanych artikli
            $articles = $this->getArticles();

            // zapasy po przeliczeniu bieżącego raportu
            $currentInventories = array();

            /**
             * ========== sprzedaż
             */
            // tablica z sumami dostaw dla każdego artikla
            $totalSales = (object)array();
            $sales = $this->getArticleSales($weekStart, $weekEnd);
            // tablica id sprzedanych artykułów - grupowanie na poziomie artykułu
            // jeżeli dla danego artykułu był zakup to jest on wyświetlany i id artykułu wypada z tablicy
            $salesArticleId = array();
            foreach ($sales as $sale) {
                //
                $aid = $sale->article_id;
                array_push($salesArticleId, $aid);
                //
                if (isset($totalSales->$aid)) {
                    $q = (float)$totalSales->$aid;
                    $totalSales->$aid = $q + (float)$sale->quantity;
                } else {
                    $totalSales->$aid = (float)$sale->quantity;
                }
            }
            $salesArticleId = array_unique($salesArticleId); // wywalam duble
            $salesArticleId = array_values($salesArticleId); // reindeksuję tablicę

            /**
             * ------- zakupy
             */
            // tablica z sumami zakupów dla każdego artikla
            $totalPurchases = (object)array();
            $purchases = $this->getArticlePurchases($weekStart, $weekEnd);
            // tablica id zakupionych artykułów - grupowanie na poziomie artykułu
            // jeżeli dla danego artykułu była sprzedaż to id artykułu wypada z tablicy
            $purchasesArticleId = array();
            foreach ($purchases as $purchase) {
                //
                $aid = $purchase->article_id;
                array_push($purchasesArticleId, $aid);
                //
                if (isset($totalPurchases->$aid)) {
                    $q = (float)$totalPurchases->$aid;
                    $totalPurchases->$aid = $q + (float)$purchase->quantity;
                } else {
                    $totalPurchases->$aid = (float)$purchase->quantity;
                }
            }
            $purchasesArticleId = array_unique($purchasesArticleId); // wywalam duble
            $purchasesArticleId = array_values($purchasesArticleId); // reindeksuję tablicę

            $currInvElement = array(
                'report_id' => $reportId,
                'week_no' => $weekNo + 1, // zapasy na następny tydzień
                'year' => $weekYear,
                'article_id' => 0,
                'quantity' => 0,
            );

            /**
             * teraz składamy wszystko do kupy
             * ------------------------------------------------------------------------------------
             */

            // ------- sprzedaż + zakupy
            // -----------------------------------
            foreach ($sales as $sale) {
                //
                $salesUnits = (float)$sale->quantity;
                //if ($salesUnits >= 0) {
                $id = (int)$sale->article_id;
                $customerId = (int)$sale->customer_id;
                $isArticleFirstRow = 0;

                $totalSellinUnits = 0;
                $inventoryUnits = 0;

                $previousIU = 0;
                $totalSU = 0;

                // jak był zakup to do wiersza dodajemy total zakupu i usuwamy id artikla z listy
                // następne artikiele o tym id będą miały w kolumnie 'Total Sellin Units' 0
                foreach ($purchases as $purchase) {
                    if ($purchase->article_id == $id and in_array($id, $purchasesArticleId)) {
                        $totalSellinUnits = $totalPurchases->$id;
                        // usuwanie elementu z tablicy po wartości
                        $purchasesArticleId = array_values(array_filter($purchasesArticleId, fn ($m) => $m != $id));
                    }
                }

                // ustawiamy zasoby Inventory Units
                foreach ($previousInventories as $inventory) {
                    if ($inventory->article_id == $id and in_array($id, $inventoriesArticelId)) {
                        //
                        $isArticleFirstRow = 1;
                        //
                        $inventoryUnits = (float)$inventory->quantity + $totalSellinUnits - $totalSales->$id;
                        $previousIU = (float)$inventory->quantity;
                        $totalSU = (float)$totalSales->$id;
                        $currInvElement['article_id'] = $id;
                        $currInvElement['quantity'] = $inventoryUnits;
                        array_push($currentInventories, $currInvElement);
                        $inventoriesArticelId = array_values(array_filter($inventoriesArticelId, fn ($m) => $m != $id));
                    }
                }

                // ----- report data
                array_push($data,
                    array(
                        'report_id' => $reportId,
                        'report_no' => $reportNo,
                        'week_no' => $weekNo,
                        'year' => $weekYear,
                        'previous_report_id' => $previousReportId,
                        'customer_id' => $customerId,
                        'article_id' => $id,
                        'row_type' => 1,
                        'is_article_first_row' => $isArticleFirstRow,
                        'previous_iu' => $previousIU,
                        'total_su' => $totalSU,

                        'Start period' => str_replace('-', '', $weekStart),
                        'End period' => str_replace('-', '', $weekEnd),

                        'HP Product Number' => $sale->catalogue_number,
                        'Total Sellin Units' => $totalSellinUnits,
                        'Inventory Units' => $inventoryUnits,
                        'Sales Units' => $salesUnits,
                        'Transaction Date' => str_replace('.', '', $sale->store_operation_date),
                        'Channel Partner to Customer Invoice ID' => $sale->document_no,

                        'Sold-to Customer ID' => $sale->customer_code,
                        'Sold To Customer Name' => $sale->customer_name,
                        'Sold To Company Tax ID' => $sale->customer_tin,
                        'Sold To Address Line 1' => $sale->customer_address,
                        'Sold To City' => $sale->customer_city,
                        'Sold To Postal Code' => $sale->customer_zipcode,
                        'Sold To Country Code' => $sale->customer_countrycode,

                        'Ship-to Customer ID' => $sale->customer_code,
                        'Ship To Customer Name' => $sale->customer_name,
                        'Ship To Company Tax ID' => $sale->customer_tin,
                        'Ship To Address Line 1' => $sale->customer_address,
                        'Ship To City' => $sale->customer_city,
                        'Ship To Postal Code' => $sale->customer_zipcode,
                        'Ship To Country Code' => $sale->customer_countrycode,

                        'Contract ID' => $sale->contract_internal_number,
                        'Contract start date' => str_replace('-', '', $sale->contract_start_date),
                        'Contract end date' => str_replace('-', '', $sale->contract_end_date),

                        'Partner Product Name' => '',
                    )
                );
                //}
            }
            // ----------- dostawy bez sprzedaży
            // -----------------------------------
            foreach ($purchases as $purchase) {
                //
                $id = (int)$purchase->article_id;
                $customerId = 0;
                $isArticleFirstRow = 0;


                if (in_array($id, $purchasesArticleId)) {

                    $totalSellinUnits = $totalPurchases->$id;;
                    $inventoryUnits = 0;
                    $salesUnits = 0;

                    $previousIU = 0;
                    $totalSU = 0;

                    // ustawiamy zasoby Inventory Units
                    foreach ($previousInventories as $inventory) {
                        if ($inventory->article_id == $id and in_array($id, $inventoriesArticelId)) {
                            //
                            $isArticleFirstRow = 1;
                            //
                            $inventoryUnits = (float)$inventory->quantity + $totalSellinUnits;
                            $previousIU = (float)$inventory->quantity;
                            //$totalSU = (float)$totalSales->$id;
                            $currInvElement['article_id'] = $id;
                            $currInvElement['quantity'] = $inventoryUnits;
                            array_push($currentInventories, $currInvElement);
                            $inventoriesArticelId = array_values(array_filter($inventoriesArticelId, fn ($m) => $m != $id));
                        }
                    }

                    // ----- report data
                    array_push($data,
                        array(
                            'report_id' => $reportId,
                            'report_no' => $reportNo,
                            'week_no' => $weekNo,
                            'year' => $weekYear,
                            'previous_report_id' => $previousReportId,
                            'customer_id' => $customerId,
                            'article_id' => $id,
                            'row_type' => 2,
                            'is_article_first_row' => $isArticleFirstRow,
                            'previous_iu' => $previousIU,
                            'total_su' => $totalSU,

                            'Start period' => str_replace('-', '', $weekStart),
                            'End period' => str_replace('-', '', $weekEnd),

                            'HP Product Number' => $purchase->catalogue_number,
                            'Total Sellin Units' => $totalSellinUnits,
                            'Inventory Units' => $inventoryUnits,
                            'Sales Units' => $salesUnits,
                            'Transaction Date' => str_replace('.', '', $purchase->store_operation_date),
                            'Channel Partner to Customer Invoice ID' => $purchase->document_no,

                            'Sold-to Customer ID' => '',
                            'Sold To Customer Name' => '',
                            'Sold To Company Tax ID' => '',
                            'Sold To Address Line 1' => '',
                            'Sold To City' => '',
                            'Sold To Postal Code' => '',
                            'Sold To Country Code' => '',

                            'Ship-to Customer ID' => '',
                            'Ship To Customer Name' => '',
                            'Ship To Company Tax ID' => '',
                            'Ship To Address Line 1' => '',
                            'Ship To City' => '',
                            'Ship To Postal Code' => '',
                            'Ship To Country Code' => '',

                            'Contract ID' => '',
                            'Contract start date' => '',
                            'Contract end date' => '',

                            'Partner Product Name' => $sale->catalogue_number,
                        )
                    );
                }
            }

            /**
             * ---------- brak sprzedaży i dostaw
             */
            foreach ($articles as $article) {
                //
                $id = (int)$article->article_id;
                $customerId = 0;
                $isArticleFirstRow = 0;

                if (in_array($id, $inventoriesArticelId)) {
                    //
                    $totalSellinUnits = 0;
                    $inventoryUnits = 0;
                    $salesUnits = 0;

                    $previousIU = 0;
                    $totalSU = 0;

                    foreach ($previousInventories as $inventory) {
                        if ($inventory->article_id == $id and in_array($id, $inventoriesArticelId)) {
                            //
                            $isArticleFirstRow = 1;
                            //
                            $inventoryUnits = (float)$inventory->quantity;
                            $previousIU = (float)$inventory->quantity;
                            //$totalSU = (float)$totalSales->$id;
                            $currInvElement['article_id'] = $id;
                            $currInvElement['quantity'] = $inventoryUnits;
                            array_push($currentInventories, $currInvElement);
                            $inventoriesArticelId = array_values(array_filter($inventoriesArticelId, fn ($m) => $m != $id));
                        }
                    }

                    if ($inventoryUnits > 0) {

                        // ----- report data
                        array_push($data,
                            array(
                                'report_id' => $reportId,
                                'report_no' => $reportNo,
                                'week_no' => $weekNo,
                                'year' => $weekYear,
                                'previous_report_id' => $previousReportId,
                                'customer_id' => $customerId,
                                'article_id' => $id,
                                'row_type' => 3,
                                'is_article_first_row' => $isArticleFirstRow,
                                'previous_iu' => $previousIU,
                                'total_su' => $totalSU,

                                'Start period' => str_replace('-', '', $weekStart),
                                'End period' => str_replace('-', '', $weekEnd),

                                'HP Product Number' => $article->catalogue_number,
                                'Total Sellin Units' => $totalSellinUnits,
                                'Inventory Units' => $inventoryUnits,
                                'Sales Units' => $salesUnits,
                                'Transaction Date' => '',
                                'Channel Partner to Customer Invoice ID' => '',

                                'Sold-to Customer ID' => '',
                                'Sold To Customer Name' => '',
                                'Sold To Company Tax ID' => '',
                                'Sold To Address Line 1' => '',
                                'Sold To City' => '',
                                'Sold To Postal Code' => '',
                                'Sold To Country Code' => '',

                                'Ship-to Customer ID' => '',
                                'Ship To Customer Name' => '',
                                'Ship To Company Tax ID' => '',
                                'Ship To Address Line 1' => '',
                                'Ship To City' => '',
                                'Ship To Postal Code' => '',
                                'Ship To Country Code' => '',

                                'Contract ID' => '',
                                'Contract start date' => '',
                                'Contract end date' => '',

                                'Partner Product Name' => '',
                            )
                        );
                    }

                }
            }

            /**
             * -------------- zapis
             */
            if (isset($data[0])) {
                foreach ($currentInventories as $row) {
                    HpReportsInventory::insert($row);
                }
                foreach ($data as $row) {
                    HpReport::insert($row);
                }
            }

            // ========================
            $result->articles = $articles;
            $result->previousInventories = $previousInventories;
            $result->inventoriesArticelId = $inventoriesArticelId;
            $result->currentInventories = $currentInventories;
            $result->sales = $sales;
            $result->salesArticleId = $salesArticleId;
            $result->totalSales = $totalSales;
            $result->purchasesArticleId = $purchasesArticleId;
            $result->data = $data[0];
        }

        // ------------------------------------------------------
        return $result;
    }

    public function getPreviousHpReports($date)
    {
        $currentWeekData = $this->getWeekData($date);
        //var_dump($currentWeekData);

        $currentWeekNo = (int)$currentWeekData->w_no;
        $previousWeekNo = $currentWeekNo - 1;

        $currentYear = (int)$currentWeekData->year;
        $previousYear = $currentYear - 1;

        // wyższy priorytet mają raporty z poprzedniego tygodnia
        // sprawdzamy czy poprzedni tydzień nie jest 0
        // jak jest zmieniamy rok
        if ($previousWeekNo > 0) {
            $weekNo = $previousWeekNo;
            $year = $currentYear;
        } else {
            $weeks = $this->getWeeksOfYear($previousYear);
            $lastWeek = end($weeks); // ostatni tydzień roku
            $weekNo = $lastWeek->w_no;
            $year = $previousYear;
        }
        $previousRepId = $this->getHpReportsIdByDate($weekNo, $year);
        //var_dump(count($previousRepId));

        // dodatkowo sprawdzamy zasoby źródłowe dla bieżącego tygodnia
        $inventories = $this->getHpReportsInventories($currentWeekNo, $currentYear, 0);
        //var_dump(count($inventories));

        // i składamy wszystko do kupy
        $previousReportsId = $previousRepId;
        if (count($inventories) > 0) {
            $previousReportsId[0] = (object)[
                'report_id' => "0",
                'report_no' => "0",
                'year' => "$currentYear",
                'week_no' => "$currentWeekNo",
                'previous_report_id' => "0"
            ];
        }
        //var_dump($previousReportsId);
        ksort($previousReportsId); // sortowanie tablicy po indeksach
        return $previousReportsId;
    }

    public function getHpReportMaxNo($weekNo, $year)
    {
        $results = DB::connection('sqlsrv')->select("
            select isnull(max(report_no),0) [maxReportNo] from [dbo].[hp_reports] where week_no = :weekno and year = :year
        ", ['weekno' => $weekNo, 'year' => $year]);
        return $results[0];
    }

    /**
     * dane tygodnia wyliczane funkcjami serwerowymi na podstawie daty
     *
     * @param null $date string 'yyyy-mm-dd'
     * @return mixed
     *
     *  year, w_no, w_start, w_end
     */
    public function getWeekData($date = null)
    {
        $results = DB::connection('sqlsrv')->select("EXEC [dbo].[getFirstLastDayOfWeek] @date = :date", ['date' => $date]);
        return $results[0];
    }

    /**
     * lista tygodni w roku
     *
     * @param null $year string 'yyyy'
     * @return array
     *
     *  w_no, w_start, w_end
     */
    public function getWeeksOfYear($year = null)
    {
        $res = DB::connection('sqlsrv')->select(
            "EXEC [dbo].[getWeeksOfYear] @year = :year", ['year' => $year]
        );
        $results = array();
        foreach ($res as $row) {
            $results[$row->w_no] = $row;
        }
        return $results;
    }

    /**
     * raporty wykonwne dla określonego tygodnia i roku
     *
     * @param $weekNo int
     * @param $year int
     * @return array
     *
     * report_id, report_no, year, week_no, previous_report_id
     */
    public function getHpReportsIdByDate($weekNo, $year)
    {
        $res = DB::connection('sqlsrv')->select("
            select distinct report_id, report_no, year, week_no, previous_report_id 
            from [dbo].[hp_reports] where week_no = :weekno and year = :year
	    ", ['weekno' => $weekNo, 'year' => $year]);
        $results = array();
        foreach ($res as $row) {
            $results[$row->report_id] = $row;
        }
        return $results;
    }

    /**
     * id ostatniego raportu
     *
     * @return int
     */
    public function getHpReportMaxId()
    {
        $results = DB::connection('sqlsrv')->select("select isnull(max(report_id),0) [maxReportId] from [dbo].[hp_reports]");
        return $results[0];
    }

    /**
     * zapasy dla określonego tygodnia i roku
     *
     * @param $weekNo int
     * @param $year int
     * @param $reportId int
     * @return array
     */
    public function getHpReportsInventories($weekNo, $year, $reportId)
    {
        $res = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_inventories] where week_no = :weekno and year = :year and report_id = :reportid
	    ", ['weekno' => $weekNo, 'year' => $year, 'reportid' => $reportId]);
        $results = array();
        foreach ($res as $row) {
            $row->quantity = (float)$row->quantity;
            $results[$row->article_id] = $row;
        }
        return $results;
    }

    /**
     *  lista wszystkich raportowanych artikili
     *
     * @return array
     */
    public static function getArticles()
    {
        $res = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_articles]
	    ");
        $results = array();
        foreach ($res as $row) {
            $results[$row->article_id] = $row;
        }
        return $results;
    }

    /**
     * lista sprzedanych artykułów - grupowanie na poziomie kontrahenta
     *
     * @param $dateFrom : string 'yyyy-mm-dd'
     * @param $dateTo : string 'yyyy-mm-dd'
     * @param int $docType : default 28 - WZ
     * @param int $customerType : default 0 - nabywca purchaser
     * @return array
     */
    public function getArticleSales($dateFrom, $dateTo, $docType = 28, $cusType = 0)
    {
        $results = DB::connection('sqlsrv_altum')->select("
            select
                a.Id [article_id]
                --,CONVERT(datetime, :date_from) [date_from]
                --,DATEADD(dd, 1, CONVERT(datetime, :date_to)) [date_to]
                ,ssh.NumberString [document_no]
                ,convert(varchar,ssh.DocumentDate,104) [document_date]
                ,convert(varchar,ssh.StoreOperationDate,104) [store_operation_date]
                ,a.Code [code]
                ,a.Name [name]
                ,a.CatalogueNumber [catalogue_number]
                --,convert(decimal(19,2), si.Quantity) [quantity]
                ,convert(decimal(19,2), sum(si.Quantity)) [quantity]
                ----------------------------
               	,dc.Id [customer_id]
               	,dc.Code [customer_code]
                ,dcd.Name1 [customer_name]
                ,CONCAT('PL',dcd.TIN) [customer_tin]
                ,case when ad.ApartmentNumber <> '' 
                        then CONCAT((case when ad.Street like 'ul.%' then REPLACE(ad.Street,'ul. ','') else ad.Street end), ' ', ad.BuildingNumber,'/',ad.ApartmentNumber)
                        else CONCAT((case when ad.Street like 'ul.%' then REPLACE(ad.Street,'ul. ','') else ad.Street end), ' ', ad.BuildingNumber)
                    end [customer_address]
                ,ad.City [customer_city]
                ,ad.ZipCode [customer_zipcode]
                ,co.Code [customer_countrycode]
                ------------------------------
                ,isnull(hrc.id,0) [contract_customer_id]
                ----- kontrakty --------------
           		,isnull((select max(pah.InternalNumber) from pgiAgreements.Headers pah where pah.CustomerID = dc.Id),'') [contract_internal_number]
        		,isnull((select REPLACE(CONVERT(varchar,pah.DateOfStart,111),'/','') from pgiAgreements.Headers pah 
			        where pah.InternalNumber = (select max(pah.InternalNumber) from pgiAgreements.Headers pah where pah.CustomerID = dc.Id)),'') 
			    [contract_start_date]
		        ,isnull((select REPLACE(CONVERT(varchar,pah.DateOfEnd,111),'/','') from pgiAgreements.Headers pah 
			        where pah.InternalNumber = (select max(pah.InternalNumber) from pgiAgreements.Headers pah where pah.CustomerID = dc.Id)),'')
			    [contract_end_date]
                --------- stan doca
                ,ds.Name [document_state]
                
            from Sales.Items si
                join SecSales.Headers ssh on si.HeaderID = ssh.ID
                join dbo.Dic_Articles a on si.ArticleID = a.Id
                join  DT.States ds on ssh.DocumentStateID = ds.ID
                	--	------ #### dane kastomersa
                join Sales.DocumentCustomers sdc ON sdc.DocumentID = ssh.ID and sdc.CustomerTypeID = :custype
                join dbo.Dic_CustomerData dcd ON dcd.Id = sdc.CustomerDataID
                left join Address.AddressData ad ON ad.AddressDataID = sdc.AddressDataID
                left join dbo.Dic_Country co on co.Id = ad.CountryID
                join dbo.Dic_Customers dc on dc.Id = dcd.CustomerID
                
                ---------- kastomersi z kontraktami    
                left join [projects].[dbo].[hp_reports_customers] hrc on hrc.altum_id = dc.Id
            where 1=1
                and a.Id in (select article_id from [projects].[dbo].[hp_reports_articles])
                and ssh.DocumentTypesID in (28,30)
                and ssh.StoreOperationDate Between CONVERT(DATETIME, :df) AND DATEADD(dd, 1, CONVERT(DATETIME, :dt))
                --and ds.Name <> 'Anulowany'
                --and ds.ID not in (125,126) -- usunięty, anulowany dla WZ
                and (ds.StateType <> 16 and ds.StateType <> 32) ---- nie usunięty i nie anulowany
                --and a.CatalogueNumber = 'W9004MC'
            group by 
                a.Id, a.Code, a.Name, a.CatalogueNumber
                ,ssh.NumberString, ssh.DocumentDate, ssh.StoreOperationDate
                ,dc.Code, dc.Id
                ,dcd.Name1, dcd.TIN
                ,ad.ApartmentNumber, ad.Street, ad.BuildingNumber, ad.ApartmentNumber, ad.City, ad.ZipCode, co.Code
                ,hrc.id
                ,ds.Name
            order by a.CatalogueNumber
   	        ", ['df' => $dateFrom, 'dt' => $dateTo, 'custype' => $cusType]);
        return $results;
    }

    /**
     * lista zakupionych artykułów - grupowanie na poziomie kontrahenta
     *
     * @param $dateFrom : string 'yyyy-mm-dd'
     * @param $dateTo : string 'yyyy-mm-dd'
     * @param int $customerType : default 2 - dostawca supplier
     * @return array
     */
    public function getArticlePurchases($dateFrom, $dateTo, $customerType = 2)
    {
        $results = DB::connection('sqlsrv_altum')->select("
            select
                a.Id [article_id]
                ,ssh.NumberString [document_no]
                ,convert(varchar,ssh.DocumentDate,104) [document_date]
                ,convert(varchar,ssh.StoreOperationDate,104) [store_operation_date]
                ,a.Code [code]
                ,a.Name [name]
                ,a.CatalogueNumber [catalogue_number]
                --,convert(decimal(19,2), si.Quantity) [quantity]
                ,convert(decimal(19,2), sum(si.Quantity)) [quantity]
                ----------------------------
                ,dc.Id [customer_id]
               	,dc.Code [customer_code]
                ,dcd.Name1 [customer_name]
                ,CONCAT('PL',dcd.TIN) [customer_tin]
                ,case when ad.ApartmentNumber <> '' 
                        then CONCAT((case when ad.Street like 'ul.%' then REPLACE(ad.Street,'ul. ','') else ad.Street end), ' ', ad.BuildingNumber,'/',ad.ApartmentNumber)
                        else CONCAT((case when ad.Street like 'ul.%' then REPLACE(ad.Street,'ul. ','') else ad.Street end), ' ', ad.BuildingNumber)
                    end [customer_address]
                ,ad.City [customer_city]
                ,ad.ZipCode [customer_zipcode]
                ,co.Code [customer_countrycode]
                ------------------------------
                ,ds.Name [document_state]
                
            from Sales.Items si
                join SecSales.Headers ssh on si.HeaderID = ssh.ID
                join dbo.Dic_Articles a on si.ArticleID = a.Id
                join  DT.States ds on ssh.DocumentStateID = ds.ID
                	--	------ #### dane kastomersa
                join Sales.DocumentCustomers sdc ON sdc.DocumentID = ssh.ID and sdc.CustomerTypeID = :cust
                join dbo.Dic_CustomerData dcd ON dcd.Id = sdc.CustomerDataID
                left join Address.AddressData ad ON ad.AddressDataID = sdc.AddressDataID
                left join dbo.Dic_Country co on co.Id = ad.CountryID
                join dbo.Dic_Customers dc on dc.Id = dcd.CustomerID
                
                ---------- kastomersi z kontraktami    
                left join [projects].[dbo].[hp_reports_customers] hrc on hrc.altum_id = dc.Id
            where 1=1
                and a.Id in (select article_id from [projects].[dbo].[hp_reports_articles])
                and ssh.DocumentTypesID in (5,31,33,87)
                and ssh.StoreOperationDate Between CONVERT(DATETIME, :df) AND DATEADD(dd, 1, CONVERT(DATETIME, :dt))
                --and ds.Name <> 'Anulowany'
                --and ds.ID not in (19,20,143,144) -- usunięty, anulowany dla PW i PZ
                and (ds.StateType <> 16 and ds.StateType <> 32) ---- nie usunięty i nie anulowany
                --and a.CatalogueNumber = 'W9004MC'
            group by 
                a.Id, a.Code, a.Name, a.CatalogueNumber
                ,ssh.NumberString, ssh.DocumentDate, ssh.StoreOperationDate
                ,dc.Code, dc.Id
                ,dcd.Name1, dcd.TIN
                ,ad.ApartmentNumber, ad.Street, ad.BuildingNumber, ad.ApartmentNumber, ad.City, ad.ZipCode, co.Code
                ,ds.Name
            order by a.CatalogueNumber
   	        ", ['cust' => $customerType, 'df' => $dateFrom, 'dt' => $dateTo]);
        return $results;
    }

    /**
     * dane do widoku raportu wg wymagań HP
     *
     * @param $reportId integer
     * @param string $mode
     * @return array
     */
    public function getHpReportForShow($reportId, $mode = 'all')
    {
        $res = DB::connection('sqlsrv')->select("
            select 
                hr.*
                ,case when hrc.id is not null or ([Sales Units] = 0 and hrc.id is null) then 1 else 0 end [has_contract]
            from [dbo].[hp_reports] hr
            left join [dbo].[hp_reports_customers] hrc on hrc.altum_id = hr.customer_id
            where report_id = :rid
        ", ['rid' => $reportId]);

        $results = array();
        foreach ($res as $row) {
            $results[$row->id] = $row;
        }

        switch ($mode) {
            case 'show':
                // formatujemy wartości
                foreach ($results as $row) {
                    $row->{'Total Sellin Units'} = number_format($row->{'Total Sellin Units'}, 2, ',', ' ');
                    $row->{'Inventory Units'} = number_format($row->{'Inventory Units'}, 2, ',', ' ');
                    $row->{'Sales Units'} = number_format($row->{'Sales Units'}, 2, ',', ' ');
                }
                break;
            case 'edit':
                $this->checkReportCohesion($results);
                // formatujemy wartości
                foreach ($results as $row) {
                    $row->{'Total Sellin Units'} = (float)($row->{'Total Sellin Units'});
                    $row->{'Inventory Units'} = (float)($row->{'Inventory Units'});
                    $row->{'Sales Units'} = (float)($row->{'Sales Units'});
                }
                break;
            default:
        }
        return $results;
    }

    public function unsetTableColumn($table, $columns)
    {
        foreach ($table as $row) {
            foreach ($columns as $column) {
                unset($row->{$column});
            }
        }
    }

    public function checkReportCohesion($report)
    {
        $totalSUtab = array();
        $articleRows = array();
        $previousArticleId = 0;
        $totalSU = 0;

        foreach ($report as $row) {
            //
            $rowId = $row->id;
            $articleId = $row->article_id;
            $articleRows[$articleId][] = $rowId;
            if ($articleId != $previousArticleId) {
                //
                $totalSUtab[$previousArticleId] = $totalSU;
                $totalSU = 0;
            }
            $totalSU += $row->{'Sales Units'};
            $previousArticleId = $articleId;
        }
        $totalSUtab[$previousArticleId] = $totalSU;

        $previousArticleId = 0;
        foreach ($report as $row) {
            //
            $articleId = $row->article_id;
            if ($articleId != $previousArticleId) {
                //
                $previousIU = $row->previous_iu;
                $iu = $row->{'Inventory Units'} - $row->{'Total Sellin Units'} + $totalSUtab[$articleId];
                if ($previousIU != $iu) {
                    //
                    foreach ($articleRows[$articleId] as $r) {
                        $report[$r]->{'is_cohesive'} = 0;
                    }
                }
            }
            $previousArticleId = $articleId;
        }
    }

    /**
     * lista raportów
     *
     * @return array
     */
    public function getHpReportList()
    {
        $res = DB::connection('sqlsrv')->select("
            select
               hr.report_id [report_id]
               ,concat(hr.report_no,'/',hr.week_no,'/',hr.year) [report_no]
               ,hr.week_no [week_no]
               ,hr.year [year]
               ,hr.previous_report_id [previous_report_id] 
               ,case when phr.report_no IS NULL then '' else concat(phr.report_no,'/',phr.week_no,'/',phr.year) end [previous_report_no]
            from [dbo].[hp_reports] hr
            left join [dbo].[hp_reports] phr on phr.id = hr.previous_report_id
            order by  hr.week_no, hr.year, hr.report_no
	    ");
        $results = array();
        foreach ($res as $row) {
            $results[$row->report_id] = $row;
        }
        return $results;
    }

    /**
     * usuwanie powiązanych wpisów w tabelach hp_reports_inventories i hp_reports
     *
     * @param $reportId integer
     * @return array
     */
    public function destroyHpReport($reportId)
    {
        $results = array();
        $res = DB::connection('sqlsrv')->delete("
            delete from [dbo].[hp_reports_inventories] where report_id = :rid
            ", ['rid' => $reportId]);
        $results[] = $res;
        $res = DB::connection('sqlsrv')->delete("
            delete from [dbo].[hp_reports] where report_id = :rid
            ", ['rid' => $reportId]);
        $results[] = $res;
        return $results;
    }

    public function updateHpReport($data)
    {
        $results = array();
        foreach ($data as $key => $row) {
            //
            $res = DB::connection('sqlsrv')->update("
                update [dbo].[hp_reports] set 
                    [Total Sellin Units] = :tsu
                    ,[Inventory Units] = :iu
                    ,[Sales Units] = :su
                where id = :id
            ", ['tsu' => $row->tsu, 'iu' => $row->iu, 'su' => $row->su, 'id' => $key]);
            $results[] = $res;
        }
        return $results;
    }

}
