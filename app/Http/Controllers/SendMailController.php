<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\MailCategory;
use App\Models\SendContact;
use App\Models\SendMails;
use App\Jobs\SendBulkQueueMail;

class SendMailController extends Controller
{
    public function __invoke()
    {
        $categories = MailCategory::all();
        $mailers = SendContact::where('group_id', $categories[0]->id);
        return view('mails.sendmail', ["categories" => $categories, "mailers" => $mailers, "current_category" => $categories[0]]);
    }

    public function index()
    {
        __invoke();
    }

    public function show($category, $mailers)
    {
        $categories = MailCategory::all();
        $category_val;
        foreach($categories as $cat)
        {
            if($cat->id == $category)
                $category_val = $cat;
        }
        $contacts = SendContact::where('group_id',$category)->get();
        return view('mails.sendmail', ["categories" => $categories,"contacts"=>$contacts, "mailers" => $mailers, "current_category" => $category_val]);
    }

    public function sendEmail(Request $request)
    {
        if(isset($request["address"]))
        {
            $mailers = $request["address"];
            $title = $request["title"];
            $body = $request['content'];
            $category = $request['category'];
            $mailData = [
                'title' => $title,
                'content' => $body
            ];
            //Mail::to($mailers)->send(new SendMail($mailData));
            $job = (new SendBulkQueueMail($mailData, $mailers))->delay(now()->addSeconds(2));
            dispatch($job);

            SendMails::create(['title' => $title, 'receivers' => implode(',', $mailers), 'description' => $body, 'group_id' => $category]);

            return response()->json([
                "status" => true,
                "message" => "Success mail sent"
            ]); 
        }
        return response()->json([
            "status" => false,
            "message" => "Failed"
        ]);

    }
}
