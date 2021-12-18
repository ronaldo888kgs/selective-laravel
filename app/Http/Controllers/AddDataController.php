<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendContact;
use App\Models\MailCategory;
use App\Models\SendMails;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactImport;
class AddDataController extends Controller
{
    //
    public function getFieldNames($fieldNumber)
    {
        switch($fieldNumber)
        {
            case 0:
                return 'email';
                break;
            case 1:
                return 'telegram_id';
                break;
            case 2:
                return 'discord_id';
                break;
            case 4:
                return 'slack_id';
                break;
            case 5:
                return 'phone';
                break;
        }
    }
    public function __invoke(Request $request)
    {

        $category = null;
        $categories = MailCategory::all();
        $contacts = null;
        $sent_mails = null;
        $search_field_name = null;
        $search_value = null;
        $seaech_field = null;
        $cnt_contacts = 0;
        if(isset($request['search_field']) && isset($request['search_value']))
        {

            $search_field = $request['search_field'];
            $search_field_name = AddDataController::getFieldNames($search_field);
            $search_value = $request['search_value'];
        }else{
            $search_field = 0;
            $search_value = '';
        }
            
        if(isset($request['category']))
        {
            $category = $request['category'];
            $cnt_contacts = SendContact::count();
            $contacts = SendContact::where('group_id', $category);
            if($search_field_name != null)
                $contacts = $contacts->where($search_field_name, 'like', '%'.$search_value.'%');
            $cnt_contacts = $contacts->count();
            $contacts = $contacts->paginate(10);
            $sent_mails = SendMails::orderByRaw('created_at desc')->where('group_id', $category)->paginate(10);
        }else{
            $category = $categories[0]->id;
            
            $contacts = SendContact::where('group_id', $categories[0]->id);
            $cnt_contacts = $contacts->count();
            $contacts = $contacts->paginate(10);
            $sent_mails = SendMails::orderByRaw('created_at desc')->where('group_id', $categories[0]->id)->paginate(10);
        }        
        return view('mails.adddata', 
            [
                "categories" => $categories, 
                "contacts" => $contacts, 
                "sent_mail" => $sent_mails, 
                "current_category" => $category,
                'search_field' => $search_field,
                'search_value' => $search_value,
                'count_contacts' => $cnt_contacts
            ]);
    }

    public function index(Request $request)
    {
        __invoke($request);
    }

    public function viewSendMail($category, $type, $address)
    {

    }


    public function addEditCategory(Request $request)
    {
        $listCat = MailCategory::where('name', $request['old_category'])->first();
        if($listCat == null)
        {
            return response()->json([
                "status" => false,
                "message" => "Not found cagetory :".$request['old_category']
            ]);
        }
        
        $listCat->update(['name' => $request['new_category']]);
        return response()->json([
            "status" => true,
            "message" => "Successed update cagetory"
        ]);
    }
    public function addNewCategory(Request $request)
    {
        $listCat = MailCategory::where('name', $request['category'])->first();
        if($listCat != null)
        {
            return response()->json([
                "status" => false,
                "message" => "Already existed category"
            ]);
        }

        MailCategory::create([
            'name' => $request['category'],
        ]);

        return response()->json([
            "status" => true,
            "message" => "Successed a new category"
        ]);

    }

    public function sendMail(Request $request)
    {
        if(isset($request["hidden_selected_contact"]))
        {
            $strContacts = $request["hidden_selected_contact"];
            $contacts = explode(',', $strContacts);
            foreach($contacts as $contact)
            {
                //Mail::to($contact)->send(new SendMail($request));
                //Mail::send($contact, )
                $mailData = [
                    'title' => $request['mail-title'],
                    'content' => $request['mail-editor']
                ];
                Mail::to($contact)->send(new SendMail($mailData));
            }

        }else{
            return back();
        }
        return back();
        
    }

    public function deleteMail(Request $request)
    {
        $mail_ids = $request['delete_mail'];
        $mail_id_list = explode(",", $mail_ids);
        foreach($mail_id_list as $mailID)
        {
            $data2 = SendMails::where('id', '=', $mailID)->first();
            if($data2 != null)
                $data2->delete();
            
        }
        

        return response()->json([
            "status" => true,
        ]);
    }


    public function deleteContact(Request $request)
    {
        $contacts = $request['contact_id'];
        $contacts_list = explode(",", $contacts);
        foreach($contacts_list as $contact)
        {
            $data2 = SendContact::where('id', '=', $contact)->first();
            if($data2 != null)
                $data2->delete();
            
        }
        

        return response()->json([
            "status" => true,
        ]);
    }

    public function addBulkContacts(Request $request)
    {
        if(!$request->file('file'))
            return back();
            
        $rows = Excel::toArray(new ContactImport, $request->file('file')->store('temp')); 
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
            $this->createContact($row[0], 
                                $row[1],
                                $row[2],
                                $row[3],
                                $row[4],
                                $row[5],
                                $row[6],
                                $row[7],
                                0,
                                $request['contact_type']);
        }
        return back();
    }

    public function createContact($first_name, 
                                $last_name, 
                                $email, 
                                $telegram_id, 
                                $discord_id, 
                                $twitter_id,
                                $slack_id, 
                                $phone, 
                                $type, 
                                $group_id)
    {
        $data2 = SendContact::where('first_name', '=', $first_name)->
                                where('last_name', '=', $last_name)->
                                where('email', '=', $email)->
                                where('telegram_id', '=', $telegram_id)->
                                where('discord_id', '=', $discord_id)->
                                where('twitter_id', '=', $twitter_id)->
                                where('slack_id', '=', $slack_id)->
                                where('phone', '=', $phone)->
                                where('group_id', $group_id)->first();
        if($data2 == null)
        {
            $result = SendContact::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'telegram_id' => $telegram_id,
                'discord_id' => $discord_id,
                'twitter_id' => $twitter_id,
                'slack_id' => $slack_id,
                'phone' => $phone,
                'type' => $type,
                'group_id' => $group_id
            ]);
            return true;
        }else{
            return false;
        }
    }
    public function addData(Request $request)
    {
        if($this->createContact(
            $request['first_name'], 
            $request['last_name'], 
            $request['email'], 
            $request['telegram_id'], 
            $request['discord_id'], 
            $request['twitter_id'],
            $request['slack_id'], 
            $request['phone'], 
            $request['type'], 
            $request['group_id']))
        {
            return response()->json([
                "status" => true,
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "That address is already existed."
        ]);
        
        
    } 
}
