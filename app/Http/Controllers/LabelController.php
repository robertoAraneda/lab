<?php

namespace App\Http\Controllers;

use App\Label;
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
        $labels = Label::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'labels' => $labels
        ], 200);
    }

    public function store(
        Label $label,
        Request $request
    ) {
        $label->description = $request->description;
        $label->code = $request->code;
        $label->state_id = $request->state_id;
        $label->created_user_id = auth()->id();

        $label->save();

        $label = $this->show($label->id);

        return response()->json([
            'label' => $label
        ], 200);
    }

    public function show($id)
    {
        return Label::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $label = Label::whereId($id)->first();
        $label->description = $request->description;
        $label->code = $request->description;
        $label->state_id = $request->state_id;
        $label->updated_user_id = auth()->id();

        $label->save();

        $label = $this->show($label->id);

        return response()->json([
            'label' => $label
        ], 200);
    }

    public function destroy($id)
    {
        $label = Label::whereId($id)->first();
        $label->delete();

        return response()->json([
            'label' => $label
        ], 200);
    }
}
