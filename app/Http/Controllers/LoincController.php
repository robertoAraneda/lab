<?php

namespace App\Http\Controllers;

use App\Loinc;
use Illuminate\Http\Request;

class LoincController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.loinc');
    }

    public function index()
    {

    }

    public function fetch(Request $request)
    {
        $columns = ['id', 'loinc_num', 'system_', 'long_common_name', 'example_units'];
        $total_data = Loinc::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))
        {
            $post = Loinc::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $total_filtered = Loinc::count();

        } else {
            $search = $request->input('search.value');

            $post = Loinc::where('loinc_num', 'like', "%{$search}%")
                ->orWhere('system_', 'like', "%{$search}%")
                ->orWhere('long_common_name', 'like', "%{$search}%")
                ->orWhere('example_units', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $total_filtered = Loinc::where('loinc_num', 'like', "%{$search}%")
                ->orWhere('system_', 'like', "%{$search}%")
                ->orWhere('long_common_name', 'like', "%{$search}%")
                ->orWhere('example_units', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($post)) {
            foreach ($post as $row) {
                $nest['id'] = $row->id;
                $nest['loinc_num'] = '<a href="https://loinc.org/' . $row->loinc_num . '" target="_blank">' . $row->loinc_num . '</a>';
                $nest['system_'] = $row->system_;
                $nest['long_common_name'] = $row->long_common_name;
                $nest['example_units'] = $row->example_units;

                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_filtered),
            'data' => $data

        );

        echo json_encode($json);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $loinc = Loinc::find($id);
        return $loinc;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function findByCode($loinc_code){
        $loinc = Loinc::where('loinc_num',"$loinc_code")->first();

        return $loinc;
    }
}
