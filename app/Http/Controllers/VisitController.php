<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitController extends Controller
{

    public function departure(Visit $visit){

        $visit->update(["departure_time"=>now()]);
        return redirect()->back();
    }


}
