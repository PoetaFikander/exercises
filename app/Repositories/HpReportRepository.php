<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\DB;

class HpReportRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
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

}
