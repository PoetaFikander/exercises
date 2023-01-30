<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\HpReport;
use App\Repositories\HpReportRepository;
use App\Traits\GlobalTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


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

    public function reportCreate(Request $request)
    {
        //var_dump($request->all());


        $data = array();

        if ($request->method() == 'GET') {
            //
            $date = date("Y-m-d"); // now
            $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
            $weeks = HpReportRepository::getWeeksOfYear($weekDays->year);
        } else {
            // ------- daty
            $date = $request->input('for_week');
            $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
            $weeks = HpReportRepository::getWeeksOfYear($weekDays->year);

            // ------- sprzedaż
            // lista sprzedanych artykułów - grupowanie na poziomie kontrahenta
            $sales = HpReportRepository::getArticleSales($weekDays->w_start, $weekDays->w_end);
            // tablica id sprzedanych artykułów - grupowanie na poziomie artykułu
            // jeżeli dla danego artykułu był zakup to jest on wyświetlany i id artykułu wypada z tablicy
            $salesArticleId = array();
            foreach ($sales as $sale) {
                array_push($salesArticleId, $sale->article_id);
            }
            $salesArticleId = array_unique($salesArticleId); // wywalam duble
            $salesArticleId = array_values($salesArticleId); // reindeksuję tablicę

            // ------- zakup
            // lista zakupionych artykułów - grupowanie na poziomie kontrahenta
            $purchases = HpReportRepository::getArticlePurchases($weekDays->w_start, $weekDays->w_end);
            //var_dump($purchases);
            // tablica id zakupionych artykułów - grupowanie na poziomie artykułu
            // jeżeli dla danego artykułu była sprzedaż to id artykułu wypada z tablicy
            $purchasesArticleId = array();
            foreach ($purchases as $purchase) {
                array_push($purchasesArticleId, $purchase->article_id);
            }
            $purchasesArticleId = array_unique($purchasesArticleId); // wywalam duble
            $purchasesArticleId = array_values($purchasesArticleId); // reindeksuję tablicę


            /**
             * składamy wszystko do kupy
             */
            // --------------  sprzedaż + zakupy
            foreach ($sales as $sale) {
                //
                $id = $sale->article_id;
                // sprawdzamy czy był zakup
                $purchaseQuantity = 0;
                foreach ($purchases as $purchase) {
                    if ($purchase->article_id == $id and in_array($id, $salesArticleId)) {
                        $purchaseQuantity = $purchase->quantity;
                        // usuwanie elementu z tablicy po wartości działa z php >= 7.4
                        $salesArticleId = array_values(array_filter($salesArticleId, fn($m) => $m != $id));
                        $purchasesArticleId = array_values(array_filter($purchasesArticleId, fn($m) => $m != $id));
                    }
                }

                array_push($data,
                    (object)array(

                        //'report_id' => $report_id,

                        'Start period' => $weekDays->w_start,
                        'End period' => $weekDays->w_end,

                        'HP Product Number' => $sale->catalogue_number,
                        'Total Sellin Units' => $purchaseQuantity,
                        'Inventory Units' => 0,
                        'Sales Units' => $sale->quantity,
                        'Transaction Date' => $sale->store_operation_date,
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
                        'Contract start date' => $sale->contract_start_date,
                        'Contract end date' => $sale->contract_end_date,
                    )
                );
            }

            //dd($data);
            //var_dump($purchasesArticleId);

            // -------------- zakupy bez sprzedaży
            foreach ($purchases as $purchase) {
                //
                $id = $purchase->article_id;
                if(in_array($id, $purchasesArticleId)) {
                    array_push($data,
                        (object)array(

                            //'report_id' => $report_id,

                            'Start period' => $weekDays->w_start,
                            'End period' => $weekDays->w_end,

                            'HP Product Number' => $purchase->catalogue_number,
                            'Total Sellin Units' => $purchase->quantity,
                            'Inventory Units' => 0,
                            'Sales Units' => 0,
                            'Transaction Date' => $purchase->store_operation_date,
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

        }

        // ------------------------------
        $headers = isset($data[0]) ? $data[0] : array();

        $articlesData = (object)[
            'years' => $this->years,
            'weekDays' => $weekDays,
            'weeks' => $weeks,
            'headers' => $headers,
            'data' => $data,
        ];

        return view('hpreport.reports.create', ['ad' => $articlesData]);
    }

    /*
    public function report($date = null)
    {
        $date = '2023-01-23';
        $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
        $weeks = HpReportRepository::getWeeksOfYear($weekDays->year);

        // lista sprzedanych artykułów - podsumowanie - grupowanie na poziomie kontrahenta
        $sales = HpReportRepository::getArticleInOutReport($weekDays->w_start, $weekDays->w_end, 28, 0);
        //dd($sales);

        //$report_row = new HpReport();
        //dd($report_row);
        $report_id = 1;

        $data = array();

        foreach ($sales as $sale) {
            array_push($data,
                (object)array(

                    //'report_id' => $report_id,

                    'Start period' => $weekDays->w_start,
                    'End period' => $weekDays->w_end,

                    'HP Product Number' => $sale->catalogue_number,
                    'Total Sellin Units' => 0,
                    'Inventory Units' => 0,
                    'Sales Units' => $sale->quantity,
                    'Transaction Date' => $sale->store_operation_date,
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
                    'Contract start date' => $sale->contract_start_date,
                    'Contract end date' => $sale->contract_end_date,
                )
            );
        }

        //dd($data);
        $headers = isset($data[0]) ? $data[0] : array();

        $sale = HpReportRepository::getArticleInOut($weekDays->w_start, $weekDays->w_end, 28, 0);
        $articlesData = (object)[
            'years' => $this->years,
            'weekDays' => $weekDays,
            'weeks' => $weeks,
            'sale' => $sale,
        ];
        return view('hpreport.report', ['ad' => $articlesData, 'headers' => $headers, 'data' => $data]);
    }
    */


    public function getWeeks(Request $request)
    {
        if (Auth::check() && $request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $weeks = HpReportRepository::getWeeksOfYear($json->year);
            $json->weeks = $weeks;
            return Response::json($json);
        } else {
            //todo
            //zrobić ogólną stronę błędów
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


    public function articlesDelivery($date = null)
    {
        if (is_null($date)) $date = date("Y-m-d"); // now
        $docType = 31; // PZ
        $customerType = 2; // dostawca supplier
        $articlesData = $this->getArticleInOut($date, $docType, $customerType);
        return view('hpreport.articles.delivery', ['ad' => $articlesData]);
    }


    public function articlesSale($date = null)
    {
        if (is_null($date)) $date = date("Y-m-d"); // now
        $docType = 28; // WZ
        $customerType = 0; // nabywca purchaser
        $articlesData = $this->getArticleInOut($date, $docType, $customerType);
        return view('hpreport.articles.sale', ['ad' => $articlesData]);
    }


    public function getArticleInOut($date, $docType, $customerType)
    {
        //var_dump($date);
        $weekDays = HpReportRepository::getFirstLastDayOfWeek($date);
        $weeks = HpReportRepository::getWeeksOfYear($weekDays->year);
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
