<?php

namespace App\Http\Controllers\ControllerStore;

use App\Http\Controllers\Controller;
use App\ModelStore\Ubication;
use Illuminate\Http\Request;

class ubicationController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('store.ubication');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $ubications = Ubication::orderBy('id')->where('isActive', '1')
      ->with('state')
      ->with('createdUser')
      ->with('updatedUser')
      ->get();

    return response()->json([
      'ubications' => $ubications
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(
    Ubication $ubication,
    Request $request
  ) {
    $ubication->description = $request->description;
    $ubication->state_id = $request->state_id;
    $ubication->created_user_id = auth()->id();
    $ubication->updated_user_id = auth()->id();
    $ubication->created_user_ip = $request->ip();
    $ubication->updated_user_ip = $request->ip();

    $ubication->save();

    $ubication = $this->show($ubication->id);

    return response()->json([
      'ubication' => $ubication
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
    return Ubication::whereId($id)
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
    $ubication = Ubication::whereId($id)->first();
    $ubication->description = $request->description;
    $ubication->state_id = $request->state_id;

    $ubication->updated_user_id = auth()->id();

    $ubication->updated_user_ip = $request->ip();

    $ubication->save();

    $ubication = $this->show($ubication->id);

    return response()->json([
      'ubication' => $ubication
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $ubication = Ubication::whereId($id)->first();


    $ubication->isActive = 0;
    $ubication->save();

    return response()->json([
      'ubication' => $ubication
    ], 200);
  }
}
