<?php

namespace App\Http\Controllers;

use App\ReferenceRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferenceRangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.referenceRange');
    }

    public function index()
    {
        $referenceRanges = ReferenceRange::orderBy('id')
            ->with('test.unit')
            ->with('age_unit')
            ->with('state')
            ->with('gender')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'referenceRanges' => $referenceRanges
        ], 200);
    }

    public function store(
        ReferenceRange $referenceRange,
        Request $request
    ) {

        $referenceRange->test_id = $request->test_id;
        $referenceRange->age_unit_id = $request->age_unit_id;
        $referenceRange->state_id = $request->state_id;
        $referenceRange->gender_id = $request->gender_id;
        $referenceRange->normal_minimum = $request->normal_minimum;
        $referenceRange->normal_maximum = $request->normal_maximum;
        $referenceRange->critical_minimum = $request->critical_minimum;
        $referenceRange->critical_maximum = $request->critical_maximum;
        $referenceRange->age_start = $request->age_start;
        $referenceRange->age_end = $request->age_end;
        $referenceRange->interpretation = $request->interpretation;
        $referenceRange->type_value = $request->type_value;

        $referenceRange->cualitative_value = $request->cualitative_value;
        $referenceRange->created_user_id = auth()->id();

        $referenceRange->save();

        $referenceRange = ReferenceRange::whereId($referenceRange->id)
            ->with('test.unit')
            ->with('state')
            ->with('age_unit')
            ->with('gender')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'referenceRange' => $referenceRange, 'request' => $request
        ], 200);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $referenceRange = ReferenceRange::whereId($id)->first();
        $referenceRange->age_unit_id = $request->age_unit_id;
        $referenceRange->state_id = $request->state_id;
        $referenceRange->gender_id = $request->gender_id;
        $referenceRange->normal_minimum = $request->normal_minimum;
        $referenceRange->normal_maximum = $request->normal_maximum;
        $referenceRange->critical_minimum = $request->critical_minimum;
        $referenceRange->critical_maximum = $request->critical_maximum;
        $referenceRange->age_start = $request->age_start;
        $referenceRange->age_end = $request->age_end;
        $referenceRange->interpretation = $request->interpretation;
        $referenceRange->type_value = $request->type_value;

        $referenceRange->cualitative_value = $request->cualitative_value;
        $referenceRange->updated_user_id = auth()->id();

        $referenceRange->save();

        $referenceRange = ReferenceRange::whereId($id)
            ->with('test.unit')
            ->with('state')
            ->with('age_unit')
            ->with('gender')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'referenceRange' => $referenceRange, 'request' => $request
        ], 200);
    }

    public function destroy($id)
    {
        $referenceRange = ReferenceRange::whereId($id)->first();
        $referenceRange->delete();

        return response()->json([
            'referenceRange' => $referenceRange
        ], 200);
    }

    public function findByTest($id)
    {
        $referenceRangesByTest = ReferenceRange::where('test_id', $id)
            ->with('test.unit')
            ->with('state')
            ->with('age_unit')
            ->with('gender')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'referenceRangeByTest' => $referenceRangesByTest
        ], 200);
    }
}
