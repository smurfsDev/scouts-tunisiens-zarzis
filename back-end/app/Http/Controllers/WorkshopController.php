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
    public function store(Request $request){
      
      
        $workshop = Workshop::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'heure_debut' => $request->input('heure_debut'),
            'heure_fin' => $request->input('heure_fin'),
            'event_id' => $request->input('event_id'),
            'organisateur_id' => $request->user()->id,
            'leader_id' => $request->input('leader_id'),
            'status' => 0
        ]);
        if ($workshop) {
            return response()->json([
                'success' => true,
                'message' => 'Workshop created ! '
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error !'
            ], 500);
        }
    }
}
