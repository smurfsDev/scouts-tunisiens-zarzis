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
            'organisateur_id' => $request->user()->id,
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
    
    public function update (Request $request, $id){
        $event = Event::find($id);
        if (!$event) {
            return response()->json([
                "message" => "تظاهرة غير موجودة"
            ], 404);
        }
      
        $event->name = $request->input('name');
        $event->date_debut = $request->input("date_debut");
        $event->date_debut = $request->input("date_debut");
        $event->type = $request->input("type");
        $event->save(); 
        return response()->json(["data" => $event], 200);
    }

    public function destroy($id){
        $event = Event::find($id);
        if (!$event) {
            return response()->json([
                'message' => 'تظاهرة غير موجودة'
            ], 404);
        }
        $event->delete();
        return response()->json(['message' => 'لقد تم حذف التظاهرة'], 200);
    }

    public function getMyDemandes(Request $request){
        $events = Event::where('organisateur_id', $request->user()->id)->orderBy('created_at','DESC')->paginate(5);
        if (!$events){
            return response()->json(['message' => 'لا يوجد تظاهرات'], 404);
        }
        return response()->json(["data" => $events], 200);

    }
}
