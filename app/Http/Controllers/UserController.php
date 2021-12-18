<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use App\Models\FieldData;
use App\Models\FieldCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FieldsImport;
use App\Exports\FieldsExport;
use Illuminate\Support\Facades\Auth;
use App\Models\Visitorssignal;
class UserController extends Controller
{
    public function getAveragePercent($cat_id)
    {
        $result = DB::select('SELECT SUM(`net_difference`) AS average FROM `field_data` WHERE `category` = ? GROUP BY `category`', [$cat_id]);
        return isset($result[0]) ? number_format((float)$result[0]->average, 2, '.', '') : '0';
    }
    public function __invoke()
    {
        $categories = FieldCategory::all();
        //$fields =FieldData::all();
        //$fields = DB::select('SELECT * FROM `field_data` WHERE category = '.$categories[0]->id.' AND activated = 1 ORDER BY created_at desc');
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($categories){
            $query->where('category', '=', $categories[0]->id)->where('activated', 1);
        })->paginate(150);

        foreach ($fields as $field)
        {
            $field["live_option_price"] = "";
            $field["stock_price"] = "";
            $newExpireDate = date("dmy", strtotime($field->expiration_date));
            $callorput = "C";
            if($field->call_put_strategy === "put")
            $callorput = "P";
            $field["tracker"] = $field->symbol." ".$field->symbol."_".$newExpireDate.$callorput.$field->strike."@".$field->strike_price;
        }


        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");
        $url1 = $baseurl.'/v1/markets/options/chains?greeks=true';
        $url2 = $baseurl.'/v1/markets/quotes?greeks=true';
        $count_visitor = Visitorssignal::all()->count();
        $ameri_apikey=env("TDAMERITRADE_APIKEY");
        $ameri_base_url = env("TDAMERITRADE_BASE_URL");
        $ameri_access_token = env("TDAMERITRADE_ACCESS_TOKEN");
        return view('user.userpage', [
            "categories" => $categories, 
            "fields" => $fields, 
            "current_cat_id" => $categories[0]->id, 
            "avg_percent" => UserController::getAveragePercent($categories[0]->id),
            "live_access_token" => $apikey,
            "live_option_price_url" => $url1,
            "live_stock_price_url" => $url2,
            "visitor_count" => $count_visitor,
            "ameri_api_key" => $ameri_apikey,
            "ameri_base_url" => $ameri_base_url,
            "ameri_access_token" => $ameri_access_token,
        ]);
    }   

    public function show($cat_id)
    {
        $categories = FieldCategory::all();
        if($cat_id === "")
            $cat_id = $categories[0]->id;
        //$fields = DB::select('SELECT * FROM `field_data` WHERE category = '.$cat_id.' AND activated = 1 ORDER BY created_at desc');
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($cat_id){
            $query->where('category', '=', $cat_id)->where('activated', 1);
        })->paginate(150);

        foreach ($fields as $field)
        {
            $field["live_option_price"] = "";
            $field["stock_price"] = "";
            $newExpireDate = date("dmy", strtotime($field->expiration_date));
            $callorput = "C";
            if($field->call_put_strategy === "put")
            $callorput = "P";
            $field["tracker"] = $field->symbol." ".$field->symbol."_".$newExpireDate.$callorput.$field->strike."@".$field->strike_price;
        }
        
        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");
        $url1 = $baseurl.'/v1/markets/options/chains?greeks=true';
        $url2 = $baseurl.'/v1/markets/quotes?greeks=true';
        $count_visitor = Visitorssignal::all()->count();
        $ameri_apikey=env("TDAMERITRADE_APIKEY");
        $ameri_base_url = env("TDAMERITRADE_BASE_URL");
        $ameri_access_token = env("TDAMERITRADE_ACCESS_TOKEN");
        return view('user.userpage', [
            "categories" => $categories, 
            "fields" => $fields, 
            "current_cat_id" => $cat_id , 
            "avg_percent" => UserController::getAveragePercent($cat_id),
            "live_access_token" => $apikey,
            "live_option_price_url" => $url1,
            "live_stock_price_url" => $url2,
            "visitor_count" => $count_visitor,
            "ameri_api_key" => $ameri_apikey,
            "ameri_base_url" => $ameri_base_url,
            "ameri_access_token" => $ameri_access_token,
        ]);
    }
    
    public function searchField($id, $data)
    {
        if(!isset($id)){
            return __invoke();
        }

        $categories = FieldCategory::all();
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($id, $data){
            $data2 = json_decode($data) ;
            $query->where('category', '=', $id)->where('activated', 1);
            if(isset($data2->datetype) && $data2->datetype != 'all')
            {
                if(isset($data2->startdate))
                {
                    $query->where($data2->datetype, '>=', $data2->startdate);
                }
                if(isset($data2->enddate))
                {
                    $query->where($data2->datetype, '<=', $data2->enddate);
                }
            }
            if(isset($data2->keyword) && $data2->keyword != 'all')
            {
                if(isset($data2->value))
                {
                    $query->where($data2->keyword, '=', $data2->value);
                }
            }
        })->paginate(150);

        $i = 0;
        foreach ($fields as $field)
        {
            $field["live_option_price"] = "";
            $field["stock_price"] = "";
            $fields[$i] = $field;
            $i++;
        }

        
        return view('user.pagination_table', ["fields" => $fields])->render();
    }

    
    public function getOptionQuote($symbol)
    {
        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");
        $url = $baseurl.'/v1/markets/quotes?greeks=true';
        if($symbol != '')
            $url = $url.'&symbols='.$symbol;
        $ch = curl_init();
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
            return null;
        }
        curl_close ($ch);

        return $result;
    }
    
    public function getOptionChain($symbol, $expire)
    {
        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");
        $url = $baseurl.'/v1/markets/options/chains?greeks=true';
        if($symbol != '')
            $url = $url.'&symbol='.$symbol;
        if($expire != '')
            $url = $url.'&expiration='.$expire;
        $ch = curl_init();
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
            return null;
        }
        curl_close ($ch);

        return $result;
    }


}
