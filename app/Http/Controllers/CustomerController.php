<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Project;
use App\Quote;
use App\EventDetail;
use App\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\EventDetail as EventDetailResource;
use App\Http\Resources\ProjectService as ProjectServiceResource;
use Carbon\Carbon;
use stdClass;

class CustomerController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'address'=>'required',
            'source'=>'required',
            'sales_person'=>'required',
            'event_type'=>'required',
            'bride_name'=>'required',
            'groom_name'=>'required'
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
        
        $createQuote=Quote::create([
            "tax"=>18
        ]);

        if ($this->isNullOrEmpty($createQuote)) {
            if ($request->filled('next_follow_up')) {
                
                $next_follow_up=new Carbon($request->next_follow_up);
                $createProject=Project::create([
               'name'=>$request->input('name')."-".Str::random(5),
               'quote_id'=>$createQuote->id,
               'next_follow_up'=>$next_follow_up,
               
                ]);
            } else {
                $createProject=Project::create([
                    'name'=>$request->input('name')."-".Str::random(5),
                    'quote_id'=>$createQuote->id
                    ]);
            }
        }

        if ($this->isNullOrEmpty($createProject)) {
            $inputs=$request->all();
            $createLead=Customer::create(
                array_merge($inputs, ["project_id"=>$createProject->id])
            );
        }
    
        
        if ($this->isNullOrEmpty($createLead)) {
            $event_details=$request->input('event_type');
            if (!empty(json_decode($event_details))) {
                foreach (json_decode($event_details) as $event) {
                    $event->customer_id=$createProject->id;
                    $event->project_id=$createProject->id;
                    $event->event_start_datetime=new Carbon($event->event_start_datetime);
                    $event->event_end_datetime=new Carbon($event->event_end_datetime);
                    $createEvents[]=EventDetail::create(
                        (array)$event
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' => "Event Details Couldn't created!",
                );
                return new JsonResponse($response);
            }
        }
        $response = array(
            'success' => true,
            "response" => $createLead
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
    
    public function fetchAllLead(Request $request)
    {
        
        $allLeads = Customer::with([
            'project' => function ($query) {
                $query->where('is_lead', 1);
            }
        ])->get();
        if($allLeads && $allLeads[0]["project"]){

            return CustomerResource::collection($allLeads)->all();
        }else{
            return [];
        }
        
        
        
        
    }

    public function fetchAllProject(Request $request)
    {
        
        $allLeads = Customer::with([
            'project' => function ($query) {
                $query->where('is_lead', 0)->where('is_completed',0);
            }
        ])->get();
        if($allLeads && $allLeads[0]["project"]){
            return CustomerResource::collection($allLeads)->all();
        }else{
            return [];
        }
        
    }

    public function update(Request $request, Response $response, $id)
    {
        $finalResponseObj=new stdClass();
        $validator = Validator::make($request->all(), [
            // 'name'=>'required',
            // 'phone'=>'required',
            // 'email'=>'required',
            // 'address'=>'required',
            // 'source'=>'required',
            // 'sales_person'=>'required',
            'events'=>'required',
            'quote'=>'required',
        ]);
        
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $errors=$validator->errors()->first();
            $code='200';
            $response = array(
                'code' => $response->status(),
                'message' => $message,
                "errors" => $errors
            );
            return new JsonResponse($response, $code);
        }
        $checkCustomerExist=Customer::find($id);
        $custProject=Project::where('id', '=', $checkCustomerExist->project_id)->first();
        
        if ($this->isNullOrEmpty($checkCustomerExist)) {
            $inputs=$request->all();
            $checkCustomerExist->update(
                array_merge($inputs)
            );
            $finalResponseObj=$checkCustomerExist;
            // updating Event details
            $eventResponse=[];
            $event_details=json_decode($request->input('events'));
            if (!empty($event_details)) {
                foreach ($event_details as $eventKey => $event) {
                    if (isset($event->id)) {
                        $eventDetail = EventDetail::find($event->id);
                        if (isset($event->action) && $event->action==="DELETED") {
                            $eventDetail->delete();
                            continue;
                        }
                        if(isset($event->event_start_datetime) && isset($event->event_end_datetime)){
                            $event->event_start_datetime=new Carbon($event->event_start_datetime);
                            $event->event_end_datetime=new Carbon($event->event_end_datetime);
                        }
                        $eventDetail->update(
                            (array)$event
                        );
                    } else {
                        $event->customer_id=$checkCustomerExist->id;
                        $event->project_id=$checkCustomerExist->project_id;
                        if(isset($event->event_start_datetime) && isset($event->event_end_datetime)){
                            $event->event_start_datetime=new Carbon($event->event_start_datetime);
                            $event->event_end_datetime=new Carbon($event->event_end_datetime);
                        }
                        $eventDetail = EventDetail::create(
                            (array)$event
                        );
                        $event->id = $eventDetail->id;
                    }

                    $serviceResponse = [];
                    if (!empty($event->services) && $eventDetail) {
                        foreach ($event->services as $serviceskey => $eventService) {
                            if (!empty($eventService->id)) {
                                $projectService = ProjectService::find($eventService->id);
                                if (isset($eventService->action) && $eventService->action==="DELETED") {
                                    $projectService->delete();
                                    continue;
                                }
                                $eventService->event_id=$event->id;
                                $projectService->update(
                                    (array)$eventService
                                );
                                array_push($serviceResponse, new ProjectServiceResource($projectService->refresh()));
                            } else {
                                $projectService = ProjectService::create([
                                'project_id'=>$custProject->id,
                                'service_id'=>$eventService->service_id,
                                'event_id'=>$event->id,
                                'unit'=>$eventService->unit,
                                'price'=>$eventService->price,
                                'total_price'=>$eventService->total_price
                                ]);
                                array_push($serviceResponse, new ProjectServiceResource($projectService));
                            }
                        }
                    }

                    $event->services = $serviceResponse;
                    array_push($eventResponse, $event);
                }
                $finalResponseObj->event=$eventResponse;
            } else {
                $response = array(
                    'code' => $response->status(),
                    'message' => "Events Updation Failed!",
                    "data" => "error"
                );
                return new JsonResponse($response);
            }
            if ($this->isNullOrEmpty($request->input('quote'))) {
                $quotes=(array)json_decode($request->input('quote'));
                
                $updateQuotes=Quote::find($quotes["id"]);
                $updateQuotes->update(
                    (array)$quotes
                );
                $updateQuotes->refresh();
                $finalResponseObj->quote=$updateQuotes;
            }
            
            $response = array(
                'code' => $response->status(),
                'message' => "Updated Successfully!",
                "data" => $finalResponseObj
            );
            return new JsonResponse($response);
        } else {
            $response = array(
                'code' => $response->status(),
                'message' => "lead not found",
                "data" => $checkCustomerExist
            );
            return new JsonResponse($response);
        }
    }

    public function show(Request $request, Response $response, $id)
    {
        $responseObj=new stdClass();
        $customer=Customer::find($id);
        if ($this->isNullOrEmpty($customer)) {
            $project=Project::find($customer->project_id);
            $customer->project_id=$project;
            $responseObj=$customer;
            $events=EventDetail::where('customer_id', '=', $id)->get();
            $responseObj->events=EventDetailResource::collection($events)->all();
            $quotes=Quote::where('id', '=', $project->quote_id)->first();
            $responseObj->quote=$quotes;
        }
        $response = array(
            'code' => $response->status(),
            'message' => "success",
            "data" => $responseObj
        );
        return ($response);
    }
}
