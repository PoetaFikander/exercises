<?php

namespace App\Http\Controllers;


use App\Models\HpReportsInventory;
use Illuminate\Http\Request;
use App\Models\HpReport;
use App\Repositories\HpReportRepository;
use App\Traits\GlobalTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Exception;

class HpReportController extends Controller
{
    use GlobalTrait;
    public $s; // settings
    public $years = [2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027]; // lista lat do selekta

    public function __construct()
    {
        foreach ($this->getAllSettings() as $set) {
            $this->s[$set->name] = $set->value;
        }
    }

    /**
     * sprzdaż i zakup liczone są w ramach pełnych tygodni
     * lista artykułów podlegających raportowi
     * todo
     * opisać warunki trafienia artykułu na listę
     * stworzyć:
     *  mechanizm automatycznej aktualizacji listy
     *  mechanizm ręcznego dodawania i usuwania artykułów z listy
     * list kontrachentów posiadająca kontrakt
     * todo
     * stworzyć:
     *  mechanizm automatycznej aktualizacji listy
     *  mechanizm ręcznego dodawania i usuwania kontrahentów z listy wraz z aktualizacją w Altum
     *
     * ID    Name
     * 5    Przychód wewnętrzny
     * 6    Rozchód wewnętrzny
     * 28    Wydanie zewnętrzne
     * 30    Korekta ilościowa wydania zewnętrznego
     * 31    Przyjęcie zewnętrzne
     * 33    Korekta ilościowa przyjęcia zewnętrznego
     * 87    Korekta ilościowa przychodu wewnętrznego
     * 89    Korekta ilościowa rozchodu wewnętrznego
     *
     *
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hpreport.index');
    }

    /**
     * reports
     * ---------------------------------------------------------------
     */

    public function reportList(HpReportRepository $hprRepo)
    {
        $reports = $hprRepo->getHpReportList();
        return view('hpreport.reports.list', ['reports' => $reports]);
    }

    public function reportShow(HpReportRepository $hprRepo, $id)
    {
        //
        $report = $hprRepo->getHpReportForShow($id);
        return view('hpreport.reports.show', ['report' => $report]);
    }

    public function reportEdit(HpReportRepository $hprRepo, $id)
    {
        //
        $report = $hprRepo->getHpReportForShow($id, true);
        return view('hpreport.reports.edit', ['report' => $report]);
    }

