<?php

namespace App\Http\Controllers;

use App\Models\OfficialRequest;
use Illuminate\Http\Request;

class OfficialRequestController extends Controller
{
    public function create(Request $request){
        $userId = $request->user()->id;
        $object = $request->input('object');
        $receiver = $request->input('receiver');
        $content = $request->input('content');
        $data = array(
            "object"=> $object,
            "user_id"=> $userId,
            "idDestinataire"=> $userId,
            "receiver"=> $receiver,
            "content"=> $content,
        );
        $OfficialRequest = OfficialRequest::create($data);
        if ($OfficialRequest) {
            return response()->json([
                'data' => [
                    'message' => 'Success',
                    'id' => $OfficialRequest->id,
                    'attributes' => $OfficialRequest
                ]
            ], 201);
        }
        return "Success";
    }
    public function getAll(){
        $OfficialRequest = OfficialRequest::with('user')->orderBy('created_at', 'DESC')
        ->paginate(5);;
        return response()->json(
               $OfficialRequest, 200);
    }

}
