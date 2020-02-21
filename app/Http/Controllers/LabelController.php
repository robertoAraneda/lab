<?php

namespace App\Http\Controllers;

use App\Label;
use App\User;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.label');
    }

    public function index()
    {
        $labels = Label::orderBy('id')->get()
        ->map(function ($label){
            $stateController = new StateController();

            $label->state_id= $stateController->show($label->state_id);
            $label->state_id->created_user_id = User::find($label->state_id->created_user_id);

            return $label;
        });

        return $labels;
    }

    public function store(
        Label $label,
        StateController $stateController,
        Request $request)
    {
        $label->description = $request->description;
        $label->code = $request->code;
        $label->state_id = $request->state_id;
        $label->created_user_id = auth()->id();

        $label->save();

        $label['state_id'] = $stateController->show($label->state_id);

        return $label;


    }

    public function show($id)
    {

        $stateController = new StateController();

        $label = Label::find($id);
        $label['state_id'] = $stateController->show($label['state_id']);

        return $label;
    }

    public function update(
        StateController $stateController,
        Request $request,
        $id)
    {
        $label = Label::find($id);
        $label->description = $request->description;
        $label->code = $request->description;
        $label->state_id = $request->state_id;
        $label->updated_user_id = auth()->id();

        $label->save();

        $label['state_id'] = $stateController->show($label->state_id);

        return $label;
    }

    public function destroy($id)
    {
        $label = Label::find($id);
        $label->delete();

        return $label;
    }
}
