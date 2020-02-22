<?php

namespace App\Http\Controllers;

use App\Section;
use App\State;
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
        $workarea = Workarea::orderBy('description')
            ->with('state_id')
            ->with('created_user_id')
            ->with('updated_user_id')
            ->with('section_id')
            ->with('chief_user_id')
            ->get();

        return $workarea;
    }

    public function store(
        SectionController $sectionController,
        StateController $stateController,
        UserController $userController,
        Request $request)
    {
        $workarea = new Workarea();
        $workarea->description = $request->description;
        $workarea->state_id = $request->state_id;
        $workarea->created_user_id = auth()->id();
        $workarea->section_id = $request->section_id;
        $workarea->chief_user_id = $request->chief_user_id;
        $workarea->save();

        $workarea['state_id'] = $stateController->show($workarea->state_id);
        $workarea['section_id'] = $sectionController->show($workarea->section_id);
        $workarea['chief_user_id'] = $userController->show($workarea->chief_user_id);
        $workarea['created_user_id'] = $userController->show($workarea->created_user_id);

        return $workarea;

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

    public function update(
        SectionController $sectionController,
        StateController $stateController,
        UserController $userController,
        Request $request, $id)
    {
        $workarea = Workarea::find($id);
        $workarea->description = $request->description;
        $workarea->state_id = $request->state_id;
        $workarea->updated_user_id = auth()->id();
        $workarea->section_id = $request->section_id;
        $workarea->chief_user_id = $request->chief_user_id;


        $workarea->save();

        $workarea['state_id'] = $stateController->show($workarea->state_id);
        $workarea['section_id'] = $sectionController->show($workarea->section_id);
        $workarea['chief_user_id'] = $userController->show($workarea->chief_user_id);
        $workarea['created_user_id'] = $userController->show($workarea->created_user_id);

        return $workarea;

    }

    public function destroy($id)
    {
        $workarea = Workarea::find($id);
        $workarea->delete();

        return $workarea;
    }
}
