<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function all(){
        $events = Event::all();
        if (empty($events)) {
            return response()->json(['message' => 'لا يوجد تظاهرات '], 404);
        }
        return response()->json($events, 200);
    }

    public function store(Request $request){
        // dd($request->user()->roles()->get('troupe_id'));
        $troupe = $request->user()->roles()->get('troupe_id');
   
        $event = Event::create([
            'name' => $request->input('name'),
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'troupe_id' => $troupe[0]->troupe_id,
            'type' => $request->input('type'),
            'status' => 0
        ]);
        if ($event) {
            return response()->json([
                'success' => true,
                'message' => 'لقد تم ارسال طلب انشاء تظاهرة '
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في إرسال الطلب'
            ], 500);
        }
    } 
}
