<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function all(){
        $workshops = Workshop::all();
        if (empty($workshops)) {
            return response()->json(['message' => 'Workshops not found '], 404);
        }
        return response()->json($workshops, 200);
    }
}
