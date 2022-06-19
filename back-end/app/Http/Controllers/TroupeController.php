<?php

namespace App\Http\Controllers;

use App\Models\Troupe;
use Illuminate\Http\Request;

class TroupeController extends Controller
{
    public function index(){
        $troups = Troupe::all();
        return response()->json($troups);
    }
}
