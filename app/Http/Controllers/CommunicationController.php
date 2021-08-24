<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Communication;
use App\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientMessage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class CommunicationController extends Controller
{
    public function show(Request $request, Response $response, $id)
    {
        $getAllCommunication=Communication::where('project_id', '=', $id)->get();
        $response = array(
            'code' => $response->status(),
            'message' => "success",
            "data" => $getAllCommunication
        );
        return new JsonResponse($response);
    }
    public function update(Request $request, Response $response, $id)
    {
        $validator = Validator::make($request->all(), [
            'project_id'=>'required',
            "type"=>"required",
        ]);
	//return $request->hasFile('document');
       // $file = $request->file('document');
        // return $file;
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $errors=$validator->errors()->first();
            $code='200';
            $response = array(
                'success' => false,
                'message' => $message,
                "errors" => $errors
            );
            return new JsonResponse($response, $code);
        }
        $communications = array();
        
        // mail customer if medium is email

        if($request->medium == "email"){
            $attachmentFile = $request->hasFile('attachment') ? $request->file('attachment') : '';
            $customer = Customer::where('project_id', $request->project_id)->first();

            if($customer && $customer->email){
                Mail::to($customer->email)->send(new ClientMessage($request->content, $attachmentFile));
            }
        }

        $createComm = Communication::create(
            (array)$request->all()
        );
        array_push($communications, $createComm);


        $response = array(
            'code' => $response->status(),
            'message' => "success",
            "data" => $communications
        );
        return new JsonResponse($response);
    }
    public static function isNullOrEmpty($value)
    {
        if (!is_null($value) || !empty($value)) {
            return true;
        } else {
            return false;
        }
    }
}
