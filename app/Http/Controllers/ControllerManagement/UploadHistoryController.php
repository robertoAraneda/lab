<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use App\ModelManagement\UploadHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadHistoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response()->json(UploadHistory::latest()->with('createdUser')->first());
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store($data)
  {

    $uploadHistory = new UploadHistory();

    $uploadHistory->file_name = $data['file_name'];
    $uploadHistory->created_user_id = auth()->id();
    $uploadHistory->created_ip = $data['ip'];

    $uploadHistory->save();

    return response()->json(true);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
