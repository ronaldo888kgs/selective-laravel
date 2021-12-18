<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use App\Models\FieldData;
use App\Models\FieldCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FieldsImport;
use App\Exports\FieldsExport;
use Illuminate\Support\Facades\Auth;
use App\Models\Visitorssignal;
use App\Events\NewDataArrivedEvent;
class AdminController extends Controller
{
    public function getAveragePercent($cat_id)
    {
        $result = DB::select('SELECT SUM(`net_difference`) AS average FROM `field_data` WHERE `category` = ? GROUP BY `category`', [$cat_id]);
        return isset($result[0]) ? number_format((float)$result[0]->average, 2, '.', '') : '0';
    }
    public function __invoke()
    {
        $categories = FieldCategory::all();
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($categories){
            $query->where('category', '=', $categories[0]->id);
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

            //SYMBOL SYMBOL_MMDDYY(Expirationdate)(CallorPut)Strike@Strike Price
            //AMZN AMZN_121721C4000@26
        }
        $apikey = env("TRADIER_ACCESS_TOKEN", "GVd9TkO0pLMiWoA7R1QLlrFvH3CO");
        $baseurl = env("TRADIER_BASE_URL", "https://sandbox.tradier.com");
        $url1 = $baseurl.'/v1/markets/options/chains?greeks=true';
        $url2 = $baseurl.'/v1/markets/quotes?greeks=true';
        $ameri_apikey=env("TDAMERITRADE_APIKEY");
        $ameri_base_url = env("TDAMERITRADE_BASE_URL");
        $ameri_access_token = env("TDAMERITRADE_ACCESS_TOKEN");
        $count_visitor = Visitorssignal::all()->count();
        return view('admin.adminpage', [
            "categories" => $categories, 
            "fields" => $fields, 
            "current_cat_id" => $categories[0]->id, 
            "avg_percent" => AdminController::getAveragePercent($categories[0]->id),
            "live_access_token" => $apikey,
            "live_option_price_url" => $url1,
            "live_stock_price_url" => $url2,
            "visitor_count" => $count_visitor,
            "ameri_api_key" => $ameri_apikey,
            "ameri_base_url" => $ameri_base_url,
            "ameri_access_token" => $ameri_access_token,
        ]);
    }
    public function index()
    {
        $categories = FieldCategory::all();
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($categories){
            $query->where('category', '=', $categories[0]->id);
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
        return view('admin.adminpage', [
            "categories" => $categories, 
            "fields" => $fields, 
            "current_cat_id" => $categories[0]->id, 
            "avg_percent" => AdminController::getAveragePercent($categories[0]->id),
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
        $fields = FieldData::orderByRaw('created_at desc')
        ->where(function ($query) use ($cat_id){
            $query->where('category', '=', $cat_id);
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
        return view('admin.adminpage', [
            "categories" => $categories, 
            "fields" => $fields, 
            "current_cat_id" => $cat_id, 
            "avg_percent" => AdminController::getAveragePercent($cat_id),
            "live_access_token" => $apikey,
            "live_option_price_url" => $url1,
            "live_stock_price_url" => $url2,
            "visitor_count" => $count_visitor,
            "ameri_api_key" => $ameri_apikey,
            "ameri_base_url" => $ameri_base_url,
            "ameri_access_token" => $ameri_access_token,
         ]);
    }

    public function refreshWithPrice($id, $data)
    {
        
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!isset($id)){
            return __invoke();
        }
        $categories = FieldCategory::all();
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($id, $data){
            $data2 = json_decode($data) ;
            $query->where('category', '=', $id);
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
            if($field->status != 0) //   if status == open
            {
                //get live option price and stock price
                $option_data = AdminController::getOptionChain($field->symbol, $field->expiration_date);
                $option_data_obj = json_decode($option_data);
                if($option_data_obj != null)
                {
                    if(isset($option_data_obj) && 
                        isset($option_data_obj->options) && 
                        isset($option_data_obj->options->option))
                    {
                        foreach($option_data_obj->options->option as $adata)
                        {
                            if($field->call_put_strategy == $adata->option_type && $field->strike == $adata->strike)
                            {
                                $underlying = $adata->underlying;
                                $quote = AdminController::getOptionQuote($underlying);
                                $quote_obj = json_decode($quote);
                                
                                $field["live_option_price"] = $adata->close == null ? "" : $adata->close;
                                if(isset($quote_obj) && 
                                    isset($quote_obj->quotes) && 
                                    isset($quote_obj->quotes->quote)){
                                        $field["stock_price"] = $quote_obj->quotes->quote->last == null ? "" : $quote_obj->quotes->quote->last;    
                                    }else{
                                        $field["stock_price"] = "";
                                    }
                                
                                $fields[$i] = $field;
                            }
                        }
                    }
                    
                }
                
            }
            $i++;
        }

        //return view('admin.adminpage', ["categories" => $categories, "fields" => $fields, "current_cat_id" => $id, "filters" => json_decode($data) , "avg_percent" => AdminController::getAveragePercent($id) ]);
        return view('admin.pagination_table', ["fields" => $fields])->render();
    }

    public function searchField($id, $data)
    {
        
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!isset($id)){
            return __invoke();
        }
        $categories = FieldCategory::all();
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($id, $data){
            $data2 = json_decode($data) ;
            $query->where('category', '=', $id);
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

        //return view('admin.adminpage', ["categories" => $categories, "fields" => $fields, "current_cat_id" => $id, "filters" => json_decode($data) , "avg_percent" => AdminController::getAveragePercent($id) ]);
        return view('admin.pagination_table', ["fields" => $fields])->render();
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

    public function deleteCat(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
            return response()->json([
                "status" => false,
                "msg" => "You are not allowed"
            ]);

            echo($request->_token);
            return response()->json([
                "status" => false,
            ]);
        DB::delete('DELETE FROM `field_categories` WHERE id =  ?', [intval($request['catID'])]);
        DB::delete('DELETE FROM `field_data` WHERE category =  ?', [intval($request['catID'])]);
        return response()->json([
            "status" => true,
        ]);
    }

    public function deleteFeild(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
        return response()->json([
            "status" => false,
            "msg" => "You are not allowed"
        ]);
        DB::delete('DELETE FROM `field_data` WHERE id =  ?', [intval($request['dbID'])]);
        return response()->json([
            "status" => true,
            'val' => $request['dbID']
        ]);
    }

    public function editFeild(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
            return response()->json([
                "status" => false,
                "msg" => "You are not allowed"
            ]);
        
        $oldData = FieldData::where('id', '=', $request['dbID'])->first();
        if($oldData != null)
        {
            if($oldData->status == 1 && $request['status_select'] == 0)
            {
                event(new NewDataArrivedEvent('new data'));
            }
        }
            
        DB::update('UPDATE `field_data` 
                    SET `updated_at`= CURRENT_TIMESTAMP, 
                        `category`= ?,
                        `posted_date` = ?,  
                        `buy_date` = ?,
                        `symbol` = ?,
                        `qty` = ?,
                        `expiration_date` = ?,
                        `call_put_strategy` = ?,
                        `strike` = ?,
                        `strike_price` = ?,
                        `in_price` = ?,
                        `out_price` = ?,
                        `net_difference` = ?,
                        `percentage` = ?,
                        `status` = ?,
                        `sell_date` = ?,
                        `high_price` = ?  
                    WHERE `id`=?', [
                        $request['cat_id'], 
                        $request['posted_date'],
                        $request['buy_date'],
                        $request['symbol'],
                        $request['qty'],
                        $request['expiration_date'],
                        $request['call_put_strategy'],
                        $request['strike'],
                        $request['strike_price'],
                        $request['inprice'],
                        $request['outprice'],
                        $request['netdifference'] == "NaN" ? null : $request['netdifference'],
                        $request['percentage_net_profit'] == "NaN" ? null : $request['percentage_net_profit'],
                        $request['status_select'],
                        $request['sell_date'],
                        $request['highprice'],
                        $request['dbID']
                    ]);
        return response()->json([
            "status" => true,
            "data" => $request['postedData']
        ]);
    }
    public function addCat(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
        return response()->json([
            "status" => false,
            "msg" => "You are not allowed"
        ]);
        $fields = DB::select('SELECT * FROM `field_categories` WHERE `name` = ?', [strtoupper($request["name"])]);
        if($fields != null)
        {
            return response()->json([
                "status" => true,
                "msg" => "Already existing category"
            ]);
        }
        DB::insert('INSERT INTO `field_categories`(`name`) VALUES (?)', [strtoupper($request["name"])]);
        return response()->json([
            "status" => true
        ]);
        
    }

    public function show_adminpage($categories, $fields,  $select_category)
    {
        return view('admin.adminpage', ["categories" => $categories, "fields" => $result, "current_cat_id" => $request['select_category']]);
    }
   
    public function addField(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
            return response()->json([
                "status" => false,
                "msg" => "You are not allowed"
            ]);
        DB::insert('insert into field_data (created_at, 
            updated_at, 
            posted_date, 
            buy_date, 
            symbol, 
            qty, 
            expiration_date, 
            call_put_strategy, 
            strike,  
            strike_price, 
            in_price, 
            out_price, 
            net_difference, 
            percentage, 
            status, 
            category,
            activated,
            sell_date,
            high_price) 
            values (CURRENT_TIMESTAMP  , CURRENT_TIMESTAMP, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)', 
            [$request['postedData'], 
            $request['buy_date'], 
            $request['symbol'],
            $request['qty'], 
            $request['expiration_date'], 
            $request['call_put_strategy'], 
            $request['strike'], 
            $request['strike_price'], 
            $request['inprice'], 
            $request['outprice'], 
            
            $request['netdifference'] == "NaN" ? null : $request['netdifference'], 
            $request['percentage_net_profit'] == "NaN" ? null : $request['percentage_net_profit'], 
            $request['status'], 
            intval($request['category']),
            $request['activated'],
            $request['sell_date'],
            $request['highprice']]);

        return response()->json([
            "status" => true,
            "data" => $request['postedData']
        ]);
    }

    public function fileImportExport()
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
        return response()->json([
            "status" => false,
            "msg" => "You are not allowed"
        ]);
        return view('file-import');
    }

    public function fileImport(Request $request) 
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
        return response()->json([
            "status" => false,
            "msg" => "You are not allowed"
        ]);
        $Date = "1900-01-01";
        if(!$request->file('file'))
            return back();
        //Excel::import(new FieldsImport, $request->file('file')->store('temp'));
        $category_id = $request['form_cat_id'];
        $rows = Excel::toArray(new FieldsImport, $request->file('file')->store('temp')); 
        if(count($rows) == 0)
        {
            //error
            return back();
        }
        $sheet = $rows[0];
        $i = -1;
        foreach($sheet as $row)
        {
            $i++;
            if($i == 0)
                continue;
            if(count($row) != 17)
                break;
                DB::insert('insert into field_data (created_at, 
                updated_at, 
                posted_date, 
                buy_date, 
                symbol, 
                qty, 
                expiration_date, 
                sell_date,
                call_put_strategy, 
                strike,  
                strike_price, 
                in_price, 
                out_price, 
                net_difference, 
                high_price,
                percentage, 
                status, 
                category,
                activated) 
                values (CURRENT_TIMESTAMP  , CURRENT_TIMESTAMP, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                [
                    date('Y-m-d', strtotime($Date. ' + '.(intval($row[0]) - 2).' days')), 
                    date('Y-m-d', strtotime($Date. ' + '.(intval($row[1]) - 2).' days')), 
                    $row[2],
                    $row[3], 
                    date('Y-m-d', strtotime($Date. ' + '.(intval($row[4]) - 2).' days')), 
                    date('Y-m-d', strtotime($Date. ' + '.(intval($row[5]) - 2).' days')), 
                    $row[6], 
                    $row[7], 
                    $row[8], 
                    $row[9], 
                    $row[10], 
                    $row[11], 
                    $row[12], 
                    $row[13], 
                    $row[14], 
                    intval($category_id),
                    $row[16]
                ]);
        }
        //return view('welcome', ["rows" => $rows]);
        return back();
        
    }

    public function fileExportAsPdf($id, $filter)
    {
        $category_id = $id;
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($category_id, $filter){
            $data2 = json_decode($filter);
            $query->where('category', '=', $category_id);
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
            if($data2->only_activated == '1')
            {
                $query->where('activated', '=', 1);
            }
        })->get();
        foreach ($fields as $field)
        {
            $newExpireDate = date("dmy", strtotime($field->expiration_date));
            $callorput = "C";
            if($field->call_put_strategy === "put")
            $callorput = "P";
            $field["tracker"] = $field->symbol." ".$field->symbol."_".$newExpireDate.$callorput.$field->strike."@".$field->strike_price;
        }
        $cat_name = DB::select('SELECT name FROM `field_categories` WHERE id = '.$category_id);
        $pdf = PDF::loadView('table', ["fields" => $fields, "category_name" => $cat_name[0]->name, 'filters'=>json_decode($filter)])->setPaper('a2', 'landscape');
        return $pdf->download('fields.pdf');
    }

