<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function all(){
        $workshops = Workshop::all();
        if (empty($workshops)) {
            return response()->json(['message' => 'ورشة غير موجودة '], 404);
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
                'message' => 'لقد تم صنع ورشة ! '
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error !'
            ], 500);
        }
    }
    public function update (Request $request, $id){
        $workshop = Workshop::find($id);
        if (!$workshop) {
            return response()->json([
                "message" => "ورشة غير موجودة"
            ], 404);
        }
      
        $workshop->name = $request->input('name');
       $workshop->description = $request->input('description');
        $workshop->heure_debut = $request->input("heure_debut");
        $workshop->heure_fin = $request->input("heure_fin");
        $workshop->leader_id = $request->input("leader_id");
       
        $workshop->save(); 
        return response()->json(["data" => $workshop], 200);
    }
    public function destroy($id){
        $workshop = Workshop::find($id);
        if (!$workshop) {
            return response()->json([
                'message' => 'ورشة غير موجودة'
            ], 404);
        }
        $workshop->delete();
        return response()->json(['message' => 'لقد تم حذف ورشة'], 200);
    }
}
