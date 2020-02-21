<?php

namespace App\Http\Controllers;

use App\MainAnalyte;
use Illuminate\Http\Request;

class MainAnalyteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.mainAnalyte');
    }

    public function index()
    {
        $mainAnalyte = MainAnalyte::orderBy('id')->with('state_id')->get();

        return $mainAnalyte;
    }

    public function store(
        MainAnalyte $mainAnalyte,
        StateController $stateController,
        Request $request)

    {
        $mainAnalyte->description = $request->description;
        $mainAnalyte->information = $request->information;
        $mainAnalyte->state_id = $request->state_id;
        $mainAnalyte->created_user_id = auth()->id();

        $mainAnalyte->save();

        $mainAnalyte['state_id'] = $stateController->show($mainAnalyte->state_id);

        return $mainAnalyte;
    }

    public function show(
        StateController $stateController,
        $id)
    {
        $mainAnalyte = MainAnalyte::find($id);
        $mainAnalyte['state_id'] = $stateController->show($mainAnalyte->state_id);

        return $mainAnalyte;
    }

    public function update(
        StateController $stateController,
        Request $request,
        $id)
    {
        $mainAnalyte = MainAnalyte::find($id);
        $mainAnalyte->description = $request->description;
        $mainAnalyte->information = $request->information;
        $mainAnalyte->state_id = $request->state_id;
        $mainAnalyte->updated_user_id = auth()->id();

        $mainAnalyte->save();

        $mainAnalyte['state_id'] = $stateController->show($mainAnalyte->state_id);

        return $mainAnalyte;

    }

    public function destroy($id)
    {
        $mainAnalyte = MainAnalyte::find($id);
        $mainAnalyte->delete();

        return $mainAnalyte;
    }
}
