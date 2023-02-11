<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class ManageEventSuperAdmin extends Controller
{

    public function getEventDemander(Request $request){
        if(isset($request->search)){
            $event=Event::where('etat',0)->where('titre','like','%'.$request->search.'%')->with('user')->paginate(3);
        }else{
            $event=Event::where('etat',0)->with('user')->paginate(3);
        }
        return response()->json(['data'=>$event],200);
    }

    public function getEventAccepter(Request $request){
        if(isset($request->search)){
            $event=Event::where('etat',1)->where('titre','like','%'.$request->search.'%')->with('user')->paginate(3);
        }else{
            $event=Event::where('etat',1)->with('user')->paginate(3);
        }
        return response()->json(['data'=>$event],200);
    }

    public function getEventrejeter(Request $request){
        if(isset($request->search)){
            $event=Event::where('etat',2)->where('titre','like','%'.$request->search.'%')->with('user')->paginate(3);
        }else{
            $event=Event::where('etat',2)->with('user')->paginate(3);
        }
        return response()->json(['data'=>$event],200);
    }

    public function AccpeterEvent(Request $request,int $id){
        $event=Event::find($id);
        if($event){
            $event->update([
                'etat'=>1,
                'admin_id'=>$request->user()->id,
                'state_changed_at'=>date('Y-m-d')
            ]);
        }else{
            return response(['message'=>"Not found"],404);
        }
    }

    public function RejeterEvent(Request $request,int $id){
        $event=Event::find($id);
        if($event){
            $event->update([
                'etat'=>2,
                'admin_id'=>$request->user()->id,
                'state_changed_at'=>date('Y-m-d')
            ]);
        }else{
            return response(['message'=>"Not found"],404);
        }
    }

    public function deleteEvent($id){
        $event=Event::find($id);
        if($event){
            $event->delete();
            return response(['message'=>"delete succes"],200);
        }else{
            return response(['message'=>"Not found"],404);
        }
    }
}
