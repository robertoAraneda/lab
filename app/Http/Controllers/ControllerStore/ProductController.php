<?php

namespace App\Http\Controllers\ControllerStore;

use App\Http\Controllers\Controller;
use App\ModelStore\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('store.product');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $products = Product::orderBy('id')->where('isActive', '1')
      ->with('state')
      ->with('category')
      ->with('createdUser')
      ->with('updatedUser')
      ->get();

    return response()->json([
      'products' => $products
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(
    Product $product,
    Request $request
  ) {
    $product->code = $request->code;
    $product->description = $request->description;
    $product->stock = $request->stock;
    $product->category_id = $request->category_id;
    $product->state_id = $request->state_id;
    $product->created_user_id = auth()->id();
    $product->updated_user_id = auth()->id();
    $product->created_user_ip = $request->ip();
    $product->updated_user_ip = $request->ip();

    $product->save();

    $product = $this->show($product->id);

    return response()->json([
      'product' => $product
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
    return Product::whereId($id)
      ->with('state')
      ->with('category')
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
    $product = Product::whereId($id)->first();
    if (isset($request->movement)) {

      if ($request->movement == 'ENTRADA') {
        $difStock = $product->stock + $request->stock;
        $product->stock = $difStock;
      } else {
        $difStock = $product->stock - $request->stock;
        $product->stock = $difStock;
      }

      $product->updated_user_id = auth()->id();

      $product->updated_user_ip = $request->ip();
    } else {
      $product->code = $request->code;
      $product->description = $request->description;
      $product->stock = $request->stock;
      $product->category_id = $request->category_id;
      $product->state_id = $request->state_id;
      $product->created_user_id = auth()->id();
      $product->updated_user_id = auth()->id();
      $product->created_user_ip = $request->ip();
      $product->updated_user_ip = $request->ip();
    }

    $product->save();

    $product = $this->show($product->id);

    return response()->json([
      'product' => $product
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
    $product = Product::whereId($id)->first();


    $product->isActive = 0;
    $product->save();

    return response()->json([
      'product' => $product
    ], 200);
  }
}