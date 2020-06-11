<?php

namespace App\Http\Controllers\ControllerStore;

use App\Http\Controllers\Controller;
use App\ModelStore\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('store.category');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = Category::orderBy('id')->where('isActive', '1')
      ->with('state')
      ->with('createdUser')
      ->with('updatedUser')
      ->get();

    return response()->json([
      'categories' => $categories
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(
    Category $category,
    Request $request
  ) {
    $category->description = $request->description;
    $category->state_id = $request->state_id;
    $category->created_user_id = auth()->id();
    $category->updated_user_id = auth()->id();
    $category->created_user_ip = $request->ip();
    $category->updated_user_ip = $request->ip();

    $category->save();

    $category = $this->show($category->id);

    return response()->json([
      'category' => $category
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
    return Category::whereId($id)
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
    $category = Category::whereId($id)->first();
    $category->description = $request->description;
    $category->state_id = $request->state_id;

    $category->updated_user_id = auth()->id();

    $category->updated_user_ip = $request->ip();

    $category->save();

    $category = $this->show($category->id);

    return response()->json([
      'category' => $category
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
    $category = Category::whereId($id)->first();


    $category->isActive = 0;
    $category->save();

    return response()->json([
      'category' => $category
    ], 200);
  }
}
