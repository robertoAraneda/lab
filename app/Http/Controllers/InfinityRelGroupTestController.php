<?php

namespace App\Http\Controllers;

use App\InfinityRelGroupTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfinityRelGroupTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinityRelGroupTest');
    }

    public function index()
    {
        $infinityTestGroup = InfinityRelGroupTest::orderBy('id')
            ->with(['infinityTest', 'infinityGroup', 'state', 'createdUser', 'updatedUser'])
            ->get();

        return response()->json([
            'infinityTestGroup' => $infinityTestGroup
        ], 200);

//        $relGroupTest = DB::table('infinity_rel_group_tests')
//            ->leftJoin('infinity_groups', 'infinity_rel_group_tests.infinity_group_id', '=', 'infinity_groups.id')
//            ->leftJoin('infinity_tests', 'infinity_rel_group_tests.infinity_test_id', '=', 'infinity_tests.id')
//            ->leftJoin('states', 'infinity_rel_group_tests.state_id', '=', 'states.id')
//            ->leftJoin('infinity_supergroups', 'infinity_groups.infinity_supergroup_id', '=', 'infinity_supergroups.id')
//            ->select('infinity_rel_group_tests.id as rel_id',
//                'infinity_groups.id as group_id',
//                'infinity_supergroups.id as sgroup_id',
//                'infinity_groups.description as group_description',
//                'infinity_groups.code as group_code',
//                'infinity_tests.id as test_id',
//                'infinity_tests.description as test_description',
//                'infinity_tests.code as test_code',
//                'states.id as state_id',
//                'states.description as state_description')
//            ->where('infinity_supergroups.id', '2')
//            ->get();
//
//        return $relGroupTest;
    }

//    public function fetch($id)
//    {
//        $relGroupTest = DB::table('infinity_rel_group_tests')
//            ->leftJoin('infinity_groups', 'infinity_rel_group_tests.infinity_group_id', '=', 'infinity_groups.id')
//            ->leftJoin('infinity_tests', 'infinity_rel_group_tests.infinity_test_id', '=', 'infinity_tests.id')
//            ->leftJoin('states', 'infinity_rel_group_tests.state_id', '=', 'states.id')
//            ->leftJoin('infinity_supergroups', 'infinity_groups.infinity_supergroup_id', '=', 'infinity_supergroups.id')
//            ->select('infinity_rel_group_tests.id as rel_id',
//                'infinity_groups.id as group_id',
//                'infinity_supergroups.id as sgroup_id',
//                'infinity_groups.description as group_description',
//                'infinity_groups.code as group_code',
//                'infinity_tests.id as test_id',
//                'infinity_tests.description as test_description',
//                'infinity_tests.code as test_code',
//                'states.id as state_id',
//                'states.description as state_description')
//            ->where('infinity_supergroups.id', $id)
//            ->get();
//
//        $data = array();
//        foreach ($relGroupTest as $item) {
//            $itemFetch['rel_id'] = $item->rel_id;
//            $itemFetch['group_id'] = $item->group_id;
//            $itemFetch['group_code'] = $item->group_code;
//            $itemFetch['group_description'] = $item->group_description;
//            $itemFetch['test_id'] = $item->test_id;
//            $itemFetch['test_code'] = $item->test_code;
//            $itemFetch['test_description'] = $item->test_description;
//            $itemFetch['state_option'] = $item->state_id == 1 ? "<span class='badge badge-success'>{$item->state_description}</span>" : "<span class='badge badge-danger'>{$item->state_description}</span>";
//            $itemFetch['options'] = "<td class=\"text-center py-1 align-middle\">
//                            <div class='btn-group btn-group-sm'>
//                                <a class='btn btn-info mx-1 text-white'><i class='fas fa-eye'></i></a>
//                                <a href='{$item->rel_id}' class='btn edit btn-warning mx-1'><i
//                                    class='fas fa-pencil-alt'></i></a>
//                                <a class='btn btn-danger mx-1 text-white' @click='destroy({$item->rel_id}, {$item->rel_id})'><i
//                                    class='fas fa-trash'></i></a>
//                            </div>
//                        </td>";
//
//            $data[] = $itemFetch;
//        }
//
//        echo json_encode($data);
//    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
       $infinityTestGroup = InfinityRelGroupTest::whereId($id)
           ->with(['infinityTest', 'infinityGroup', 'state', 'createdUser', 'updatedUser'])
           ->first();

       return response()->json([
           'infinityTestGroup' => $infinityTestGroup
       ], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
