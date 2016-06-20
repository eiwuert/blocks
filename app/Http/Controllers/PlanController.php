<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function buscar_plan(Request $request){
        $codigo = $request["dato"];
        $plan = Plan::find($codigo);
        return $plan;
    }
}
