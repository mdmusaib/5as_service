<?php

namespace App\Http\Controllers;

use App\ServicesMaster;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ServiceMaster as ServiceMasterResource;
use Illuminate\Http\JsonResponse;

class ServicesMasterController extends Controller
{
    public function index(Response $response)
    {
        $allServices = ServicesMaster::all();
        $response = array(
            'code' => $response->status(),
            'message' => "success",
            "data" => ServiceMasterResource::collection($allServices)->all()
        );
        return $response;
    }
}
