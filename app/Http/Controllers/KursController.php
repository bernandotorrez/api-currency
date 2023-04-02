<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Count;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KursController extends Controller
{
    protected $tdCurrency = [
        'AUD' => 1,
        'BND' => 2,
        'CAD' => 3,
        'CHF' => 4,
        'CNH' => 5,
        'CNY' => 6,
        'DKK' => 7,
        'EUR' => 8,
        'GBP' => 9,
        'HKD' => 10,
        'JPY' => 11,
        'KRW' => 12,
        'KWD' => 13,
        'LAK' => 14,
        'MYR' => 15,
        'NOK' => 16,
        'NZD' => 17,
        'PGK' => 18,
        'PHP' => 19,
        'SAR' => 20,
        'SEK' => 21,
        'SGD' => 22,
        'THB' => 23,
        'USD' => 24,
        'VND' => 25,
        'IDR' => 1
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Currency $currency, Count $count)
    {
        $this->model = $currency;
        $this->count = $count;
    }

    public function getAll(Request $request)
    {
        $date = date('Y_m_d');

        $idCurrency = $request->get('id_curr');
        $ipAddress = $request->ip();

        $insertCallAPI = $this->count->create([
            'ip_address' => $ipAddress,
            'id_curr' => 0
        ]);

        $data = Cache::remember('all_currency_'.$date, 3600*12, function() {
            return $this->curlAllCurrency();
        });

        if($data) {
            $response = array(
                'success' => true,
                'code' => 200,
                'created_by' => 'Bernando Torrez',
                'message' => 'Successfully Get All Currencies Data',
                'date_currency' => date('Y-m-d'),
                'data' => $data
            );

            return response($response, 200);
        } else {
            $response = array(
                'success' => false,
                'code' => 500,
                'created_by' => 'Bernando Torrez',
                'message' => 'Oops something Error Happens',
                'date_currency' => date('Y-m-d'),
                'data' => []
            );

            return response($response, 200);
        }
    }

    private function curlAllCurrency()
    {
        $url = "https://hargadollar.com/bank/bank-bi";
        $userAgent = "Googlebot/2.1 (http://www.googlebot.com/bot.html)";
        $internalErrors = libxml_use_internal_errors(true);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        // jika website yd di curl sedang offline
        if(!$content = curl_exec($ch)){
            // $arrai = array(
            //     "bank" => 'BI',
            //     "status" => "offline",
            //     "kurs" => array()
            // );
            // return $arrai;

            $response = array(
                'success' => false,
                'code' => 200,
                'created_by' => 'Bernando Torrez',
                'message' => 'Web Kurs is Offline',
                'data' => null
            );

            return response($response, 200);
        }

        // ternyata website yd di curl sedang online
        else{
            curl_close($ch);
            $dom = new DOMDocument;
            $dom->loadHTML($content);
            $rows = array();
            foreach ($dom->getElementsByTagName('tr') as $tr) {
                $cells = array();
                foreach ($tr->getElementsByTagName('td') as $r) {
                    $cells[] = $r->nodeValue;
                }
                $rows[] = $cells;
            }

            $arrayCurrency = array();

            array_push($arrayCurrency, array(
                "mata_uang" => 'IDR',
                "jual" => 1,
                "beli" => 1,
                "tengah" => 1
            ));

            try {

                foreach($this->tdCurrency as $currency) {
                    $tdCurrency = $currency;

                    $mataUang = trim($rows[$tdCurrency][0]);
                    $jual = preg_replace('/\s+/', '', $rows[$tdCurrency][1]);
                    $beli = preg_replace('/\s+/', '', $rows[$tdCurrency][2]);
                    $tengah = preg_replace('/\s+/', '', $rows[$tdCurrency][3]);

                    $search  = array(",");
                    $replace = array("");
                    $jual = str_replace($search, $replace, $jual);
                    $beli = str_replace($search, $replace, $beli);
                    $tengah = str_replace($search, $replace, $tengah);

                    $explodeJual = explode('.', $jual);
                    $jual = $explodeJual[0];

                    $explodeBeli = explode('.', $beli);
                    $beli = $explodeBeli[0];

                    $explodeTengah = explode('.', $tengah);
                    $tengah = $explodeTengah[0];

                    $jual = (int) $jual;
                    $beli = (int) $beli;
                    $tengah = (int) $tengah;

                    if($mataUang == 'JPY') {
                        $jual = $jual/100;
                        $beli = $beli/100;
                        $tengah = $tengah/100;
                    } elseif($mataUang == 'IDR') {
                        $jual = 1;
                        $beli = 1;
                        $tengah = 1;
                    }

                    array_push($arrayCurrency, array(
                        "mata_uang" => $mataUang,
                        "jual" => round($jual),
                        "beli" => round($beli),
                        "tengah" => round($tengah)
                    ));
                }

                return $arrayCurrency;

            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function getById(Request $request)
    {
        $idCurrency = $request->get('id_curr');
        $ipAddress = $request->ip();

        $insertCallAPI = $this->count->create([
            'ip_address' => $ipAddress,
            'id_curr' => $idCurrency
        ]);

        $dataCurrency = Cache::remember('id_curr_'.$idCurrency, 3600, function() use ($idCurrency) {
            return $this->model->where('id_curr', $idCurrency)->first();
        });

        try {
            $curlCurrency = Cache::remember('currency_'.$dataCurrency->currency, 3600, function() use ($dataCurrency) {
                return $this->curlCurrency($dataCurrency->currency);
            });
        } catch (Exception $e) {
            // Ga dapet currency

            $lastIdCurr = $this->model->orderBy('id_curr', 'desc')->first();
            $firstIdCurr = $this->model->orderBy('id_curr', 'asc')->first();

            $response = array(
                'success' => false,
                'code' => 200,
                'created_by' => 'Bernando Torrez',
                'message' => 'Oops, ID Currency yang anda cari tidak ditemukan, Max ID Currency yang dapat kamu cari dari '.$firstIdCurr->id_curr.' sampai '.$lastIdCurr->id_curr,
                'data' => null
            );

            return response($response, 200);
        }


        $response = array(
            'success' => true,
            'code' => 200,
            'created_by' => 'Bernando Torrez',
            'message' => 'Successfully Get Currency Data',
            'data' => array(
                'id_curr' => $idCurrency,
                'currency' => trim($dataCurrency->currency),
                'beli' => $curlCurrency['kurs']['beli'],
                'jual' => $curlCurrency['kurs']['jual'],
                'tengah' => $curlCurrency['kurs']['tengah'],
            )
        );

        return response($response, 200);
    }

    private function curlCurrency($currency)
    {
        $url = "https://hargadollar.com/bank/bank-bi";
        $userAgent = "Googlebot/2.1 (http://www.googlebot.com/bot.html)";
        $internalErrors = libxml_use_internal_errors(true);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        // jika website yd di curl sedang offline
        if(!$content = curl_exec($ch)){
            // $arrai = array(
            //     "bank" => 'BI',
            //     "status" => "offline",
            //     "kurs" => array()
            // );
            // return $arrai;

            $response = array(
                'success' => false,
                'code' => 200,
                'created_by' => 'Bernando Torrez',
                'message' => 'Web Kurs is Offline',
                'data' => null
            );

            return response($response, 200);
        }

        // ternyata website yd di curl sedang online
        else{
            curl_close($ch);
            $dom = new DOMDocument;
            $dom->loadHTML($content);
            $rows = array();
            foreach ($dom->getElementsByTagName('tr') as $tr) {
                $cells = array();
                foreach ($tr->getElementsByTagName('td') as $r) {
                    $cells[] = $r->nodeValue;
                }
                $rows[] = $cells;
            }

            try {
                $tdCurrency = $this->tdCurrency[$currency];

                $jual = preg_replace('/\s+/', '', $rows[$tdCurrency][1]);
                $beli = preg_replace('/\s+/', '', $rows[$tdCurrency][2]);
                $tengah = preg_replace('/\s+/', '', $rows[$tdCurrency][3]);

                $search  = array(",");
                $replace = array("");
                $jual = str_replace($search, $replace, $jual);
                $beli = str_replace($search, $replace, $beli);
                $tengah = str_replace($search, $replace, $tengah);

                $explodeJual = explode('.', $jual);
                $jual = $explodeJual[0];

                $explodeBeli = explode('.', $beli);
                $beli = $explodeBeli[0];

                $explodeTengah = explode('.', $tengah);
                $tengah = $explodeTengah[0];

                $jual = (int) $jual;
                $beli = (int) $beli;
                $tengah = (int) $tengah;

                if($currency == 'JPY') {
                    $jual = $jual/100;
                    $beli = $beli/100;
                    $tengah = $tengah/100;
                } elseif($currency == 'IDR') {
                    $jual = 1;
                    $beli = 1;
                    $tengah = 1;
                }

                $arrai = array(
                    "bank" => 'BI',
                    "status" => "online",
                    "kurs" => array(
                        "mata_uang" => $currency,
                        "jual" => round($jual),
                        "beli" => round($beli),
                        "tengah" => round($tengah)
                    )
                );

                return $arrai;
            } catch (Exception $e) {
                $arrai = array(
                    "bank" => 'BI',
                    "status" => "online",
                    "kurs" => array(
                        "mata_uang" => "IDR",
                        "jual" => 1,
                        "beli" => 1,
                        "tengah" => 1
                    )
                );

                return $arrai;
            }
        }
    }

    public function countCall()
    {
        $data = $this->count->select('id')->count();

        $response = array(
            'success' => true,
            'code' => 200,
            'created_by' => 'Bernando Torrez',
            'message' => 'Successfully Get Data',
            'data' => array(
               'total_count' => $data
            )
        );

        return response($response, 200);
    }
}
