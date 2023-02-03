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
        //$report = $hprRepo->getHpReportForShow($id);
        //return view('hpreport.reports.show', ['report' => $report]);
    }

    public function reportDestroy(HpReportRepository $hprRepo, $id)
    {
        try {
            $hprRepo->destroyHpReport($id);
            return response()->json([
                'status' => 'success'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
            ],500);
        }
    }

    public function reportCreate(HpReportRepository $hprRepo, Request $request)
    {
        // -------------------------------------
        $report = array();
        $method = $request->method();
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
        ];
        return view('hpreport.reports.create', ['ad' => $articlesData]);
    }

    public function reportCreateBak(Request $request)
    {
        //var_dump($request->all());
        $data = array();
        $method = $request->method();

        if ($method == 'GET') {
            $date = date("Y-m-d"); // now
        } else {
            $date = $request->input('for_week');
        }

        // ----------- daty
        $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
        $weeks = HpReportRepository::getWeeksOfYear($weekDays->year);

        // ----------- poprzednie raporty
        $lastReports = HpReportRepository::getHpReportsIdByDate($weekDays->w_no, $weekDays->year);
        // jeżeli nie było poprzednich raportów
        if (!(count((array)$lastReports) > 0)) {
            array_push($lastReports, (object)array('report_id' => 0, 'report_no' => '0-' . $weekDays->w_no . '-' . $weekDays->year));
        }

        if ($method == 'POST') {
            //
            $lastReportId = (int)$request->input('for_reportid');
            $reportId = (int)HpReportRepository::getHpReportMaxId()->maxReportId + 1;
            $reportNo = $reportId . '-' . $weekDays->w_no . '-' . $weekDays->year;
            //var_dump($reportId);
            $lastInventories = HpReportRepository::getHpReportsInventories($weekDays->w_no, $weekDays->year, $lastReportId);

            // ------- zapasy po bieżącym raporcie
            $hpReportsInventories = array();

            if (count((array)$lastInventories) > 0) {

                // ------- wszystkie artykuły
                $articles = HpReportRepository::getArticles();


                // ------- sprzedaż
                // lista sprzedanych artykułów - grupowanie na poziomie kontrahenta
                $sales = HpReportRepository::getArticleSales($weekDays->w_start, $weekDays->w_end);
                // tablica z sumami sprzedaży dla każdego artikla
                $totalSales = (object)array();
                // tablica id sprzedanych artykułów - grupowanie na poziomie artykułu
                // jeżeli dla danego artykułu był zakup to jest on wyświetlany i id artykułu wypada z tablicy
                $salesArticleId = array();
                foreach ($sales as $sale) {
                    $aid = $sale->article_id;
                    array_push($salesArticleId, $aid);
                    if (isset($totalSales->$aid)) {
                        $q = (float)$totalSales->$aid;
                        $totalSales->$aid = $q + (float)$sale->quantity;
                    } else {
                        $totalSales->$aid = (float)$sale->quantity;
                    }
                }
                $salesArticleId = array_unique($salesArticleId); // wywalam duble
                $salesArticleId = array_values($salesArticleId); // reindeksuję tablicę

                // ------- zakup
                // lista zakupionych artykułów - grupowanie na poziomie kontrahenta
                $purchases = HpReportRepository::getArticlePurchases($weekDays->w_start, $weekDays->w_end);
                // tablica z sumami zakupów dla każdego artikla
                $totalPurchases = (object)array();
                // tablica id zakupionych artykułów - grupowanie na poziomie artykułu
                // jeżeli dla danego artykułu była sprzedaż to id artykułu wypada z tablicy
                $purchasesArticleId = array();
                foreach ($purchases as $purchase) {
                    //array_push($purchasesArticleId, $purchase->article_id);
                    $aid = $purchase->article_id;
                    array_push($purchasesArticleId, $aid);
                    if (isset($totalPurchases->$aid)) {
                        $q = (float)$totalPurchases->$aid;
                        $totalPurchases->$aid = $q + (float)$purchase->quantity;
                    } else {
                        $totalPurchases->$aid = (float)$purchase->quantity;
                    }
                }
                $purchasesArticleId = array_unique($purchasesArticleId); // wywalam duble
                $purchasesArticleId = array_values($purchasesArticleId); // reindeksuję tablicę

                // ------- zasoby
                //
                $inventoriesArticelId = array();
                foreach ($lastInventories as $inventory) {
                    array_push($inventoriesArticelId, $inventory->article_id);
                }

                /**
                 * składamy wszystko do kupy
                 */

                // --------------  sprzedaż + zakupy
                foreach ($sales as $sale) {
                    //
                    $id = $sale->article_id;

                    $purchaseQuantity = 0;
                    // sprawdzamy czy był zakup
                    foreach ($purchases as $purchase) {
                        if ($purchase->article_id == $id and in_array($id, $purchasesArticleId)) {
                            $purchaseQuantity = $totalPurchases->$id;
                            // usuwanie elementu z tablicy po wartości działa z php >= 7.4
                            $purchasesArticleId = array_values(array_filter($purchasesArticleId, fn ($m) => $m != $id));
                        }
                    }

                    $inventoryUnits = 0;
                    $lastIU = 0;
                    $totalSU = 0;
                    // ustawiamy zasoby Inventory Units
                    foreach ($lastInventories as $inventory) {
                        if ($inventory->article_id == $id and in_array($id, $inventoriesArticelId)) {
                            $lastIU = $inventory->quantity;
                            $totalSU = $totalSales->$id;
                            $inventoryUnits = $lastIU + $purchaseQuantity - $totalSU;
                            $temp = array(
                                'report_id' => $reportId,
                                'week_no' => $weekDays->w_no,
                                'year' => $weekDays->year,
                                'article_id' => $id,
                                'quantity' => (float)$inventoryUnits,
                            );
                            array_push($hpReportsInventories, $temp);
                            // usuwanie elementu z tablicy po wartości działa z php >= 7.4
                            $inventoriesArticelId = array_values(array_filter($inventoriesArticelId, fn ($m) => $m != $id));
                        }
                    }

//                    $purchaseQuantity = number_format($purchaseQuantity, 2, ',', ' ');
//                    $lastIU = number_format($lastIU, 2, ',', ' ');
//                    $inventoryUnits = number_format($inventoryUnits, 2, ',', ' ');
//                    $totalSU = number_format($totalSU, 2, ',', ' ');
//                    $saleQuantity = number_format((float)$sale->quantity, 2, ',', ' ');

                    array_push($data,
                        array(
                            'report_id' => $reportId,
                            'report_no' => $reportNo,
                            'week_no' => (int)$weekDays->w_no,
                            'year' => (int)$weekDays->year,
                            'previous_report_id' => (int)$lastReportId,

                            'Start period' => str_replace('-', '', $weekDays->w_start),
                            'End period' => str_replace('-', '', $weekDays->w_end),

                            'HP Product Number' => $sale->catalogue_number,
                            'Total Sellin Units' => (float)$purchaseQuantity,
                            //'last IU' => $lastIU,
                            'Inventory Units' => (float)$inventoryUnits,
                            //'total SU' => $totalSU,
                            'Sales Units' => (float)$sale->quantity,
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
                        )
                    );
                }

                // -------------- dostawy bez sprzedaży
                foreach ($purchases as $purchase) {
                    //
                    $id = $purchase->article_id;

                    if (in_array($id, $purchasesArticleId)) {
                        $purchaseQuantity = $totalPurchases->$id;

                        $inventoryUnits = 0;
                        $lastIU = 0;
                        $totalSU = 0;
                        // ustawiamy zasoby Inventory Units
                        foreach ($lastInventories as $inventory) {
                            if ($inventory->article_id == $id and in_array($id, $inventoriesArticelId)) {
                                $lastIU = $inventory->quantity;
                                $inventoryUnits = $lastIU + $purchaseQuantity - $totalSU;
                                $temp = array(
                                    'report_id' => $reportId,
                                    'week_no' => $weekDays->w_no,
                                    'year' => $weekDays->year,
                                    'article_id' => $id,
                                    'quantity' => (float)$inventoryUnits,
                                );
                                array_push($hpReportsInventories, $temp);
                                // usuwanie elementu z tablicy po wartości działa z php >= 7.4
                                $inventoriesArticelId = array_values(array_filter($inventoriesArticelId, fn ($m) => $m != $id));
                            }
                        }

//                        $purchaseQuantity = number_format($purchaseQuantity, 2, ',', ' ');
//                        $lastIU = number_format($lastIU, 2, ',', ' ');
//                        $inventoryUnits = number_format($inventoryUnits, 2, ',', ' ');
//                        $zero = number_format(0, 2, ',', ' ');

                        $zero = 0;
                        array_push($data,
                            array(
                                'report_id' => $reportId,
                                'report_no' => $reportNo,
                                'week_no' => (int)$weekDays->w_no,
                                'year' => (int)$weekDays->year,
                                'previous_report_id' => (int)$lastReportId,

                                'Start period' => str_replace('-', '', $weekDays->w_start),
                                'End period' => str_replace('-', '', $weekDays->w_end),

                                'HP Product Number' => $purchase->catalogue_number,
                                'Total Sellin Units' => (float)$purchaseQuantity,
                                //'last IU' => $lastIU,
                                'Inventory Units' => (float)$inventoryUnits,
                                //'total SU' => $zero,
                                'Sales Units' => $zero,
                                'Transaction Date' => str_replace('.', '', $purchase->store_operation_date),
                                'Channel Partner to Customer Invoice ID' => $purchase->document_no,

                                'Sold-to Customer ID' => $purchase->customer_code,
                                'Sold To Customer Name' => $purchase->customer_name,
                                'Sold To Company Tax ID' => $purchase->customer_tin,
                                'Sold To Address Line 1' => $purchase->customer_address,
                                'Sold To City' => $purchase->customer_city,
                                'Sold To Postal Code' => $purchase->customer_zipcode,
                                'Sold To Country Code' => $purchase->customer_countrycode,

                                'Ship-to Customer ID' => $purchase->customer_code,
                                'Ship To Customer Name' => $purchase->customer_name,
                                'Ship To Company Tax ID' => $purchase->customer_tin,
                                'Ship To Address Line 1' => $purchase->customer_address,
                                'Ship To City' => $purchase->customer_city,
                                'Ship To Postal Code' => $purchase->customer_zipcode,
                                'Ship To Country Code' => $purchase->customer_countrycode,

                                'Contract ID' => '',
                                'Contract start date' => '',
                                'Contract end date' => '',
                            )
                        );
                    }


                }

                // -------------- brak sprzedaży i dostaw
                foreach ($articles as $article) {
                    //
                    $id = $article->article_id;

                    if (in_array($id, $inventoriesArticelId)) {

                        foreach ($lastInventories as $inventory) {
                            if ($inventory->article_id == $id and in_array($id, $inventoriesArticelId)) {
                                $inventoryUnits = $inventory->quantity;
                                $temp = array(
                                    'report_id' => $reportId,
                                    'week_no' => $weekDays->w_no,
                                    'year' => $weekDays->year,
                                    'article_id' => $id,
                                    'quantity' => (float)$inventoryUnits,
                                );
                                array_push($hpReportsInventories, $temp);
                                // usuwanie elementu z tablicy po wartości działa z php >= 7.4
                                $inventoriesArticelId = array_values(array_filter($inventoriesArticelId, fn ($m) => $m != $id));
                            }
                        }

                        if ($inventoryUnits > 0) {
                            //$inventoryUnits = number_format($inventoryUnits, 2, ',', ' ');
                            //$zero = number_format(0, 2, ',', ' ');
                            $zero = 0;

                            array_push($data,
                                array(

                                    'report_id' => $reportId,
                                    'report_no' => $reportNo,
                                    'week_no' => (int)$weekDays->w_no,
                                    'year' => (int)$weekDays->year,
                                    'previous_report_id' => (int)$lastReportId,

                                    'Start period' => str_replace('-', '', $weekDays->w_start),
                                    'End period' => str_replace('-', '', $weekDays->w_end),

                                    'HP Product Number' => $article->catalogue_number,
                                    'Total Sellin Units' => $zero,
                                    //'last IU' => $inventoryUnits,
                                    'Inventory Units' => (float)$inventoryUnits,
                                    //'total SU' => $zero,
                                    'Sales Units' => $zero,
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
                                )
                            );
                        }

                    }
                }


            } else {
                // todo
                // obsługa przypadków gdy nie ma poprzednich raportów i startowych inventories

            }

            //--------------- zapis
            if (isset($data[0])) {

                foreach ($hpReportsInventories as $row) {
                    //HpReportsInventory::insert($row);
                }

                foreach ($data as $row) {
                    //HpReport::insert($row);
                }

                echo "<pre>";
                print_r(count($hpReportsInventories));
                //print_r($data[0]);
                //print_r($hpReportsInventories[0]);
                echo "</pre>";
            }

        }


        $data = array();
        // ------------------------------
        $headers = isset($data[0]) ? $data[0] : array();

        $articlesData = (object)[
            'years' => $this->years,
            'weekDays' => $weekDays,
            'weeks' => $weeks,
            'lastReports' => $lastReports,
            'headers' => $headers,
            'data' => $data,
        ];

        return view('hpreport.reports.create', ['ad' => $articlesData]);
    }

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


    public function customersList()
    {
        $customers = HpReportRepository::getCustomers();
        //dd($customers);
        return view('hpreport.customers.list', ['customers' => $customers]);
    }


    public function articlesList(HpReportRepository $hprRepo)
    {
        $articles = $hprRepo->getArticles();
        return view('hpreport.articles.list', ['articles' => $articles]);
    }


    public function articlesDelivery(HpReportRepository $hprRepo, $date = null)
    {
        if (is_null($date)) $date = date("Y-m-d"); // now
        //$docType = 31; // PZ
        $customerType = 2; // dostawca supplier
        //$articlesData = $this->getArticleInOut($date, $docType, $customerType);
        $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
        $weeks = $hprRepo->getWeeksOfYear($weekDays->year);
        $articles = HpReportRepository::getArticlePurchases($weekDays->w_start, $weekDays->w_end, $customerType);
        $articlesData = (object)[
            'years' => $this->years,
            'weekDays' => $weekDays,
            'weeks' => $weeks,
            'articles' => $articles,
        ];
        return view('hpreport.articles.delivery', ['ad' => $articlesData]);
    }


    public function articlesSale(HpReportRepository $hprRepo,$date = null)
    {
        if (is_null($date)) $date = date("Y-m-d"); // now
        $docType = 28; // WZ
        $customerType = 0; // nabywca purchaser
        $articlesData = $this->getArticleInOut($hprRepo,$date, $docType, $customerType);
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
