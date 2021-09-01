<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use stdClass;
use App\Customer;
use App\EventDetail;
use App\Quote;
use App\Task;
use App\Http\Resources\EventDetail as EventDetailResource;
use \Spatie\Browsershot\Browsershot;
use PDF;


class ProjectController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'current_status'=>'required',
        ]);
        
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
        $updateStatus=Project::find($id);
        $updateStatus->update([
            'current_status'=>$request->input('current_status')
        ]);
        $updateStatus->refresh();
        $response = array(
            'success' => true,
            'message' => "success",
            "response" => $updateStatus
        );
        return new JsonResponse($response);
    }
    public function update_follow_up_date(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'next_follow_up'=>'required',
        ]);
        
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
        $follow_up_date=new Carbon($request->input('next_follow_up'));
        $updateFollow_Up_Date=Project::find($id);
        $updateFollow_Up_Date->update([
            'next_follow_up'=>$follow_up_date
        ]);
        $updateFollow_Up_Date->refresh();
        $response = array(
            'success' => true,
            'message' => "success",
            "response" => $updateFollow_Up_Date
        );
        return new JsonResponse($response);
    }
    public function getAllRemainders(Request $request, Response $response)
    {
        $getFollowUpStatus=Project::where('current_status', '=', 'FOLLOWUP')->whereDate('next_follow_up', '>=', date('Y-m-d'))->get();
        $getDelayedRecord=Project::where('current_status', '=', 'DELAYED')->get();
        $getQuoteFinalRecord=Project::where('current_status', '=', 'QUOTEFINAL')->get();
        $getOnHoldRecord=Project::where('current_status', '=', 'ONHOLD')->get();
        $allRemainders=array("FOLLOWUP"=>$getFollowUpStatus,"DELAYED"=>$getDelayedRecord, "QUOTEFINAL"=>$getQuoteFinalRecord, "ONHOLD"=>$getOnHoldRecord);
        $response = array(
            'code' => $response->status(),
            'message' => "success",
            "data" => $allRemainders
        );
        return new JsonResponse($response);
    }

    public function generateQuotes(Request $request, Response $response, $id)
    {
        $leadData = app('App\Http\Controllers\CustomerController')->show($request, $response, $id);
        $eventsArray=json_decode(json_encode($leadData["data"]->events), true);
        $total_price=0;
        if (count((array)$eventsArray)>0) {
            foreach ((array)$eventsArray as $eventKey => $leadDetail) {
                $quotesDetails[]=(object)["event_name"=>$leadDetail["event"],"event_date"=>$leadDetail["event_start_datetime"],"location"=>$leadDetail["location"],"services"=>$leadDetail["services"]];
                
                // calculate service price and tax
                foreach ($leadDetail["services"] as $servicekey=>$serviceList) {
                    $data[]=$serviceList;
                    $total_price=(float)$total_price+$serviceList['price']*$serviceList["unit"];
                }
            }
            $quoteData=$leadData["data"]->quote;
            $subTotal=$total_price;
            $total_price=$total_price-$quoteData->adjustment-$quoteData->discount;
            $total_price=$total_price + $total_price*($quoteData->tax/100);
            $responseObj=new stdClass();
            $responseObj->lead=json_encode($quotesDetails);
            $responseObj->total_price=$total_price;
            $responseObj->quote=$quoteData;
            $responseObj->subTotal=$subTotal;
            $responseObj->customerName = $leadData["data"]->name;
    
            // return view("quotesPdf")->with("details", $responseObj);
            
            /* $generatedView = view("quotesPdf")->with("details", $responseObj);
            $fileURL = "quotes/" . Str::random(30) . ".pdf"; 
            Browsershot::html($generatedView)->setOption('args', ['--disable-web-security'])->showBackground()->save($fileURL); */

            /* return \response()->json([
                "data" => url(env('APP_URL') . "/" . $fileURL)
            ], 200, [], JSON_UNESCAPED_SLASHES); */
            // return response()->download(public_path($fileURL));

            $response = array(
                'code' => 200,
                'message' => "success",
                "data" => $responseObj
            );
            return new JsonResponse($response);
        }
    }

    public function show(Request $request, Response $response, $id)
    {
        $responseObj=new stdClass();
        $obj=new stdClass();
        $arr=[];
        $customer=Customer::find($id);
        if ($this->isNullOrEmpty($customer)) {
            $project=Project::find($customer->project_id);
            $customer->project_id=$project;
            $responseObj=$customer;
            $events=EventDetail::where('customer_id', '=', $id)->get();
            $responseObj->events=EventDetailResource::collection($events)->all();
            $quotes=Quote::where('id', '=', $project->quote_id)->first();
            $responseObj->quote=$quotes;

            // get service selected dropdown from db
            $getSelectedDropdown=Task::where('project_id',$customer->project_id)->get();
            foreach ($getSelectedDropdown as $selectedService) {
                $obj->service=$selectedService->service_id;
                $obj->employee=$selectedService->employee_id;
                array_push($arr,$obj);

            }
            $responseObj->service_dropdown=$arr;
        }
        $response = array(
            'code' => $response->status(),
            'message' => "success",
            "data" => $responseObj
        );
        return ($response);
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
