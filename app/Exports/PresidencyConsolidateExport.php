<?php

namespace App\Exports;

use App\ModelManagement\PresidencyConsolidate;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PresidencyConsolidateExport implements FromCollection,  WithMapping, WithHeadings, WithEvents
{

  use Exportable;

  private $date;
  private $formatDate;

  public function __construct(string $date)
  {
    $this->date = $date;
    $this->formatDate = Carbon::parse($date)->format('d-m');
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return PresidencyConsolidate::where('current_date', $this->date)->get();
  }


  /**
   * @var PresidencyConsolidate $presidencyConsolidate
   */
  public function map($presidencyConsolidate): array
  {

    //id, current_date, initial_date, last_date, processing_laboratory, corte, current_stock, received, notified, final_stock, positive, sum_notified, sum_positive, created_user_id, updated_user_id, created_ip, updated_ip, created_at, updated_at

    return

      [
        "Hospital Dr. Hernán Henríquez Aravena",
        "Temuco",
        $presidencyConsolidate->current_stock,
        $presidencyConsolidate->received,
        $presidencyConsolidate->notified,
        $presidencyConsolidate->final_stock,
        "800",
        round(($presidencyConsolidate->notified / 800), 4),
        $presidencyConsolidate->positive,
        $presidencyConsolidate->sum_notified,
        $presidencyConsolidate->sum_positive,
        "Se reciben muestras de operativos municipales de busqueda activa (estrategia BAC)."

      ];
  }

  public function headings(): array
  {

    return [
      ["Enviar información con corte 16:00 hrs."],
      [
        "Instrucciones",
        "",
        "Informar cuantas muestras tenían sin procesar (en cola) el día anterior a las 16 hrs",
        "Informar cuantas muestras recibieron entre el día anterior a las 16:00hrs, y el día reportado a las 16:00hrs",
        "Informar número de muestras procesadas entre las 16:00 hrs del día anterior y las 16:00 hrs del día reportado",
        "No rellenar",
        "Reportar capacidad máxima teórica de procesamiento diario",
        "No rellenar",
        "",
        "Información histórica total desde la llegada de la pandemia",
        "Información histórica total de los positivos desde la llegada de la pandemia",
        "Reportar información de insusmos críticos, potenciales quiebres de stock y requerimientos generales."
      ],
      [],
      [
        'Nombre de Laboratorio',
        'Ciudad',
        "Stock muestras en espera día " . $this->formatDate . " a las 16:00 hrs",
        "# de muestras recibidas el día " . $this->formatDate . " a las 16:00 hrs",
        "# de muestras procesadas el día " . $this->formatDate . " a las 16:00 hrs",
        "Stock Final muestras en espera día " . $this->formatDate . " a las 16:00 hrs",
        'Capacidad máxima de procesamiento diario',
        "Tasa de ocupación día " . $this->formatDate . " (%)",
        "# muestras positivas día " . $this->formatDate,
        "# muestras procesados acumulados hasta " . $this->formatDate . "16:00 hrs.",
        "# muestras positivas acumulados hasta " . $this->formatDate . " 16:00 hrs.",
        "Alerta cuello de botella"

      ],
    ];
  }


  /**
   * @return array
   */
  public function registerEvents(): array
  {
    return [
      AfterSheet::class    => function (AfterSheet $event) {
        $styleArray = [
          'font' => [
            'bold' => false,
            'color' => ['argb' => '212121']
          ],
          /*           'borders' => [
            'top' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'bottom' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],
 */
          'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 90,
            'startColor' => [
              'argb' => 'D9D9D9',
            ],
            'endColor' => [
              'argb' => 'D9D9D9',
            ],
          ],
        ];

        $cellRangeInstructions = 'A2:L2'; // All instructions
        $cellRangeHeaders = 'A4:L4'; // All headers
        $cellRangeData = 'A5:L5'; //all data

        $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(70);
        $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(15);
        $event->sheet->getDelegate()->getRowDimension('4')->setRowHeight(60);
        $event->sheet->getDelegate()->getRowDimension('5')->setRowHeight(130);


        $event->sheet->getDelegate()->getStyle('A4:L5')
          ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        $event->sheet->getDelegate()->getStyle($cellRangeInstructions)
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $event->sheet->getDelegate()->getStyle($cellRangeInstructions)
          ->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
        $event->sheet->getDelegate()->getStyle($cellRangeHeaders)
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $event->sheet->getDelegate()->getStyle($cellRangeHeaders)
          ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $event->sheet->getDelegate()->getStyle($cellRangeData)
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $event->sheet->getDelegate()->getStyle($cellRangeData)
          ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $event->sheet->getDelegate()->getStyle($cellRangeHeaders)->applyFromArray($styleArray);

        $event->sheet->getDelegate()->getStyle('F4:F5')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('F8CBAD');

        $event->sheet->getDelegate()->getStyle('A2:L2')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('FFF2CC');

        $event->sheet->getDelegate()->getStyle('H4:H5')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('F8CBAD');

        $event->sheet->getDelegate()->getStyle($cellRangeHeaders)->getAlignment()->setWrapText(true);
        $event->sheet->getDelegate()->getStyle($cellRangeInstructions)->getAlignment()->setWrapText(true);

        $event->sheet->getDelegate()->getStyle('L5')->getAlignment()->setWrapText(true);

        $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
        $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
        $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
        $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(60);
      }
    ];
  }
}
