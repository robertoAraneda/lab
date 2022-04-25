<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.user');
    }

    public function index()
    {
        $users = User::orderBy('id')
            ->get();

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->email;
        $user->email = $request->email;
        $user->save();
        return $user;
    }

    public function show($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::whereId($id)->first();
        $user->password = Hash::make($request->password);
        $user->updated_user_id = auth()->id();

        $user->save();

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function destroy($id)
    {
        //
    }
}
