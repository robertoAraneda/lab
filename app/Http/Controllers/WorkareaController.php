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
        $workareas = Workarea::orderBy('description')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->with('section')
            ->with('chief_user')
            ->get();

        return response()->json([
            'workareas' => $workareas
        ], 200);
    }

    public function store(Request $request)
    {
        $workarea = new Workarea();
        $workarea->description = $request->description;
        $workarea->state_id = $request->state_id;
        $workarea->created_user_id = auth()->id();
        $workarea->section_id = $request->section_id;
        $workarea->chief_user_id = $request->chief_user_id;
        $workarea->save();

        $workarea = Workarea::whereId($workarea->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->with('section')
            ->with('chief_user')
            ->first();

        return response()->json([
            'workarea' => $workarea
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();
        $sectionController = new SectionController();

        $workarea = Workarea::find($id);
        $workarea->state_id = $stateController->show($workarea->state_id);
        $workarea->section_id = $sectionController->show($workarea->section_id);
        $workarea->chief_user_id = User::find($workarea->chief_user_id);


        return $workarea;
    }

    public function update(Request $request, $id)
    {
        $workarea = Workarea::find($id);
        $workarea->description = $request->description;
        $workarea->state_id = $request->state_id;
        $workarea->updated_user_id = auth()->id();
        $workarea->section_id = $request->section_id;
        $workarea->chief_user_id = $request->chief_user_id;

        $workarea->save();
        $workarea = Workarea::whereId($workarea->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->with('section')
            ->with('chief_user')
            ->first();

        return response()->json([
            'workarea' => $workarea
        ], 200);

    }

    public function destroy($id)
    {
        $workarea = Workarea::find($id);
        $workarea->delete();

        return response()->json([
            'workarea' => $workarea
        ], 200);
    }
}
