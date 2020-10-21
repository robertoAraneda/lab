<?php

namespace App\Http\Controllers\ControllerStore;

use App\Http\Controllers\Controller;
use App\ModelStore\Presentation;
use Illuminate\Http\Request;

class PresentationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('store.presentation');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presentations = Presentation::orderBy('id')->where('isActive', '1')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'presentations' => $presentations
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Presentation $presentation)
    {

        $presentation->description = $request->description;

        $presentation->state_id = $request->state_id;
        $presentation->created_user_id = auth()->id();
        $presentation->created_user_ip = $request->ip();

        $presentation->save();

        $presentation = $this->show($presentation->id);

        return response()->json([
            'presentation' => $presentation
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Presentation::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // return json_encode(isset($request->movement));
        $presentation = Presentation::whereId($id)->first();

        if (isset($presentation)) {

            $presentation->description = $request->description;
            $presentation->state_id = $request->state_id;
            $presentation->updated_user_id = auth()->id();
            $presentation->updated_user_ip = $request->ip();


            $presentation->save();

            $presentation = $this->show($presentation->id);

            return response()->json([
                'presentation' => $presentation
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presentation = Presentation::whereId($id)->first();


        $presentation->isActive = false;
        $presentation->save();
    
        return response()->json([
          'presentation' => $presentation
        ], 200);
    }
}
