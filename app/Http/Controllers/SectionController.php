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

    public function page()
    {

        return view('admin.section');
    }


    public function index(Request $request)
    {
        $sections = Section::orderBy('description')
            ->with('state')
            ->get();

        return response()->json([
            'sections' => $sections
        ], 200);
    }
    public function store(Request $request)
    {
        $section = new Section();
        $section->description = $request->description;
        $section->state_id = $request->state_id;
        $section->created_user_id = auth()->id();
        $section->save();

        $section = Section::whereId($section->id)
        ->with('state')
        ->first();

        return response()->json([
            'section' => $section
        ], 200);
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

        $section = Section::whereId($section->id)
        ->with('state')
        ->first();

        return response()->json([
            'section' => $section
        ], 200);
    }

    public function destroy($id)
    {
        $section = Section::find($id);
        $section->delete();

         return response()->json([
            'section' => $section
        ], 200);
    }
}
