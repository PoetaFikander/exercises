<?php

namespace App\Http\Controllers;

use App\Models\HpReport;
use App\Repositories\HpReportRepository;
use Illuminate\Http\Request;

class HpReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('hpreport.index');
    }


    public function articles(HpReportRepository $hprRepo)
    {
        //
        //$hprRepo->compareArticles();
        $articles=$hprRepo->getArticles();
        return view('hpreport.articles',['articles'=>$articles]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HpReport  $hpReport
     * @return \Illuminate\Http\Response
     */
    public function show(HpReport $hpReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HpReport  $hpReport
     * @return \Illuminate\Http\Response
     */
    public function edit(HpReport $hpReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HpReport  $hpReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HpReport $hpReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HpReport  $hpReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(HpReport $hpReport)
    {
        //
    }
}
