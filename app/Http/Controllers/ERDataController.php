<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use App\Models\ErDatas;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ERDataImport;

class ERDataController extends Controller
{
    public function getFieldName($fieldNumber)
    {
        switch($fieldNumber)
        {
            case '1': 
                {
                    return 'stock_name';
                }
                break;
            case '2':  
                {
                    return 'stock_price';
                }
                break;
            case '3':  
                {
                    return 'er_date';
                }
                break;
            case '4':  
                {
                    return 'er_type';
                }
                break;
            case '5':  
                {
                    return 'price_before';
                }
                break;
            case '6':  
                {
                    return 'price_after';
                }
                break;
        }
        return 'no_field';
    }
    //
    public function __invoke(Request $request)
    {
        $erdata = [];
        if(isset($request['key']) && isset($request['value']))
        {
            $field_name = ERDataController::getFieldName($request['key']);
            $erdata = ErDatas::orderByRaw('created_at desc')->where($field_name, '=', $request['value'])->paginate(20);
            return view('er_data.er_data', 
            [
                'er_datas' => $erdata,
                'key' => $request['key'],
                'value' => $request['value']
            ]);
        }else{
            $erdata = ErDatas::orderByRaw('created_at desc')->paginate(20);
            return view('er_data.er_data', 
        [
            'er_datas' => $erdata,
        ]);
        }
        
        
    }
    public function index(Request $request)
    {
        __invoke($request);
    }


    public function importFromCSV(Request $request)
    {
        if(!$request->file('file'))
            return back();
        $sheetes = Excel::toArray(new ERDataImport, $request->file('file')->store('temp')); 
        if(count($sheetes) == 0)
        {
            return back();
        }
        $sheet = $sheetes[0];
        foreach($sheet as $key => $row)
        {
            if($key == 0)
                continue;
            $dataType = 0;
            if($row[4] == 'Very Good')
                $dataType = 1;
            else if($row[4] == 'Bad')
                $dataType = 2;
            else if($row[4] == 'Very Bad')
                $dataType = 3;
            ERDataController::createERData($row[1], $row[2], $row[3], $dataType, $row[5], $row[6]);
        }
        return back();
    }

    public function exportAsPdf(Request $request)
    {
        $erdata = ErDatas::orderByRaw('created_at desc')->get();
        $pdf = PDF::loadView('er_data.export_table', ["er_datas" => $erdata])->setPaper('a2', 'landscape');
        return $pdf->download('esdata.pdf');

    }

    public function exportAsCsv(Request $request)
    {
        $erdata = ErDatas::orderByRaw('created_at desc')->get();
        $fileName = "er_data.csv";
        $filename = "/CSV/".$fileName;
        $fileContent  = "id, Stock Name, Stock Price, ER Date, ER Type, Price Before, Price After, % Change,\n";
        foreach($erdata as $key => $data)
        {
            $row = "";
            $row .= str_replace(",", " ",($key + 1)).",";
            $row .= str_replace(",", " ",($data->stock_name)).",";
            $row .= str_replace(",", " ",($data->stock_price)).",";
            $row .= str_replace(",", " ",($data->er_date)).",";
            if($data->er_type == 1)
            {
                $row .= str_replace(",", " ", "Very Good").",";    
            }else if($data->er_type == 2)
            {
                $row .= str_replace(",", " ","Bad").",";    
            }else if($data->er_type == 3)
            {
                $row .= str_replace(",", " ","Very Bad").",";    
            }else{
                $row .= str_replace(",", " "," ").",";    
            }
            $row .= str_replace(",", " ",($data->price_before)).",";
            $row .= str_replace(",", " ",($data->price_after)).",";
            if ($data->price_before > 0)
                $row .= str_replace(",", " ",round(($data->price_after * 100) / $data->price_before - 100, 2)).",";
            else
                $row .= str_replace(",", " ", ' ').",";
            $row .= "\n";
            $fileContent.=$row;
        }
        Storage::disk('local')->put($filename, $fileContent);
        return response()->download(storage_path('app' . $filename));
    }

    public function delete(Request $request)
    {
        if(!isset($request["deleteID"]))
            return response()->json([
                "status" => false,
                "msg" => "invalid request"
            ]);
        $ids = $request["deleteID"];
        $listID = explode(',', $ids);
        foreach($listID as $id)
        {
            if($id != '')
            {
                $data = ErDatas::where('id', '=', $id)->first();
                if($data != null)
                    $data->delete();
            }
        }
        return response()->json([
            "status" => true,
            "msg" => "all removed"
        ]);
    }

    public function createERData($er_stock_name,
                                $er_stock_price,
                                $er_date,
                                $er_type,
                                $er_price_before,
                                $er_price_after
                                )
    {
        $data = ErDatas::where('stock_name', '=', $er_stock_name)->
                where('stock_price', '=', $er_stock_price)->
                where('er_date', '=', $er_date)->
                where('er_type', '=', $er_type)->
                where('price_before', '=', $er_price_before)->
                where('price_after', '=', $er_price_after)->first();
        if($data == null)
        {
            ErDatas::create([
                'stock_name' => $er_stock_name,
                'stock_price' => $er_stock_price,
                'er_date' => $er_date,
                'er_type' => $er_type,
                'price_before' => $er_price_before,
                'price_after' => $er_price_after,
            ]);
            return true;
        }else{
            return false;
        }
    }
    public function add(Request $request)
    {
        if(!isset($request['er_stock_name']) && 
        !isset($request['er_stock_price']) && 
        !isset($request['er_date']) && 
        !isset($request['er_type']) && 
        !isset($request['er_price_before']) && 
        !isset($request['er_price_after']))
        return response()->json([
            "status" => false,
            "msg" => "invalid request"
        ]);
        if(ERDataController::createERData($request['er_stock_name'],
        $request['er_stock_price'],
        $request['er_date'],
        $request['er_type'],
        $request['er_price_before'],
        $request['er_price_after']))
        {
            return response()->json([
                "status" => true,
            ]);
        }else{
            return response()->json([
                "status" => false,
                "msg" => "already exist"
            ]);
        }
       
    }

}
