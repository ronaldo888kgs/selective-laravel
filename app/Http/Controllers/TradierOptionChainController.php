<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradierOptionChainController extends Controller
{
    //
    public function __invoke()
    {
        
        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.tradier.com/v1/markets/options/chains?symbol=VXX&expiration=2019-05-17&greeks=true');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$apikey;
        $headers[] = 'Accept: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        echo $http_code;
        echo $result;
        //return view('get-options.getoptions', ["apikey" => $apikey]);
    }
    public function index()
    {
        __invoke();
    }

    public function getOptionChain(Request $request)
    {
        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");

        $symbol = isset($request['symbol']) ? $request['request'] : '';
        $expire = isset($request['expire']) ? $request['expire'] : '';
        $url = $baseurl.'/v1/markets/options/chains?greeks=true';
        if($symbol != '')
            $url = $url.'&symbol='.$symbol;
        if($expire != '')
            $url = $url.'&expiration='.$expire;
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, $baseurl.'/v1/markets/options/chains?symbol=VXX&expiration=2019-05-17&greeks=true');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$apikey;
        $headers[] = 'Accept: application/json';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            return response()->json([
                "status" => false,
                "message" => curl_error($ch)
            ]);
        }
        curl_close ($ch);

        return response()->json([
            "status" => true,
            "data" => $result
        ]);
    }
}
