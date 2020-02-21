<?php

namespace App\Http\Controllers;

use App\Section;
use App\State;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page(){

        return view('admin.section');
    }


    public function index(Request $request)
    {
        $section = Section::orderBy('description')
            ->with('state_id')
            ->get();

        return $section;

    }
    public function store(Request $request)
    {
        $section = new Section();
        $section->description = $request->description;
        $section->state_id = $request->state_id;
        $section->created_user_id = auth()->id();
        $section->save();
        return $section;
    }
    public function show($id)
    {
        $section = Section::find($id);
        $section['state_id'] = State::find($section->state_id);
        return $section;

    }

    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        $section->description = $request->description;
        $section->state_id = $request->state_id;
        $section->updated_user_id = auth()->id();

        $section->save();
        return $section;
    }

    public function destroy($id)
    {
        $section = Section::find($id);
        $section->delete();

        return $section;
    }
}
