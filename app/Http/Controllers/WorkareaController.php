<?php

namespace App\Http\Controllers;

use App\User;
use App\Workarea;
use Illuminate\Http\Request;

class WorkareaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.workarea');
    }

    public function index()
    {
        $workareas = Workarea::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('section')
            ->with('chiefUser')
            ->get();

        return response()->json([
            'workareas' => $workareas
        ], 200);
    }

    public function store(
        Workarea $workarea,
        Request $request)
    {
        $workarea->description = $request->description;
        $workarea->state_id = $request->state_id;
        $workarea->created_user_id = auth()->id();
        $workarea->section_id = $request->section_id;
        $workarea->chief_user_id = $request->chief_user_id;
        $workarea->save();

        $workarea = $this->show($workarea->id);

        return response()->json([
            'workarea' => $workarea
        ], 200);
    }

    public function show($id)
    {
        return Workarea::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('section')
            ->with('chiefUser')
            ->first();
    }

    public function update(Request $request, $id)
    {
        $workarea = Workarea::whereId($id)->first();
        $workarea->description = $request->description;
        $workarea->state_id = $request->state_id;
        $workarea->updated_user_id = auth()->id();
        $workarea->section_id = $request->section_id;
        $workarea->chief_user_id = $request->chief_user_id;

        $workarea->save();

        $workarea = $this->show($workarea->id);

        return response()->json([
            'workarea' => $workarea
        ], 200);

    }

    public function destroy($id)
    {
        $workarea = Workarea::whereId($id)->first();
        $workarea->delete();

        return response()->json([
            'workarea' => $workarea
        ], 200);
    }
}
