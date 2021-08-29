<?php

namespace App\Http\Controllers;

use App\TaskTracker;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\TaskTracker as TaskTrackerResource;
use App\Http\Resources\TaskTimer as TimeTrackerResource;


class TaskTimeTackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function startEndTimer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'=>'required',
            'task_id'=>'required',
            "type"=>'required'
            // 'start_time'=>'required',
            // 'end_time'=>'required',
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
    $checkStatus=TaskTracker::where('task_id',$request->task_id)->first();
    
    if($checkStatus && $request->type==="start"){
        $start_time= Carbon::now();
        $start_time->toTimeString();
        if($checkStatus && $checkStatus->is_started===0){
             $startEndTimer=TaskTracker::where('task_id',$request->task_id)->update([
            "start_time"=>$start_time,
            "is_started"=>true,
        ]);
             return  TaskTracker::where('task_id',$request->task_id)->first();
        }else{
               $response = array(
                    'success' => false,
                    'message' => "Already in start status!",
                );
             return  $response;
        }
       
        
    
    }else if($checkStatus && $request->type==="stop"){
     
            $end_time= Carbon::now();
            $end_time->toTimeString();
            if($request->type==="stop"){
                  $startEndTimer=TaskTracker::where('task_id',$request->task_id)->update([
                "end_time"=>$end_time,
                "is_started"=>false
            ]);
            return  TaskTracker::where('task_id',$request->task_id)->first();
            }else{
                 $response = array(
                    'success' => false,
                    'message' => "Already in stop status!",
                );
             return  $response;
            } 

          
     
    }else{
        if($checkStatus&& $checkStatus->is_started===null){
            $startEndTimer=TaskTracker::where('task_id',$request->task_id)->update([
            "start_time"=>$start_time,
            "is_started"=>true,
        ]);
             return  TaskTracker::where('task_id',$request->task_id)->first();
        }
        $start_time=  Carbon::now();
        $start_time->toTimeString();
    }
   
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchEmployeeTask(Request $request)
    {
        $getAllTask=TaskTracker::all();
        return TaskTrackerResource::collection($getAllTask)->all();
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
     * @param  \App\TaskTracker  $taskTracker
     * @return \Illuminate\Http\Response
     */
    public function show(TaskTracker $taskTracker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskTracker  $taskTracker
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskTracker $taskTracker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskTracker  $taskTracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskTracker $taskTracker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskTracker  $taskTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskTracker $taskTracker)
    {
        //
    }
}
