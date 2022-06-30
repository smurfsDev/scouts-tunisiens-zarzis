<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateProfileController extends Controller
{
    public function updateImage(Request $request)
    {
        $user = $request->user();
        $user->image = $request->image;
        $user->save();
        return response()->json([
            'message' => 'Image updated successfully'
        ]);
    }
}