    public function reportDestroy(HpReportRepository $hprRepo, $id)
    {
        try {
            $hprRepo->destroyHpReport($id);
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    public function reportCreate(HpReportRepository $hprRepo, Request $request)
    {
        // -------------------------------------
        $report = array();
        $method = $request->method();
        $errors = 0; // flaga statusu
        $message = '';
        // -------------------------------------
        if ($method == 'GET') {
            //
            $date = date("Y-m-d"); // now
            //$date = '2023-01-09'; // now
        } else {
            //var_dump($request->all());
            $date = $request->input('for_week');
        }

        if ($method == 'POST') {
            //-------- generuj raport
            $date = $request->input('for_week');
            $previousReportId = (int)$request->input('for_reportid');
            $result = array();
            if ($previousReportId >= 0) {
                $result = $hprRepo->generateHpReport($date, $previousReportId);
                $report = $hprRepo->getHpReportForShow($result->reportId);
            } else {
                $errors = 1;
                $message = 'Brak raportu źródłowego oraz zasobów początkowych.';
            }
            //dd($result);
        }
        // =========================================================================================
        $weekData = $hprRepo->getWeekData($date);
        $weeks = $hprRepo->getWeeksOfYear($weekData->year);
        $previousReports = $hprRepo->getPreviousHpReports($date);
        // ------------------------------
        $headers = isset($report[0]) ? $report[0] : array();
        // ------------------------------
        $articlesData = (object)[
            'years' => $this->years,
            'weekData' => $weekData,
            'weeks' => $weeks,
            'previousReports' => $previousReports,
            'pReSelected' => end($previousReports), // raport - select option:selected
            'headers' => $headers,
            'report' => $report,
            'errors' => $errors,
            'message' => $message,
        ];
        return view('hpreport.reports.create', ['ad' => $articlesData]);
    }


    /**
     * helpers
     * ---------------------------------------------------------------
     */

    public function getWeeks(HpReportRepository $hprRepo, Request $request)
    {
        if (Auth::check() && $request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->weeks = $hprRepo->getWeeksOfYear($json->year);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

    public function getReportsNo(HpReportRepository $hprRepo, Request $request)
    {
        if (Auth::check() && $request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->previousReports = $hprRepo->getPreviousHpReports($json->date);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

    /**
     * customers
     * ---------------------------------------------------------------
     */

    public function customersList()
    {
        $customers = HpReportRepository::getCustomers();
        //dd($customers);
        return view('hpreport.customers.list', ['customers' => $customers]);
    }

    public function getCustomersFromAltum(HpReportRepository $hprRepo, Request $request)
    {
        if (Auth::check() && $request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            //var_dump($json->data->customerName);
            $json->customers = $hprRepo->getCustomersFromAltum($json->data->customerName, $json->data->customerTin);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

    public function addCustomer(HpReportRepository $hprRepo, Request $request)
    {
        if (Auth::check() && $request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $result = $hprRepo->addCustomer((int)$json->id);
            if ($result) {
                $json->status = '200';
                $json->message = 'Kontrahent został dodany do listy.';
            } else {
                $json->status = '400';
                $json->message = 'Wystąpił błąd!.';
            }
            $json->result = $result;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

    public function deleteCustomer(HpReportRepository $hprRepo, $id)
    {
        try {
            $hprRepo->deleteCustomer($id);
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }


    /**
     * articles
     * ---------------------------------------------------------------
     */

    public function articlesList(HpReportRepository $hprRepo)
    {
        $articles = $hprRepo->getArticles();
        return view('hpreport.articles.list', ['articles' => $articles]);
    }


    public function articlesPurchases(HpReportRepository $hprRepo, $date = null)
    {
        if (is_null($date)) $date = date("Y-m-d"); // now
        $customerType = 2; // dostawca supplier
        $weekData = $hprRepo->getWeekData($date);
        $weeks = $hprRepo->getWeeksOfYear($weekData->year);
        $articles = $hprRepo->getArticlePurchases($weekData->w_start, $weekData->w_end, $customerType);
        $articlesData = (object)[
            'years' => $this->years,
            'weekData' => $weekData,
            'weeks' => $weeks,
            'articles' => $articles,
        ];
        return view('hpreport.articles.purchases', ['ad' => $articlesData]);
    }


    public function articlesSale(HpReportRepository $hprRepo, $date = null)
    {
        if (is_null($date)) $date = date("Y-m-d"); // now
        //$docType = 28; // WZ
        //var_dump($date);
        //$customerType = 0; // nabywca purchaser
        //$articlesData = $this->getArticleInOut($hprRepo,$date, $docType, $customerType);
        $weekData = $hprRepo->getWeekData($date);
        //var_dump($weekData);
        $weeks = $hprRepo->getWeeksOfYear($weekData->year);
        $articles = $hprRepo->getArticleSales($weekData->w_start, $weekData->w_end);
        //print_r($articles);
        $articlesData = (object)[
            'years' => $this->years,
            'weekData' => $weekData,
            'weeks' => $weeks,
            'articles' => $articles,
        ];
        return view('hpreport.articles.sale', ['ad' => $articlesData]);
    }


    public function getArticleInOut($hprRepo, $date, $docType, $customerType)
    {
        //var_dump($date);
        $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
        $weeks = $hprRepo->getWeeksOfYear($weekDays->year);
        $articles = HpReportRepository::getArticleInOut($weekDays->w_start, $weekDays->w_end, $docType, $customerType);
        $articlesData = (object)[
            'years' => $this->years,
            'weekDays' => $weekDays,
            'weeks' => $weeks,
            'articles' => $articles,
        ];
        return $articlesData;
    }


    public function articlesShow(HpReportRepository $hpReport, $id)
    {
        //
        $article = $hpReport->getArticle($id);
        $stocks = $hpReport->getArticleStocks($id);

        $quantity = 0;
        $reservations = 0;
        $orders = 0;

        foreach ($stocks as $stock) {
            // rezerwacje blokujące
            if ($stock->quantity > 0 && $stock->reservations > 0) {
                $stock->is_blocked = true;
            } else {
                $stock->is_blocked = false;
            }
            $quantity += $stock->quantity;
            $reservations += $stock->reservations;
            $orders += $stock->orders;
        }
        $article->quantity = $quantity;
        $article->reservations = $reservations;
        $article->orders = $orders;
        return view('hpreport.articles.show', ['article' => $article, 'stocks' => $stocks]);
    }


    public function getArticleById($id)
    {
        // restApi by CURL działa ok
        $apiBaseUrl = $this->s['restApi_baseUrl'];
        $apiMethod = $this->s['restApi_articles_getbyid'];
        $url = $apiBaseUrl . $apiMethod . $id;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        $datasearch = json_decode($data, true);
        curl_close($curl);
        dd($datasearch);
    }


    /**
     * ---------------------------------------------------------------------------------------------------------------
     */

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\HpReport $hpReport
     * @return \Illuminate\Http\Response
     */
    public function show(HpReport $hpReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\HpReport $hpReport
     * @return \Illuminate\Http\Response
     */
    public function edit(HpReport $hpReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HpReport $hpReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HpReport $hpReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\HpReport $hpReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(HpReport $hpReport)
    {
        //
    }
}
