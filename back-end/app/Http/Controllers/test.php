<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class test extends Controller
{
    public function test(Request $request){
        $user = $request->user()->roles;
        return $user;
    }
}
