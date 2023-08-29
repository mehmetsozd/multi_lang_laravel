<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminUserController extends Controller
{

    public function searchUsers(Request $request){
        $search = $request->search;
        if($search == ''){
            $users = User::orderby('name','asc')->select('id','name')->limit(5)->get();
        }else{
            $users = User::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }
        $response = array();
        foreach($users as $user){
            $response[] = array("id"=>$user->id,"text"=>$user->name);
        }
        return response()->json($response);
    }
    public function users(Request $request){
        $users = User::query();
        return Datatables::of($users)->toJson();
    }

    public function updateAdmin(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'is_admin' => 'required|string|in:0,1',
        ]);
        $user = User::find($request->user_id);
        $user->is_admin = $request->is_admin;
        $user->save();
        return response()->json(['message' => 'User updated successfully']);
    }

}
