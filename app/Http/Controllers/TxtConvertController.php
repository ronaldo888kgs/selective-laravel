<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TxtConvertController extends Controller
{
    //
    public function __invoke(){
        return view('txt_convert');
    }
    public function index(){__invoke();}
    public function convert(Request $request){
        if(!$request->file('txt-file'))
            return back();
        $filename = $request->file('txt-file')->getClientOriginalName();
        $filename = substr($filename, 0, strrpos($filename, "."));
        $content = $request->file('txt-file')->get();

        $numbers = explode(',',$content);
        $fileContent = "Phone number\n";
        foreach($numbers as $number)
        {
            $fileContent .= $number."\n";
        }
        $filename.="_converted.csv";
        Storage::disk('local')->put($filename, $fileContent);
        return response()->download(storage_path('app/'.$filename));
    }
}
