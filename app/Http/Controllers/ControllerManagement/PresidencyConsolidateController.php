<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\ModelManagement\PresidencyConsolidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresidencyConsolidateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return PresidencyConsolidate::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(PresidencyConsolidate $presidencyConsolidate, MailController $mailController, Request $request)
  {
    //id, current_date, initial_date, last_date, processing_laboratory, corte, current_stock, received, notified, final_stock, positive, sum_notified, sum_positive, created_user_id, updated_user_id, created_ip, updated_ip, created_at, updated_at

    try {
      $date = Carbon::now();
      $subday = Carbon::now()->subDay();

      $find = PresidencyConsolidate::where('current_date', $date->format('Y-m-d'))->first();

      if (!isset($find)) {
        $presidencyConsolidate->current_date = $date->format('Y-m-d');
        $presidencyConsolidate->initial_date = $subday->format('Y-m-d') . " 16:00";
        $presidencyConsolidate->last_date = $date->format('Y-m-d') . " 15:59";
        $presidencyConsolidate->corte = "16:00";
        $presidencyConsolidate->current_stock = $request->currentStock;
        $presidencyConsolidate->received = $request->received;
        $presidencyConsolidate->notified = $request->notified;
        $presidencyConsolidate->final_stock = $request->finalStock;
        $presidencyConsolidate->positive = $request->positive;
        $presidencyConsolidate->sum_notified = $request->totalNotified;
        $presidencyConsolidate->sum_positive = $request->totalPositive;
        $presidencyConsolidate->maximum_capacity = $request->maximum_capacity;
        $presidencyConsolidate->observations = $request->observations;
        $presidencyConsolidate->created_user_id = auth()->id();
        $presidencyConsolidate->created_ip = $request->ip();

        $presidencyConsolidate->save();
      } else {

        $find->current_date = $date->format('Y-m-d');
        $find->initial_date = $subday->format('Y-m-d') . " 16:00";
        $find->last_date = $date->format('Y-m-d') . " 15:59";
        $find->corte = "16:00";
        $find->current_stock = $request->currentStock;
        $find->received = $request->received;
        $find->notified = $request->notified;
        $find->final_stock = $request->finalStock;
        $find->positive = $request->positive;
        $find->sum_notified = $request->totalNotified;
        $find->sum_positive = $request->totalPositive;
        $find->maximum_capacity = $request->maximum_capacity;
        $find->observations = $request->observations;
        $find->updated_user_id = auth()->id();
        $find->updated_ip = $request->ip();
        $find->save();
      }

      $find = PresidencyConsolidate::where('current_date', $date->format('Y-m-d'))->first();

      $mailController->covid_mail($find);

      return response()->json(['status' => true], 200);
    } catch (\Exception $e) {

      return response()->json(['status' => false, "error" => $e->getMessage()], 200);
    }
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
