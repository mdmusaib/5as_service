<?php

namespace App\Http\Controllers;


use App\Customer;
use App\Project;
use App\Quote;
use App\EventDetail;
use App\ProjectService;
use Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lead_dashboard(Request $request, Response $response)
    {
        $validator = Validator::make($request->all(), [
            'category'=>'required',
            'month'=>'required',
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
        $category=$request->input('category');
        $month=$request->input('month');
        $today= Carbon\Carbon::now();
        $today->toDateTimeString();
        $finalResponseObj=new stdClass();
        $keys = array('IVRCalls', "Facebook","linkedin", "Webchat", "Webform","Instagram","Mail","Walkin","Reference","BDMLeads","Canvera","Wedmegood","Googlebusiness","IVRWhatsapp");
        $lead = array_fill_keys($keys,0);
        $project = array_fill_keys($keys,0);
        switch($category){
            case "DAY":
            $customer=Customer::whereDate('created_at',$today)->get(['source']);
            $leadCount=Project::whereDate('created_at',$today)->count();
            $leadQuoteConfirmed=Project::whereDate('created_at',$today)->where('current_status','QUOTECONFIRMED')->count();
            
            foreach($customer as $cusKey=>$customerSrc){
                foreach($lead as $leadKey=>$leadChart){
                    if($leadKey ===  $customerSrc->source){
                        $lead[$leadKey]=$lead[$leadKey]+1;
                    }
                }
            }
            $finalResponseObj->leadchart=[$lead];
            $finalResponseObj->leadcount=$leadCount;
            $finalResponseObj->leadquoteconfirm=$leadQuoteConfirmed;
            $finalResponseObj->projectChart=[$project];
            $finalResponseObj->projectcount=$leadCount;
            return new JsonResponse($finalResponseObj);

              break;  

        case "WEEK":
            $customer=Customer::whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek(), Carbon\Carbon::now()->endOfWeek()])->get(['source']);
            $leadCount=Project::whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek(), Carbon\Carbon::now()->endOfWeek()])->count();
            $leadQuoteConfirmed=Project::whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek(), Carbon\Carbon::now()->endOfWeek()])->where('current_status','QUOTECONFIRMED')->count();
            
            foreach($customer as $cusKey=>$customerSrc){
                foreach($lead as $leadKey=>$leadChart){
                    if($leadKey ===  $customerSrc->source){
                        $lead[$leadKey]=$lead[$leadKey]+1;
                    }
                }
            }
            $finalResponseObj->leadchart=[$lead];
            $finalResponseObj->leadcount=$leadCount;
            $finalResponseObj->leadquoteconfirm=$leadQuoteConfirmed;
            $finalResponseObj->projectChart=[$project];
            $finalResponseObj->projectcount=$leadCount;
            return new JsonResponse($finalResponseObj);
            break;

            case "MONTH":
            $customer=Customer::whereMonth('created_at', Carbon\Carbon::now()->month)->get(['source']);
            $leadCount=Project::whereMonth('created_at', Carbon\Carbon::now()->month)->count();
            $leadQuoteConfirmed=Project::whereMonth('created_at', Carbon\Carbon::now()->month)->where('current_status','QUOTECONFIRMED')->count();
            
            foreach($customer as $cusKey=>$customerSrc){
                foreach($lead as $leadKey=>$leadChart){
                    if($leadKey ===  $customerSrc->source){
                        $lead[$leadKey]=$lead[$leadKey]+1;
                    }
                }
            }
            $finalResponseObj->leadchart=[$lead];
            $finalResponseObj->leadcount=$leadCount;
            $finalResponseObj->leadquoteconfirm=$leadQuoteConfirmed;
            $finalResponseObj->projectChart=[$project];
            $finalResponseObj->projectcount=$leadCount;
            return new JsonResponse($finalResponseObj);
                
                break;

        case "YEAR":
            $customer=Customer::whereYear('created_at', date('Y'))->get(['source']);
            $leadCount=Project::whereYear('created_at', date('Y'))->count();
            $leadQuoteConfirmed=Project::whereYear('created_at', date('Y'))->where('current_status','QUOTECONFIRMED')->count();
            
            foreach($customer as $cusKey=>$customerSrc){
                foreach($lead as $leadKey=>$leadChart){
                    if($leadKey ===  $customerSrc->source){
                        $lead[$leadKey]=$lead[$leadKey]+1;
                    }
                }
            }
            $finalResponseObj->leadchart=[$lead];
            $finalResponseObj->leadcount=$leadCount;
            $finalResponseObj->leadquoteconfirm=$leadQuoteConfirmed;
            $finalResponseObj->projectChart=[$project];
            $finalResponseObj->projectcount=$leadCount;
            return new JsonResponse($finalResponseObj);

            case "CUSTOM":
                $validator = Validator::make(array("start_date"=>$request->input('start_date'),"end_date"=>$request->input('end_date')), [
                    'start_date'=>'required',
                    'end_date'=>'required',
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
                $start_date=new Carbon\Carbon($request->input('start_date'));
                $end_date=new Carbon\Carbon($request->input('end_date'));
                $customer=Customer::whereBetween('created_at', [$start_date, $end_date])->get(['source']);
            $leadCount=Project::whereBetween('created_at', [$start_date, $end_date])->count();
            $leadQuoteConfirmed=Project::whereBetween('created_at', [$start_date, $end_date])->where('current_status','QUOTECONFIRMED')->count();
            
            foreach($customer as $cusKey=>$customerSrc){
                foreach($lead as $leadKey=>$leadChart){
                    if($leadKey ===  $customerSrc->source){
                        $lead[$leadKey]=$lead[$leadKey]+1;
                    }
                }
            }
            $finalResponseObj->leadchart=[$lead];
            $finalResponseObj->leadcount=$leadCount;
            $finalResponseObj->leadquoteconfirm=$leadQuoteConfirmed;
            $finalResponseObj->projectChart=[$project];
            $finalResponseObj->projectcount=$leadCount;
            return new JsonResponse($finalResponseObj);
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
