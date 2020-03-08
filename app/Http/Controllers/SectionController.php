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
        $sections = Section::orderBy('id')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('workareas')
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

        $section = $this->show($section->id);

        return response()->json([
            'section' => $section
        ], 200);
    }
    public function show($id)
    {
        return Section::whereId($id)
            ->with('createdUser')
            ->with('updatedUser')
            ->with('workareas')
            ->with('state')
            ->first();
    }

    public function update(Request $request, $id)
    {
        $section = Section::whereId($id)->first();
        $section->description = $request->description;
        $section->state_id = $request->state_id;
        $section->updated_user_id = auth()->id();

        $section->save();

        $section = $this->show($section->id);

        return response()->json([
            'section' => $section
        ], 200);
    }

    public function destroy($id)
    {
        $section = Section::whereId($id)->first();
        $section->delete();

         return response()->json([
            'section' => $section
        ], 200);
    }
}
