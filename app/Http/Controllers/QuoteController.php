<?php

namespace App\Http\Controllers;
use App\Quote;
use App\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function updatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quote_id'=>'required',
            'project_id'=>'required',
            'paid_amount'=>'required'
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
        $updatePayment=Quote::where('is_project_completed','=',false)->where('id',$request->quote_id)->update([
            'paid_amount'=>$request->paid_amount,
        ]);
        $updateStatus=Quote::where('paid_amount','=','base_price')->update([
            'is_project_completed'=>true
        ]);

        // update is_lead in project table
        $updateIsLeadStatus=Project::where('id','=',$request->project_id)->update([
            'is_lead'=>0
        ]);
        
        $getUpdatedRecord=Quote::where('id',$request->quote_id)->get();
        return $getUpdatedRecord;
    }
    

}
