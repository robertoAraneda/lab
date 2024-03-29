<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use App\ModelManagement\MinsalStatistic;
use App\ModelManagement\PresidencyConsolidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsCovidController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('management.statisticsCovid');
  }

  public function agregateData()
  {



    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $currentDate_ = Carbon::now()->format('d-m-Y');
    $subDay_ = Carbon::now()->subDay()->format('d-m-Y');
    $sub2Days_ = Carbon::now()->subDays(2)->format('d-m-Y');
    $sub3Days_ = Carbon::now()->subDays(3)->format('d-m-Y');
    $sub4Days_ = Carbon::now()->subDays(4)->format('d-m-Y');
    $sub5Days_ = Carbon::now()->subDays(5)->format('d-m-Y');

    $limitDateUp = "{$currentDate} 18:59";
    $limitDateDown = "{$subDay} 19:00";
    $limitDate2Down = "{$sub2Days} 19:00";
    $limitDate3Down = "{$sub3Days} 19:00";
    $limitDate4Down = "{$sub4Days} 19:00";
    $limitDate5Down = "{$sub5Days} 19:00";

    //sin resultados ultimas 120 horas
    $nullResult120 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', null)
      ->whereBetween('received_at', [$limitDate5Down, "{$sub4Days} 18:59"])
      ->count();

    $nullResult96 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', null)
      ->whereBetween('received_at', [$limitDate4Down, "{$sub3Days} 18:59"])
      ->count();

    $nullResult72 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', null)
      ->whereBetween('received_at', [$limitDate3Down, "{$sub2Days} 18:59"])
      ->count();

    $nullResult48 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', null)
      ->whereBetween('received_at', [$limitDate2Down, "{$subDay} 18:59"])
      ->count();

    $nullResult24 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', null)
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $nullResultTotal = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', null)
      ->whereBetween('received_at', [$limitDate3Down, $limitDateUp])
      ->count();

    //positivos ultimas 120 horas
    $positiveResult120 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$limitDate5Down, "{$sub4Days} 18:59"])
      ->count();

    $positiveResult96 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$limitDate4Down, "{$sub3Days} 18:59"])
      ->count();

    $positiveResult72 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$limitDate3Down, "{$sub2Days} 18:59"])
      ->count();

    $positiveResult48 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$limitDate2Down, "{$subDay} 18:59"])
      ->count();

    $positiveResult24 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $positiveResultTotal = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$limitDate3Down, $limitDateUp])
      ->count();


    //negativos ultimas 72 horas
    $negativeResult120 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate5Down, "{$sub4Days} 18:59"])
      ->count();

    $negativeResult96 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate4Down, "{$sub3Days} 18:59"])
      ->count();

    $negativeResult72 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate3Down, "{$sub2Days} 18:59"])
      ->count();

    $negativeResult48 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate2Down, "{$subDay} 18:59"])
      ->count();

    $negativeResult24 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $negativeResultTotal = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate3Down, $limitDateUp])
      ->count();

    //rechazadas ultimas 72 horas
    $rejectResult120 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
      ->whereBetween('received_at', [$limitDate5Down, "{$sub4Days} 18:59"])
      ->count();

    $rejectResult96 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
      ->whereBetween('received_at', [$limitDate4Down, "{$sub3Days} 18:59"])
      ->count();

    $rejectResult72 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
      ->whereBetween('received_at', [$limitDate3Down, "{$sub2Days} 18:59"])
      ->count();

    $rejectResult48 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
      ->whereBetween('received_at', [$limitDate2Down, "{$subDay} 18:59"])
      ->count();

    $rejectResult24 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $rejectResultTotal = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where('result', 'MUESTRA RECHAZADA SE SOLICITA NUEVA MUESTRA.')
      ->whereBetween('received_at', [$limitDate3Down, $limitDateUp])
      ->count();


    //analisis de avance ultimas 72 horas
    $received120 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->whereBetween('received_at', [$limitDate5Down, "{$sub4Days} 18:59"])
      ->count();

    $received96 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->whereBetween('received_at', [$limitDate4Down, "{$sub3Days} 18:59"])
      ->count();

    $received72 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->whereBetween('received_at', [$limitDate3Down, "{$sub2Days} 18:59"])
      ->count();

    $received48 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->whereBetween('received_at', [$limitDate2Down, "{$subDay} 18:59"])
      ->count();

    $received24 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $percent120 = round((($received120 - $nullResult120) / $received120) * 100) . "%";

    $percent96 = round((($received96 - $nullResult96) / $received96) * 100) . "%";
    $percent72 = round((($received72 - $nullResult72) / $received72) * 100) . "%";
    $percent48 = round((($received48 - $nullResult48) / $received48) * 100) . "%";
    $percent24 = round((($received24 - $nullResult24) / $received24) * 100) . "%";

    //by lab

    $countByLabNegativeTotal = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate5Down, $limitDateUp])
      ->groupBy('processing_laboratory')
      ->get();

    $countByLabNegative120 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate5Down, "{$sub4Days} 18:59"])
      ->groupBy('processing_laboratory')
      ->get();

    $countByLabNegative96 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate4Down, "{$sub3Days} 18:59"])
      ->groupBy('processing_laboratory')
      ->get();

    $countByLabNegative72 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate3Down, "{$sub2Days} 18:59"])
      ->groupBy('processing_laboratory')
      ->get();


    $countByLabNegative48 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDate2Down, "{$subDay} 18:59"])
      ->groupBy('processing_laboratory')
      ->get();

    $countByLabNegative24 = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('result', 'NEGATIVO')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->groupBy('processing_laboratory')
      ->get();

    $total = DB::connection('mysqlGestion')->table('minsal_statistics')->count();


    $processed = $this->createSQL('status', 'EN PROCESO');
    $rejected = $this->createSQL('status', 'RECHAZADA');
    $completed = $this->createSQL('status', 'RESUELTO');
    $received = $this->createSQL('status', 'RECEPCIONADA');

    $professional_validator = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, professional_validator'))
      ->where('status', 'RESUELTO')
      ->groupBy('professional_validator')
      ->get();

    $processing_laboratory = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, processing_laboratory'))
      ->where('status', 'RESUELTO')
      ->groupBy('processing_laboratory')
      ->get();

    $result = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, result'))
      ->where('status', 'RESUELTO')
      ->groupBy('result')
      ->get();

    $requesting_doctor = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, requesting_doctor'))
      ->where('status', 'RESUELTO')
      ->groupBy('requesting_doctor')
      ->get();

    $professional_validator_rej = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, professional_validator'))
      ->where('status', 'RECHAZADA')
      ->groupBy('professional_validator')
      ->get();

    $rejection_reason = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw('count(*) as test_count, rejection_reason'))
      ->where('status', 'RECHAZADA')
      ->groupBy('rejection_reason')
      ->get();

    $no_distribuited = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->select('id_testing_request', 'received_at')
      ->where([
        ['status', 'RESUELTO'],
        ['distributed_at', null],
      ])->get();

    $no_rejected = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->select('id_testing_request', 'received_at')
      ->where([
        ['status', 'RECHAZADA'],
        ['result', null],
      ])->get();

    $age_0_10 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->whereBetween('patient_age', [0, 10])
      ->count();

    // return response()->json($this->transformDate($key['notified_at']));


    $twoDaysBefore = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$limitDate2Down, $limitDateUp])
      ->count();

    $oneDaysBefore = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $current_stock_72 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$limitDate3Down, $limitDateUp])
      ->count();

    $totalStock = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'EN PROCESO')
      ->count();

    $twoDaysBeforeReceived = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$limitDate2Down, $limitDateUp])
      ->count();

    $oneDaysBeforeReceived = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $current_stock_72Received = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$limitDate3Down, $limitDateUp])
      ->count();

    $test = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->orWhere('status', 'EN PROCESO')
      ->whereBetween('received_at', [$limitDate2Down, $limitDateUp])
      ->count();

    $totalStockReceived = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->count();


    $received24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->whereBetween('received_at', [$limitDateDown, $limitDateUp])
      ->count();

    $notified24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->whereBetween('notified_at', [$limitDateDown, $limitDateUp])
      ->count();

    $positive24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('result', 'POSITIVO')
      ->whereBetween('notified_at', [$limitDateDown, $limitDateUp])
      ->count();

    /*      $received24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('received_at', '>', $limitDateDown)
      ->where('received_at', '<', $limitDateUp)
      ->count(); */

    $distinct = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->select('processing_laboratory as laboratory')->distinct()->get();

    $distinct2 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->select('result')->distinct()->get();

    $statusDistinct = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->select('status')->distinct()->get();

    return response()->json([
      'current_date' => Carbon::parse($limitDateUp)->format('d-m-Y'),
      'days' => [
        $currentDate,
        $subDay,
        $sub2Days,
        $sub3Days,
        $sub4Days
      ],
      'test' => [
        'countByLabNegativeTotal' => $countByLabNegativeTotal,
        'countByLabNegative24' => $countByLabNegative24,
        'countByLabNegative48' => $countByLabNegative48,
        'countByLabNegative72' => $countByLabNegative72,
        'countByLabNegative96' => $countByLabNegative96,
        'countByLabNegative120' => $countByLabNegative120,
        'resultByGroupLaboratory' => $this->resultGoupByLaboratory($distinct),
        'notifiedByGroupLaboratory' => $this->notifiedGroupByLaboratory($distinct),
        'notifiedGroupByResult' => $this->notifiedGroupByResult($distinct2),
        'notifiedGroupByLaboratoryResult' => $this->notifiedGroupByLaboratoryResult($distinct),
        'distinct' => $distinct,
        'distinct2' => $distinct2,
        'currentStatusByLaboratory_' => $this->currentStatusByLaboratory_($distinct),
        'full_presidency' => $this->presidencyByLaboratory($distinct),
        'statusSamplesLastFiveDays' => $this->statusSamplesByLastFiveDays()
      ],
      'result' => [
        'total' => [
          'detail' => [
            [
              'count' => $nullResultTotal,
              'description' => 'Sin resultado',
              'detail' => [
                'description' => 'Detalle de muestras sin resultado',
                'data' => [
                  [
                    'count' => $nullResult120,
                    'date' => $sub4Days_,
                    'color' => 'red',
                  ],
                  [
                    'count' => $nullResult96,
                    'date' => $sub3Days_,
                    'color' => 'red',
                  ],
                  [
                    'count' => $nullResult72,
                    'date' => $sub2Days_,
                    'color' => 'red',
                  ],
                  [
                    'count' => $nullResult48,
                    'date' => $subDay_,
                    'color' => 'yellow'
                  ],
                  [
                    'count' => $nullResult24,
                    'date' => $currentDate_,
                    'color' => 'green'
                  ]
                ]
              ]
            ],
            [
              'count' => $positiveResultTotal,
              'description' => 'Positivo',
              'detail' => [
                'description' => 'Detalle de muestras positivas',
                'data' => [
                  [
                    'count' => $positiveResult120,
                    'date' => $sub4Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $positiveResult96,
                    'date' => $sub3Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $positiveResult72,
                    'date' => $sub2Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $positiveResult48,
                    'date' => $subDay_,
                    'color' => 'yellow'
                  ],
                  [
                    'count' => $positiveResult24,
                    'date' => $currentDate_,
                    'color' => 'green'
                  ]
                ]
              ]
            ],
            [
              'count' => $negativeResultTotal,
              'description' => 'Negativo',
              'detail' => [
                'description' => 'Detalle de muestras negativas',
                'data' => [
                  [
                    'count' => $negativeResult120,
                    'date' => $sub4Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $negativeResult96,
                    'date' => $sub3Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $negativeResult72,
                    'date' => $sub2Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $negativeResult48,
                    'date' => $subDay_,
                    'color' => 'yellow'
                  ],
                  [
                    'count' => $negativeResult24,
                    'date' => $currentDate_,
                    'color' => 'green'
                  ]
                ]
              ]
            ],
            [
              'count' => $rejectResultTotal,
              'description' => 'Rechazada',
              'detail' => [
                'description' => 'Detalle de muestras rechazadas',
                'data' => [
                  [
                    'count' => $rejectResult120,
                    'date' => $sub4Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $rejectResult96,
                    'date' => $sub3Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $rejectResult72,
                    'date' => $sub2Days_,
                    'color' => 'red'
                  ],
                  [
                    'count' => $rejectResult48,
                    'date' => $subDay_,
                    'color' => 'yellow'
                  ],
                  [
                    'count' => $rejectResult24,
                    'date' => $currentDate_,
                    'color' => 'green'
                  ]
                ]
              ]
            ],
          ],
          'total' => $total
        ],


      ],
      'state' => [
        'en_proceso' => $processed,
        'rechazadas' => $rejected,
        'finalizadas' => $completed,
        'recepcionadas' => $received
      ],
      'performance' => [
        'description' => 'Rendimiento últmos 5 días',
        'detail' => [

          [
            'percentage' => $percent24,
            'date' =>  $currentDate_,
          ],
          [
            'percentage' => $percent48,
            'date' =>  $subDay_,
          ],
          [
            'percentage' => $percent72,
            'date' =>  $sub2Days_,
          ],
          [
            'percentage' => $percent96,
            'date' =>  $sub3Days_,
          ],
          [
            'percentage' => $percent120,
            'date' =>  $sub4Days_,
          ],
        ]
      ],
      'groupBy' => [
        'completed' => [
          'professional_validator' => $professional_validator,
          'processing_laboratory' => $processing_laboratory,
          'result' => $result,
          'requesting_doctor' => $requesting_doctor
        ],
        'pending' => [
          'in_process' => [
            'detail' => [
              [
                'count' => $oneDaysBefore,
                'description' => '24 horas atrás',
                'diff' => 0
              ],
              [
                'count' => $twoDaysBefore,
                'description' => '48 horas atrás',
                'diff' => $twoDaysBefore - $oneDaysBefore
              ],
              [
                'count' => $current_stock_72,
                'description' => '72 horas atrás',
                'diff' => $current_stock_72 - $twoDaysBefore
              ],
              [
                'count' => $totalStock,
                'description' => 'Más de 72 horas',
                'diff' => $totalStock - $current_stock_72
              ],
            ],
            'total' => $totalStock
          ],
          'received' => [
            'detail' => [
              [
                'count' => $oneDaysBeforeReceived,
                'description' => '24 horas atrás',
                'diff' => 0
              ],
              [
                'count' => $twoDaysBeforeReceived,
                'description' => '48 horas atrás',
                'diff' => $twoDaysBeforeReceived - $oneDaysBeforeReceived
              ],
              [
                'count' => $current_stock_72Received,
                'description' => '72 horas atrás',
                'diff' => $current_stock_72Received - $twoDaysBeforeReceived
              ],
              [
                'count' => $totalStockReceived,
                'description' => 'Más de 72 horas',
                'diff' => $totalStockReceived - $current_stock_72Received
              ],
            ],
            'total' => $totalStockReceived
          ],

          '72Horas' => $test

        ],
        'rejected' => [
          'professional_validator' => $professional_validator_rej,
          'rejection_reason' => $rejection_reason
        ],
        'group_by_age' => [
          '0-10' => $age_0_10
        ],
        'errors' => [
          [
            'count' => count($no_distribuited),
            'detail' => $no_distribuited,
            'description' => 'Sin distribución'
          ],
          [
            'count' => count($no_rejected),
            'detail' => $no_rejected,
            'description' => 'Sin rechazo'
          ]
        ],
        'consolidado' => [
          [
            'current_date' => Carbon::parse($limitDateUp)->format('d-m-Y H:i'),
            'sub_day' => Carbon::parse($limitDateDown)->format('d-m-Y H:i'),
            'count' => $received24,
            'description' => 'Recibidas'
          ],
          [
            'current_date' => Carbon::parse($limitDateUp)->format('d-m-Y H:i'),
            'sub_day' => Carbon::parse($limitDateDown)->format('d-m-Y H:i'),
            'count' => $notified24,
            'description' => 'Notificadas'
          ],
          [
            'current_date' => Carbon::parse($limitDateUp)->format('d-m-Y H:i'),
            'sub_day' => Carbon::parse($limitDateDown)->format('d-m-Y H:i'),
            'count' => $positive24,
            'description' => 'Positivas'
          ],
          [
            'current_date' => Carbon::parse($limitDateUp)->format('d-m-Y H:i'),
            'sub_day' => Carbon::parse($limitDate3Down)->format('d-m-Y H:i'),
            'count' => $current_stock_72,
            'description' => 'Stock Actual'

          ]
        ]

      ]

    ]);
  }

  public function filterBySenderInstitution(){
    $statistic = MinsalStatistic::all()->map(function($item){
        $item['received_at'] =  Carbon::parse($item['received_at'])->format('Y-m-d');
      return $item;
    });

    $colllections = collect($statistic);

    $distinct = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->select('sending_institution')->distinct()->get();

     // return $distinct;

      $group = $colllections->groupBy('sending_institution');
      $data= [];

      //return $group['HOSPITAL DE LONCOCHE'];

      foreach ($distinct as $key => $value) {
      $array = collect($group[$value->sending_institution]);

      $data[$value->sending_institution] = $array->groupBy('received_at')->map(function($item){
        return $item->count();
      });

      }

    return $data;
 
  }

  public function statusSamplesByLastFiveDays()
  {

    $dates = $this->getDays24Hours();

    $all = [];

    for ($i = 0; $i < count($dates); $i++) {
      $whereBetween = [
        'attr' => 'received_at',
        'init' => $dates[$i]['init'],
        'last' => $dates[$i]['last']
      ];

      $groupBy = 'status';

      $all['days'][$i]['group'] = $this->createGroupBySQLBetween($whereBetween, $groupBy);
      $all['days'][$i]['date'] = Carbon::parse($dates[$i]['last'])->format('d-m-Y');

      $all['days'][$i]['detail'][] =  [
        'samples' => DB::connection('mysqlGestion')
          ->table('minsal_statistics')
          ->where('status', 'EN PROCESO')
          ->whereBetween('received_at', [$whereBetween['init'], $whereBetween['last']])
          ->get(),
        'description' => 'EN PROCESO'
      ];

      $all['days'][$i]['detail'][] =  [
        'samples' => DB::connection('mysqlGestion')
          ->table('minsal_statistics')
          ->where('status', 'RECEPCIONADA')
          ->whereBetween('received_at', [$whereBetween['init'], $whereBetween['last']])
          ->get(),
        'description' => 'RECEPCIONADA'
      ];

      $total = 0;
      $pending = 0;

      foreach ($all['days'][$i]['group'] as $value) {

        if ($value->status == 'RECEPCIONADA' || $value->status == 'EN PROCESO') {
          $pending =  $pending  + $value->count;
        }

        $total = $total + $value->count;
      }

      try {
        $percent = round((($total - $pending) / $total) * 100, 1) . "%";
      } catch (\Exception $exception) {
        $percent = "0%";
      }

      $all['days'][$i]['total'] = $total;
      $all['days'][$i]['pending'] = $pending;
      $all['days'][$i]['percent'] = $percent;
    }

    return $all;
  }

  private function receivedStock120Hour_()
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 18:59";
    $last5Days = "{$sub5Days} 19:00";

    $whithoutDistribuited120 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$last5Days, $lastDay])
      ->count();

    return $whithoutDistribuited120;
  }

  private function presidencyByLaboratory($laboratories)
  {
    $i = 0;

    foreach ($laboratories as $laboratory) {

      if ($laboratory->laboratory != '') {
        $lab['data'][] = [
          'detail' => [
            $this->stockInitialDetail24Generic($laboratory->laboratory),
            $this->receivedDetail24Generic($laboratory->laboratory),
            $this->notifiedDetail24Generic($laboratory->laboratory),
            $this->currentStock120HoursGeneric($laboratory->laboratory),
            $this->positiveDetail24Generic($laboratory->laboratory),
            $this->sumPositiveGeneric($laboratory->laboratory),
            $this->sumNotifiedGeneric($laboratory->laboratory),
          ],
          'processing_laboratory' => ['description' => $laboratory->laboratory]
        ];
      }

      $i++;
    }

    return $lab;
  }


  private function stockInitialDetail24Generic($laboratory)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    $stock24 = $this->currentStock120HoursGeneric($laboratory);
    $received24 =  $this->receivedDetail24Generic($laboratory);
    $notified24 =  $this->notifiedDetail24Generic($laboratory);

    $sumStock = $stock24['count'] +  $notified24['count'] - $received24['count'];

    return [
      'description' => 'Stock actual',
      'init' => $initDay,
      'last' => $lastDay,
      'count' => $sumStock
    ];
  }

  private function currentStock120Hours_($laboratory)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 18:59";
    $last5Days = "{$sub5Days} 19:00";

    $distribuited120 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('processing_laboratory', $laboratory)
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$last5Days, $lastDay])
      ->count();

    return [
      'init' => $last5Days,
      'last' => $lastDay,
      'processing_laboratory' => $laboratory,
      'status' => 'EN PROCESO',
      'count' => $distribuited120
    ];
  }

  private function positiveDetail24Generic($laboratory)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    $positive24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('result', 'POSITIVO')
      ->where('processing_laboratory', $laboratory)
      ->whereBetween('notified_at', [$initDay, $lastDay])
      ->count();

    return [
      'description' => 'Positivo',
      'init' => $initDay,
      'last' => $lastDay,
      'count' => $positive24
    ];
  }

  public function positiveDetail24()
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    $positive24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('result', 'POSITIVO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->whereBetween('notified_at', [$initDay, $lastDay])
      ->count();

    return [
      'init' => $initDay,
      'last' => $lastDay,
      'positive24' => $positive24
    ];
  }

  public function currentStock120HoursGeneric($laboratory)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 18:59";
    $last5Days = "{$sub5Days} 19:00";

    if ($laboratory == 'LABORATORIO HHHA') {
      $distribuited120 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('processing_laboratory', $laboratory)
        ->where('status', 'EN PROCESO')
        ->whereBetween('received_at', [$last5Days, $lastDay])
        ->count();

      $whithoutDistribuited120 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('status', 'RECEPCIONADA')
        ->whereBetween('received_at', [$last5Days, $lastDay])
        ->count();


      $allCurrentStock120 = $distribuited120 + $whithoutDistribuited120;
    } else {
      $distribuited120 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('processing_laboratory', $laboratory)
        ->where('status', 'EN PROCESO')
        ->whereBetween('received_at', [$last5Days, $lastDay])
        ->count();

      $whithoutDistribuited120 = 0;

      $allCurrentStock120 = $distribuited120 + $whithoutDistribuited120;
    }


    return [
      'description' => 'Stock Final',
      'init' => $last5Days,
      'last' => $lastDay,
      'distribuited120' => $distribuited120,
      'whithoutDistribuited120' => $whithoutDistribuited120,
      'count' => $allCurrentStock120
    ];
  }

  public function currentStock120Hours()
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 18:59";
    $last5Days = "{$sub5Days} 19:00";

    $distribuited120 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$last5Days, $lastDay])
      ->count();

    $whithoutDistribuited120 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$last5Days, $lastDay])
      ->count();


    $allCurrentStock120 = $distribuited120 + $whithoutDistribuited120;

    return [
      'init' => $last5Days,
      'last' => $lastDay,
      'distribuited120' => $distribuited120,
      'whithoutDistribuited120' => $whithoutDistribuited120,
      'allCurrentStock120' => $allCurrentStock120
    ];
  }

  private function notifiedDetail24Generic($laboratory)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    $notified24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('processing_laboratory', $laboratory)
      ->whereBetween('notified_at', [$initDay, $lastDay])
      ->count();

    return [
      'description' => 'Notificado',
      'init' => $initDay,
      'last' => $lastDay,
      'count' => $notified24
    ];
  }

  public function notifiedDetail24()
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    $notified24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->whereBetween('notified_at', [$initDay, $lastDay])
      ->count();

    return [
      'init' => $initDay,
      'last' => $lastDay,
      'notified24' => $notified24
    ];
  }

  private function receivedDetail24Generic($laboratory)
  {

    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    if ($laboratory == 'LABORATORIO HHHA') {
      $distribuited24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('processing_laboratory', $laboratory)
        ->where('status', 'EN PROCESO')
        ->whereBetween('received_at', [$initDay, $lastDay])
        ->count();

      $whithoutDistribuited24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('status', 'RECEPCIONADA')
        ->whereBetween('received_at', [$initDay, $lastDay])
        ->count();

      $completed24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('processing_laboratory', $laboratory)
        ->where('status', 'RESUELTO')
        ->whereBetween('received_at', [$initDay, $lastDay])
        ->count();

      $rejected24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('status', 'RECHAZADA')
        ->whereBetween('received_at', [$initDay, $lastDay])
        ->count();

      $all24 = $distribuited24 + $completed24 + $whithoutDistribuited24;
    } else {
      $distribuited24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('processing_laboratory', $laboratory)
        ->where('status', 'EN PROCESO')
        ->whereBetween('received_at', [$initDay, $lastDay])
        ->count();

      $whithoutDistribuited24 = 0;

      $completed24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('processing_laboratory', $laboratory)
        ->where('status', 'RESUELTO')
        ->whereBetween('received_at', [$initDay, $lastDay])
        ->count();

      $rejected24 = 0;

      $all24 = $distribuited24 + $completed24 + $whithoutDistribuited24;
    }

    return [
      'description' => 'Recepcionado',
      'init' => $initDay,
      'last' => $lastDay,
      'distribuited24' => $distribuited24,
      'whithoutDistribuited24' => $whithoutDistribuited24,
      'completed24' => $completed24,
      'rejected24' => $rejected24,
      'count' => $all24
    ];
  }

  public function receivedDetail24()
  {

    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');


    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";

    $distribuited24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $whithoutDistribuited24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $completed24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->where('status', 'RESUELTO')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $rejected24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECHAZADA')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $all24 = $distribuited24 + $completed24 + $whithoutDistribuited24;

    return [
      'init' => $initDay,
      'last' => $lastDay,
      'distribuited24' => $distribuited24,
      'whithoutDistribuited24' => $whithoutDistribuited24,
      'completed24' => $completed24,
      'rejected24' => $rejected24,
      'all24' => $all24
    ];
  }

  public function presidenciaStatistics()
  {


    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";
    $last3Days = "{$sub3Days} 19:00";
    $last5Days = "{$sub5Days} 19:00";


    $distribuited24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->where('status', 'EN PROCESO')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $received24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $result24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $notified24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->whereBetween('notified_at', [$initDay, $lastDay])
      ->count();

    $positive24 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RESUELTO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->where('result', 'POSITIVO')
      ->whereBetween('received_at', [$initDay, $lastDay])
      ->count();

    $distribuitedPending120 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'EN PROCESO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->whereBetween('received_at', [$last5Days, $subDay . " 18:59"])
      ->count();

    $receivedPending120 = DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$last5Days, $subDay . " 18:59"])
      ->count();


    $distribuitedPending72 =  DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'EN PROCESO')
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->whereBetween('received_at', [$last3Days, $subDay . " 18:59"])
      ->count();

    $receivedPending72 =  DB::connection('mysqlGestion')
      ->table('minsal_statistics')
      ->where('status', 'RECEPCIONADA')
      ->whereBetween('received_at', [$last3Days, $subDay . " 18:59"])
      ->count();

    return [
      'init' => $initDay,
      'last' => $lastDay,
      '24' => [
        'distribuited24' => $distribuited24,
        'received24' => $received24,
        'result24' => $result24,
        'notified24' => $notified24,
        'positive24' => $positive24,
        'sumAllStates' => $distribuited24 + $received24 + $result24
      ],
      '72' => [
        'distribuitedPending72' => $distribuitedPending72,
        'receivedPending72' => $receivedPending72,
        'init' => $last3Days,
        'last' => $subDay . " 18:59"
      ],
      '120' => [
        'distribuitedPending120' => $distribuitedPending120,
        'receivedPending120' => $receivedPending120,
        'init' => $last5Days,
        'last' => $subDay . " 18:59"

      ]

    ];
  }

  private function sumNotifiedGeneric($laboratory)
  {

    if ($laboratory == 'LABORATORIO HHHA') {
      $subDay = Carbon::now()->subDay()->format('Y-m-d');

      $presidency = PresidencyConsolidate::where('current_date', $subDay)->first();

      $notified = $this->notifiedDetail24Generic($laboratory);

      $totalNotified =  $notified['count'] + $presidency['sum_notified'];
    } else {
      $totalNotified = 0;
    }

    return [
      'description' => 'Total notificados',
      'count' => $totalNotified
    ];
  }

  private function sumPositiveGeneric($laboratory)
  {

    if ($laboratory == 'LABORATORIO HHHA') {
      $subDay = Carbon::now()->subDay()->format('Y-m-d');

      $presidency = PresidencyConsolidate::where('current_date', $subDay)->first();

      $positive = $this->positiveDetail24Generic($laboratory);

      $totalPositive =  $positive['count'] + $presidency['sum_positive'];
    } else {
      $totalPositive = 0;
    }

    return [
      'description' => 'Total positivos',
      'count' => $totalPositive
    ];
  }

  public function sumNotifiedAndPositive()
  {
    $subDay = Carbon::now()->subDay()->format('Y-m-d');

    $presidency = PresidencyConsolidate::where('current_date', $subDay)->first();

    return $presidency;
  }

  public function currentStatusByLaboratory_($laboratories)
  {

    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');

    $lastDay = "{$currentDate} 18:59";
    $initDay = "{$subDay} 19:00";
    $last3Days = "{$sub3Days} 19:00";

    $all = [];


    for ($x = 0; $x < count($laboratories); $x++) {

      if ($laboratories[$x]->laboratory == 'LABORATORIO HHHA') {
        $received24 = DB::connection('mysqlGestion')
          ->table('minsal_statistics')
          ->where('processing_laboratory', $laboratories[$x]->laboratory)
          ->whereBetween('received_at', [$initDay, $lastDay])
          ->count();

        $received24_ = DB::connection('mysqlGestion')
          ->table('minsal_statistics')
          ->where('processing_laboratory', null)
          ->whereBetween('received_at', [$initDay, $lastDay])
          ->count();

        $received24 = $received24 + $received24_;
      } else {
        $received24 = DB::connection('mysqlGestion')
          ->table('minsal_statistics')
          ->where('processing_laboratory', $laboratories[$x]->laboratory)
          ->whereBetween('received_at', [$initDay, $lastDay])
          ->count();
      }

      $notified24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('status', 'RESUELTO')
        ->where('processing_laboratory', $laboratories[$x]->laboratory)
        ->whereBetween('notified_at', [$initDay, $lastDay])
        ->count();

      $positive24 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('status', 'RESUELTO')
        ->where('result', 'POSITIVO')
        ->where('processing_laboratory', $laboratories[$x]->laboratory)
        ->whereBetween('notified_at', [$initDay, $lastDay])
        ->count();

      $current_stock_72 = DB::connection('mysqlGestion')
        ->table('minsal_statistics')
        ->where('status', 'EN PROCESO')
        ->where('processing_laboratory', $laboratories[$x]->laboratory)
        ->whereBetween('received_at', [$last3Days, $lastDay])
        ->count();

      $all[] = [
        'laboratory' => $laboratories[$x]->laboratory,
        'date' => $lastDay,
        'detail' => [
          [
            'description' => 'RECEPCIONADAS',
            'count' => $received24
          ],
          [
            'description' => 'NOTIFICADAS',
            'count' => $notified24
          ],
          [
            'description' => 'POSITIVOS',
            'count' => $positive24
          ],
          [
            'description' => 'STOCK PENDIENTES',
            'count' => $current_stock_72
          ]
        ],
      ];
    }
    return $all;
  }

  public function currentStatusByLaboratory($laboratories)
  {

    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');

    $limitDateDown = "{$currentDate} 18:59";
    $limitDate1Down = "{$subDay} 19:00";

    $all = [];


    for ($x = 0; $x < count($laboratories); $x++) {
      $test = [];


      $whereBetween = [
        'attr' => 'notified_at',
        'init' => $limitDate1Down,
        'last' => $limitDateDown
      ];

      $where = [
        'attr' => 'processing_laboratory',
        'value' => $laboratories[$x]->laboratory
      ];

      $groupBy = 'result';

      $test['days']['group'] = DB::connection('mysqlGestion')->table('minsal_statistics')
        ->select(DB::raw("count(*) as count, {$groupBy}"))
        ->where($where['attr'], $where['value'])
        ->whereBetween($whereBetween['attr'], [$whereBetween['init'], $whereBetween['last']])
        ->groupBy($groupBy)
        ->get();

      $test['days']['date'] = Carbon::parse($limitDateDown)->format('d-m-Y');
      $test['description'] = $laboratories[$x]->laboratory;

      $sum = 0;

      foreach ($test['days']['group'] as $value) {
        $sum = $sum + $value->count;
      }
      $test['days']['sum'] = $sum;


      $all[] = $test;
    }

    return $all;
  }

  public function notifiedGroupByLaboratoryResult($values)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $limitDateDown = "{$currentDate} 18:59";
    $limitDate1Down = "{$subDay} 19:00";
    $limitDate2Down = "{$sub2Days} 19:00";
    $limitDate3Down = "{$sub3Days} 19:00";
    $limitDate4Down = "{$sub4Days} 19:00";
    $limitDate5Down = "{$sub5Days} 19:00";

    $dates[0] = [
      'init' => $limitDate1Down,
      'last' => "{$limitDateDown}"
    ];
    $dates[1] = [
      'init' => $limitDate2Down,
      'last' => "{$subDay} 18:59"
    ];
    $dates[2] = [
      'init' => $limitDate3Down,
      'last' => "{$sub2Days} 18:59"
    ];
    $dates[3] = [
      'init' => $limitDate4Down,
      'last' => "{$sub3Days} 18:59"
    ];
    $dates[4] = [
      'init' => $limitDate5Down,
      'last' => "{$sub4Days} 18:59"
    ];
    $all = [];


    for ($x = 0; $x < count($values); $x++) {
      $test = [];


      $whereBetween = [
        'attr' => 'notified_at',
        'init' => $dates[0]['init'],
        'last' => $dates[0]['last']
      ];

      $where = [
        'attr' => 'processing_laboratory',
        'value' => $values[$x]->laboratory
      ];

      $groupBy = 'result';

      $test['days']['group'] = DB::connection('mysqlGestion')->table('minsal_statistics')
        ->select(DB::raw("count(*) as count, {$groupBy}"))
        ->where($where['attr'], $where['value'])
        ->whereBetween($whereBetween['attr'], [$whereBetween['init'], $whereBetween['last']])
        ->groupBy($groupBy)
        ->get();

      $test['days']['date'] = Carbon::parse($dates[0]['last'])->format('d-m-Y');
      $test['description'] = $values[$x]->laboratory;

      $sum = 0;

      foreach ($test['days']['group'] as $value) {
        $sum = $sum + $value->count;
      }
      $test['days']['sum'] = $sum;


      $all[] = $test;
    }

    return $all;
  }

  public function notifiedGroupByResult($values)
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $limitDateDown = "{$currentDate} 18:59";
    $limitDate1Down = "{$subDay} 19:00";
    $limitDate2Down = "{$sub2Days} 19:00";
    $limitDate3Down = "{$sub3Days} 19:00";
    $limitDate4Down = "{$sub4Days} 19:00";
    $limitDate5Down = "{$sub5Days} 19:00";

    $dates[0] = [
      'init' => $limitDate1Down,
      'last' => "{$limitDateDown}"
    ];
    $dates[1] = [
      'init' => $limitDate2Down,
      'last' => "{$subDay} 18:59"
    ];
    $dates[2] = [
      'init' => $limitDate3Down,
      'last' => "{$sub2Days} 18:59"
    ];
    $dates[3] = [
      'init' => $limitDate4Down,
      'last' => "{$sub3Days} 18:59"
    ];
    $dates[4] = [
      'init' => $limitDate5Down,
      'last' => "{$sub4Days} 18:59"
    ];
    $all = [];


    for ($x = 0; $x < count($values); $x++) {
      $test = [];

      for ($i = 0; $i < count($dates); $i++) {
        $whereBetween = [
          'attr' => 'notified_at',
          'init' => $dates[$i]['init'],
          'last' => $dates[$i]['last']
        ];

        $where = [
          'attr' => 'result',
          'value' => $values[$x]->result
        ];

        $groupBy = 'processing_laboratory';

        $test['days'][$i]['group'] = DB::connection('mysqlGestion')->table('minsal_statistics')
          ->select(DB::raw("count(*) as count, {$groupBy}"))
          ->where($where['attr'], $where['value'])
          ->whereBetween($whereBetween['attr'], [$whereBetween['init'], $whereBetween['last']])
          ->groupBy($groupBy)
          ->get();

        $test['days'][$i]['date'] = Carbon::parse($dates[$i]['last'])->format('d-m-Y');
        $test['description'] = $values[$x]->result;

        $sum = 0;

        foreach ($test['days'][$i]['group'] as $value) {
          $sum = $sum + $value->count;
        }
        $test['days'][$i]['sum'] = $sum;
      }


      $all[] = $test;
    }

    return $all;
  }

  private function getDays()
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $limitDateDown = "{$currentDate} 18:59";
    $limitDate1Down = "{$subDay} 19:00";
    $limitDate2Down = "{$sub2Days} 19:00";
    $limitDate3Down = "{$sub3Days} 19:00";
    $limitDate4Down = "{$sub4Days} 19:00";
    $limitDate5Down = "{$sub5Days} 19:00";

    $dates[0] = [
      'init' => $limitDate1Down,
      'last' => "{$limitDateDown}"
    ];
    $dates[1] = [
      'init' => $limitDate2Down,
      'last' => "{$subDay} 18:59"
    ];
    $dates[2] = [
      'init' => $limitDate3Down,
      'last' => "{$sub2Days} 18:59"
    ];
    $dates[3] = [
      'init' => $limitDate4Down,
      'last' => "{$sub3Days} 18:59"
    ];
    $dates[4] = [
      'init' => $limitDate5Down,
      'last' => "{$sub4Days} 18:59"
    ];
    return $dates;
  }

  private function getDays24Hours()
  {
    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $limitDateDown = "{$currentDate} 23:59";
    $limitDate1Down = "{$subDay} 00:00";
    $limitDate2Down = "{$sub2Days} 00:00";
    $limitDate3Down = "{$sub3Days} 00:00";
    $limitDate4Down = "{$sub4Days} 00:00";
    $limitDate5Down = "{$sub5Days} 00:00";

    $dates[0] = [
      'init' => "{$currentDate} 00:00",
      'last' => "{$currentDate} 23:59"
    ];
    $dates[1] = [
      'init' => "{$subDay} 00:00",
      'last' => "{$subDay} 23:59"
    ];
    $dates[2] = [
      'init' => "{$sub2Days} 00:00",
      'last' => "{$sub2Days} 23:59"
    ];
    $dates[3] = [
      'init' => "{$sub3Days} 00:00",
      'last' => "{$sub3Days} 23:59"
    ];
    $dates[4] = [
      'init' => "{$sub4Days} 00:00",
      'last' => "{$sub4Days} 23:59"
    ];
    return $dates;
  }

  public function notifiedGroupByLaboratory($values)
  {


    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $limitDateDown = "{$currentDate} 18:59";
    $limitDate1Down = "{$subDay} 19:00";
    $limitDate2Down = "{$sub2Days} 19:00";
    $limitDate3Down = "{$sub3Days} 19:00";
    $limitDate4Down = "{$sub4Days} 19:00";
    $limitDate5Down = "{$sub5Days} 19:00";

    $dates[0] = [
      'init' => $limitDate1Down,
      'last' => "{$limitDateDown}"
    ];
    $dates[1] = [
      'init' => $limitDate2Down,
      'last' => "{$subDay} 18:59"
    ];
    $dates[2] = [
      'init' => $limitDate3Down,
      'last' => "{$sub2Days} 18:59"
    ];
    $dates[3] = [
      'init' => $limitDate4Down,
      'last' => "{$sub3Days} 18:59"
    ];
    $dates[4] = [
      'init' => $limitDate5Down,
      'last' => "{$sub4Days} 18:59"
    ];
    $all = [];


    for ($x = 0; $x < count($values); $x++) {
      $test = [];

      for ($i = 0; $i < count($dates); $i++) {
        $whereBetween = [
          'attr' => 'notified_at',
          'init' => $dates[$i]['init'],
          'last' => $dates[$i]['last']
        ];

        $where = [
          'attr' => 'processing_laboratory',
          'value' => $values[$x]->laboratory
        ];

        $groupBy = 'result';



        $test['days'][$i]['group'] = $this->createGroupBySQL($whereBetween, $where, $groupBy);
        $test['days'][$i]['date'] = Carbon::parse($dates[$i]['last'])->format('d-m-Y');
        $test['description'] = $values[$x]->laboratory;

        $sum = 0;

        foreach ($test['days'][$i]['group'] as $value) {
          $sum = $sum + $value->count;
        }
        $test['days'][$i]['sum'] = $sum;
      }


      $all[] = $test;
    }

    return $all;
  }

  public function resultGoupByLaboratory($values)
  {

    $currentDate = Carbon::now()->format('Y-m-d');
    $subDay = Carbon::now()->subDay()->format('Y-m-d');
    $sub2Days = Carbon::now()->subDays(2)->format('Y-m-d');
    $sub3Days = Carbon::now()->subDays(3)->format('Y-m-d');
    $sub4Days = Carbon::now()->subDays(4)->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $limitDateDown = "{$currentDate} 18:59";
    $limitDate1Down = "{$subDay} 19:00";
    $limitDate2Down = "{$sub2Days} 19:00";
    $limitDate3Down = "{$sub3Days} 19:00";
    $limitDate4Down = "{$sub4Days} 19:00";
    $limitDate5Down = "{$sub5Days} 19:00";

    $dates[0] = [
      'init' => $limitDate1Down,
      'last' => "{$limitDateDown}"
    ];
    $dates[1] = [
      'init' => $limitDate2Down,
      'last' => "{$subDay} 18:59"
    ];
    $dates[2] = [
      'init' => $limitDate3Down,
      'last' => "{$sub2Days} 18:59"
    ];
    $dates[3] = [
      'init' => $limitDate4Down,
      'last' => "{$sub3Days} 18:59"
    ];
    $dates[4] = [
      'init' => $limitDate5Down,
      'last' => "{$sub4Days} 18:59"
    ];
    $all = [];

    for ($x = 0; $x < count($values); $x++) {
      $test = [];

      for ($i = 0; $i < count($dates); $i++) {
        $whereBetween = [
          'attr' => 'received_at',
          'init' => $dates[$i]['init'],
          'last' => $dates[$i]['last']
        ];

        $where = [
          'attr' => 'processing_laboratory',
          'value' => $values[$x]->laboratory
        ];

        $groupBy = 'result';

        $test['days'][$i]['group'] = $this->createGroupBySQL($whereBetween, $where, $groupBy);
        $test['days'][$i]['date'] = Carbon::parse($dates[$i]['last'])->format('d-m-Y');
        $test['description'] = $values[$x]->laboratory;

        $sum = 0;

        foreach ($test['days'][$i]['group'] as $value) {
          $sum = $sum + $value->count;
        }
        $test['days'][$i]['sum'] = $sum;
      }


      $all[] = $test;
    }

    return $all;
  }

  private function createGroupBySQL($whereBetween, $where, $groupBy)
  {
    return DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw("count(*) as count, {$groupBy}"))
      ->where($where['attr'], $where['value'])
      ->whereBetween($whereBetween['attr'], [$whereBetween['init'], $whereBetween['last']])
      ->groupBy($groupBy)
      ->get();
  }


  private function createGroupBySQLBetween($whereBetween, $groupBy)
  {
    return DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw("count(*) as count, {$groupBy}"))
      ->whereBetween($whereBetween['attr'], [$whereBetween['init'], $whereBetween['last']])
      ->groupBy($groupBy)
      ->get();
  }


  private function createSQL($condition, $variable)
  {
    return DB::connection('mysqlGestion')->table('minsal_statistics')
      ->where($condition, $variable)
      ->count();
  }
}
