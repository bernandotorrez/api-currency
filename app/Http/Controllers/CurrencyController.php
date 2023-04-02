<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CurrencyController extends Controller
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
    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    public function getById(Request $request)
    {
        $idCurrency = $request->get('id_curr');

        $dataCurrency = Cache::remember('id_curr_'.$idCurrency, 3600, function() use ($idCurrency) {
            return $this->model->where('id_curr', $idCurrency)->where('status', '1')->first();
        });

        $response = array(
            'success' => true,
            'code' => 200,
            'message' => 'Successfully Get Currency Data',
            'data' => array(
                'id_curr' => $idCurrency,
                'currency' => $dataCurrency->currency,
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
            $arrai = array(
                "bank" => 'BI',
                "status" => "offline",
                "kurs" => array()
            );
            return $arrai;
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

}
