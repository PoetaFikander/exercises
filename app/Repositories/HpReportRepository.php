<?php


namespace App\Repositories;


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

    public static function getCustomersFromAltum()
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


    public function getAltumArticles()
    {
        $results = DB::connection('sqlsrv_altum')->select("
                select 
                    a.Id [altum_id]
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
                select altum_id into #t1
                from [projects].[dbo].[hp_reports_articles];
                
                insert into [projects].[dbo].[hp_reports_articles]
                (
                   [altum_id]
                   ,[code]
                   ,[name]
                   ,[catalogue_number]
                )
                select 
                    a.Id [altum_id]
                    ,a.Code [code]
                    ,a.Name [name]
                    ,a.CatalogueNumber [catalogue_number]
                from [dbo].[Dic_Articles] a
                where 1=1
                    and a.Name like '%toner% HP %'
                    and a.Code like '%*R'
                    and a.Id not in (select altum_id from #t1);
                    
                drop table #t1;
	    ");
        return $results;
    }

    public function getArticles()
    {
        $results = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_articles]
	    ");
        return $results;
    }

    public function getArticle($id)
    {
        $results = DB::connection('sqlsrv')->select("
            select * from [dbo].[hp_reports_articles] where altum_id = :id
	    ", ['id' => $id]);
        return $results[0];
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
            "EXEC [dbo].[getFirstLastDayOfWeek] @p1 = :date", ['date' => $date]
        );
        return $results[0];
    }

    public static function getWeeksOfYear($date = null)
    {
        $results = DB::connection('sqlsrv')->select(
            "EXEC [dbo].[getWeeksOfYear] @p1 = :date", ['date' => $date]
        );
        return $results;
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
                and a.Id in (select altum_id from [projects].[dbo].[hp_reports_articles])
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

    public static function getArticleSales($dateFrom, $dateTo, $docType = 28, $customerType = 0)
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

    public static function getArticlePurchases($dateFrom, $dateTo, $docType = 31, $customerType = 2)
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
            order by a.CatalogueNumber
   	        ", ['doct' => $docType, 'cust' => $customerType, 'df' => $dateFrom, 'dt' => $dateTo]);
        return $results;
    }
}
