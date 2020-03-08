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
            ->with('createdUser')
            ->with('updatedUser')
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

        $timeResponse = $this->show($timeResponse->id);

        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);
    }

    public function show($id)
    {
        return TimeResponse::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();

    }

    public function update(
        Request $request,
        $id
    )
    {
        $timeResponse = TimeResponse::whereId($id)->first();
        $timeResponse->description = $request->description;
        $timeResponse->state_id = $request->state_id;
        $timeResponse->updated_user_id = auth()->id();

        $timeResponse->save();

        $timeResponse = $this->show($timeResponse->id);

        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);
    }

    public function destroy($id)
    {
        $timeResponse = TimeResponse::whereId($id)->first();
        $timeResponse->delete();

        return response()->json([
            'timeResponse' => $timeResponse
        ], 200);
    }
}
