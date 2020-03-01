<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TimeResponse;
use Illuminate\Http\Request;

class TimeResponseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.timeResponse');
    }

    public function index()
    {
        $timeResponses = TimeResponse::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();


        return response()->json([
            'timeResponses' => $timeResponses
        ], 200);
    }

    public function store(
        TimeResponse $timeResponse,
        Request $request
    )
    {
        $timeResponse->description = $request->description;
        $timeResponse->state_id = $request->state_id;
        $timeResponse->created_user_id = auth()->id();
        $timeResponse->save();

        $timeResponse = TimeResponse::whereId($timeResponse->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);
    }

    public function show($id)
    {
        $timeResponse = TimeResponse::find($id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return $timeResponse;
    }

    public function update(
        Request $request,
        $id
    )
    {
        $timeResponse = TimeResponse::find($id);
        $timeResponse->description = $request->description;
        $timeResponse->state_id = $request->state_id;
        $timeResponse->updated_user_id = auth()->id();

        $timeResponse->save();

        $timeResponse = TimeResponse::whereId($timeResponse->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);


        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);
    }

    public function destroy($id)
    {
        $timeResponse = TimeResponse::find($id);
        $timeResponse->delete();

        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);
    }
}
