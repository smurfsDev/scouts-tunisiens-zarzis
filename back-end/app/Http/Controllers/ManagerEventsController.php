<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestEvent;
use App\Models\Event;
use Illuminate\Http\Request;

class ManagerEventsController extends Controller
{

    public function addevent(RequestEvent $request){
        $event=new Event();
        $event->titre=$request->titre;
        $event->description=$request->description;
        $event->location=$request->location;
        $event->date_debut=$request->date_debut;
        $event->date_fin=$request->date_fin;
        $event->user_id=$request->user()->id;
        $event->admin_id=null;
        $event->etat=0;
        $event->state_changed_at=date('Y-m-d');
        $event->save();
        return response()->json(['data'=>$event],200);
    }

    public function getEventbyIdUser(request $request){
        if(isset($request->search)){
            $all_events=event::where('user_id',$request->user()->id)->where('titre','like','%'.$request->search.'%')->paginate(3);
        }else{
            $all_events=event::where('user_id',$request->user()->id)->paginate(3);
        }
        return response()->json(['data'=>$all_events],200);
    }

    public function deleteEvenet(int $id){
        $event=event::find($id);
        if($event){
            $event->delete();
            return response(['message'=>"delete succes"],200);
        }else{
            return response(['message'=>"Not found"],404);
        }
    }

    public function UpdateEvent(int $id,RequestEvent $request){
        $event=event::find($id);
        if($event){
            $event->update([
                'titre'=>$request->titre,
                'description'=>$request->description,
                'location'=>$request->location,
                'date_debut'=>$request->date_debut,
                'date_fin'=>$request->date_fin
            ]);
        }else{
            return response(['message'=>"Not found"],404);
        }
    }

    public function getEventById(int $id){
        $event=event::find($id);
        if($event){
            return response()->json(['data'=>$event],200);
        }else{
            return response(['message'=>"Not found"],404);
        }
    }

}
