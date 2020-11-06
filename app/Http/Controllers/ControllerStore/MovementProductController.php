<?php

namespace App\Http\Controllers\ControllerStore;

use App\Exports\MovementExport;
use App\Http\Controllers\Controller;
use App\ModelStore\MovementProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovementProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('store.movementProducts');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $movementProducts = MovementProduct::orderBy('created_at', 'desc')
      ->with('product')
      ->with('user')
      ->limit(100)
      ->get();

    return response()->json([
      'movementProducts' => $movementProducts
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(
    MovementProduct $movementProduct,
    Request $request
  ) {

    $movementProduct->product_id = $request->product_id;
    $movementProduct->quantity = $request->quantity;
    $movementProduct->movement = $request->movement;
    $movementProduct->user_id = auth()->id();
    $movementProduct->user_ip = $request->ip();

    $movementProduct->save();

    $movementProduct = $this->show($movementProduct->id);

    return response()->json([
      'movementProduct' => $movementProduct
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
    return MovementProduct::whereId($id)
      ->with('product')
      ->with('user')
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

  public function export()
  {
    $date = Carbon::now()->format('d-m-Y');

    $formatDate = explode("-", $date);

    $nameFile = "LISTADO_MOVIMIENTOS_" . $formatDate[0] . "" . $formatDate[1] . "" . $formatDate[2];

    return (new MovementExport())->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
      'Content-Type' => 'application/vnd.ms-excel',
    ]);
  }
}