    public function checkNewUser()
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
            return response()->json([
                "status" => false,
                "msg" => "You are not allowed"
            ]);
        $result = DB::select('SELECT COUNT(*) AS num_new_admin FROM `appusers` WHERE is_admin = 1 AND is_allowed = 0');
        if($result[0]->num_new_admin > 0)
        {
            return response()->json([
                "status" => true,
            ]);
        }else{
            return response()->json([
                "status" => false,
            ]);
        }
    }

    public function activeRecord(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
            return response()->json([
                "status" => false,
                "msg" => "You are not allowed"
            ]);

        $id = $request['dbID'];
        $val = $request['val'];
        
            
        DB::update('UPDATE `field_data` SET `updated_at`= CURRENT_TIMESTAMP, `activated`= ?  WHERE `id`=?', [$val == "true" ? 1: 0, $id]);
        
        return response()->json([
            "status" => true,
        ]);
    }

    public function activeRecord2(Request $request)
    {
        if(!Auth::user()->is_admin)
            return response()->json([
                "status" => false,
                "msg" => "You have no permissions"
            ]);
        if(!Auth::user()->is_allowed)
            return response()->json([
                "status" => false,
                "msg" => "You are not allowed"
            ]);
        $id = $request['dbID'];
        $val = $request['val'];
        if($val == '1')
        {
            event(new NewDataArrivedEvent('new data'));
            
        }
        DB::update('UPDATE `field_data` SET `updated_at`= CURRENT_TIMESTAMP, `activated`= ?  WHERE `id`=?', [$val, $id]);
        return response()->json([
            "status" => true,
        ]);
    }

    public function fileExport($id, $filter) 
    {
        $category_id = $id;
        //$data = json_decode(json_encode($request['data']));
       // $fields = DB::select('SELECT * FROM `field_data` WHERE category = '.$category_id.' ORDER BY created_at desc');
        $fields = FieldData::orderByRaw('created_at desc')->where(function ($query) use ($category_id, $filter){
            $data2 = json_decode($filter);
            $query->where('category', '=', $category_id);
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
            if($data2->only_activated == '1')
            {
                $query->where('activated', '=', 1);
            }
        })->get();
        foreach ($fields as $field)
        {
            $newExpireDate = date("dmy", strtotime($field->expiration_date));
            $callorput = "C";
            if($field->call_put_strategy === "put")
            $callorput = "P";
            $field["tracker"] = $field->symbol." ".$field->symbol."_".$newExpireDate.$callorput.$field->strike."@".$field->strike_price;
        }
        $cat_name = DB::select('SELECT name FROM `field_categories` WHERE id = '.$category_id);
        $fileName = "fields.csv";
        $filename = "/CSV/".$fileName;
        $fileHeaderForm = 'Type, Item, Description, Cost, Category, TDate,Ttime, Created_at';
        $fileContent  = "id, posted_date, buy_date, symbol, qty,expiration_date, sell_date,tracker, call_put_strategy, strike, strike_price, in_price, out_price, net_difference, high_price, percentage, status, category, activated\n";
        foreach($fields as $field)
        {
            $row = "";
            $row .= str_replace(",", " ",$field->id).",";
            $row .= str_replace(",", " ",$field->posted_date).",";
            $row .= str_replace(",", " ",$field->buy_date).",";
            $row .= str_replace(",", " ",$field->symbol).",";
            $row .= str_replace(",", " ",$field->qty).",";
            $row .= str_replace(",", " ",$field->expiration_date).",";
            $row .= str_replace(",", " ",$field->sell_date).",";
            $row .= str_replace(",", " ",$field->tracker).",";
            $row .= str_replace(",", " ",$field->call_put_strategy).",";
            $row .= str_replace(",", " ",$field->strike).",";
            $row .= str_replace(",", " ",$field->strike_price).",";
            $row .= str_replace(",", " ",$field->in_price).",";
            $row .= str_replace(",", " ",$field->out_price).",";
            $row .= str_replace(",", " ",$field->net_difference).",";
            $row .= str_replace(",", " ",$field->high_price).",";
            $row .= str_replace(",", " ",$field->percentage).",";
            $row .= str_replace(",", " ",$field->status == 1 ? 'OPEN' : 'CLOSED').",";
            $row .= str_replace(",", " ",$cat_name[0]->name).",";
            $row .= str_replace(",", " ",$field->activated).",";
            $row.="\n";
            $fileContent.=$row;
        }
        
        Storage::disk('local')->put($filename, $fileContent);
        return response()->download(storage_path('app' . $filename));
    }

    
}
