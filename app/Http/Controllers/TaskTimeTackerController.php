<?php

namespace App\Http\Controllers;

use App\TaskTracker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'start_time'=>'required',
            'end_time'=>'required',
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
    $start_time= new Carbon($request->start_time);
    $start_time->toTimeString();
    $end_time= new Carbon($request->end_time);
    $end_time->toTimeString();
    $startEndTimer=TaskTracker::create([
        'employee_id'=>$request->employee_id,
        "task_id"=>$request->task_id,
        "start_time"=>$start_time,
        "end_time"=>$end_time,
    ]);
    return $startEndTimer;
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
