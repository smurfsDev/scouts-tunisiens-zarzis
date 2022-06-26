<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request){
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $role = Role::find($request->role);
        if($request->troupe){
            $user->roless()->attach($role,['troupe_id'=>$request->troupe]);
        }else{
            $user->roless()->attach($role);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'User created',
            'data'      => $user
        ]);

    }

    public function login(LoginRequest $request){
        $input = $request->all();
        if (!Auth::attempt($input)) {
            return response()->json([
                'success'   => false,
                'message'   => 'المعلومات المدخلة غير صحيحة',
                'data'      => []
            ],401);
        }

        return response()->json([
            'success'   => true,
            'token'     => Auth::user()->createToken('token')->plainTextToken,
            'user'      => Auth::user(),
            'roles'     => $this->getRoles(Auth::user()->id)
        ],200);
    }

    public function unique($field){
        $user = User::where('email', $field)->first();
        $user1 = User::where('cin', $field)->first();
        if($user || $user1){
            return response()->json([
                'success'   => false,
                'message'   => 'User already exists',
                'data'      => []
            ],201);
        }else{
            return response()->json([
                'success'   => true,
                'message'   => 'User not exists',
                'data'      => []
            ]);
        }

    }
    public function getRoles($id){
        $user = User::with('roless')->find($id);
        $roles=[];
        if($user->roless->contains('name','superAdmin')){
            array_push($roles,'superAdmin');
        }
        if ($user->roless->contains('ename','Leadership')) {
            array_push($roles,'leadership');
        }
        if ($user->roless->contains('ename','Unit Leader')) {
            array_push($roles,'unitLeader');
        }
        if ($user->roless->contains('ename','Member')) {
            array_push($roles,'member');
        }
        if ($user->roless->contains('ename','Unit Sub Leader')) {
            array_push($roles,'unitSubLeader');
        }
        if ($user->roless->contains('ename','Unit Assigned Leader')) {
            array_push($roles,'unitAssignedLeader');
        }
        if ($user->roless->contains('ename','Parent')) {
            array_push($roles,'parent');
        }
        return $roles;
    }

}
