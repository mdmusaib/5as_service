<?php

namespace App\Http\Controllers;

use App\EmployeeAvalability;
use Carbon\Carbon;
use App\TaskTracker;
use App\ProjectService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskOfEmployee as EmployeeTasks;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setUnavailable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'=>'required',
            'unavailable_date'=>'required',
            
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
    $setEmployeeUnavailableDate=EmployeeAvalability::create([
        "employee_id"=>$request->employee_id, 
        "unavailable_date"=> new Carbon($request->unavailable_date)
    ]);
    return $setEmployeeUnavailableDate;
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getThisMonthNotAvailableDate(Request $request)
    {
        $getRecord=EmployeeAvalability::whereMonth('created_at', Carbon::now()->month)->get();
        return $getRecord; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignEmpService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'=>'required',
            'service_id'=>"required",
            "event_id"=>"required",
            "project_id"=>"required", 
            'available_date'=>'required'
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
    
    $assign=Task::create($request->all());

    if($assign){
     $createTrackerForEmployee=TaskTracker::create([
            'employee_id'=>$assign->employee_id,
            "task_id"=>$assign->id,
            "is_started"=>false,
        ]);

    return $assign;
    }
    
    
    }

    public function fetchEachEmployeeTask(Request $request){
        $task=Task::all();
        return EmployeeTasks::collection($task)->all();
        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeAvalability  $employeeAvalability
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeAvalability $employeeAvalability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeAvalability  $employeeAvalability
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeAvalability $employeeAvalability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeAvalability  $employeeAvalability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeAvalability $employeeAvalability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeAvalability  $employeeAvalability
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeAvalability $employeeAvalability)
    {
        //
    }
}
