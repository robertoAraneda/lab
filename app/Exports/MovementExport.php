<?php

namespace App\Exports;

use App\ModelStore\MovementProduct;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MovementExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return MovementProduct::all();
  }


  use Exportable;

  /**
   * @var MovementProduct $movementProduct
   */
  public function map($movementProduct): array
  {

    //id, code, description, category_id, presentation_id, stock, created_user_id, updated_user_id, created_user_ip, updated_user_ip, isActive, created_at, updated_at, state_id, critical_stock
    return [
      $movementProduct->product->description,
      $movementProduct->quantity,
      $movementProduct->movement,
      $movementProduct->user->name,
      Carbon::parse($movementProduct->created_at)->format('d/m/Y H:i:s'),
    ];
  }

  public function headings(): array
  {

    return [
      [
        'NOMBRE PRODUCTO',
        'CANTIDAD',
        'TIPO MOVIMIENTO',
        'REALIZADO POR',
        'FECHA'
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
            'bold' => true,
            'color' => ['argb' => 'FFFFFF']
          ],
          'borders' => [
            'top' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
            'bottom' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
          ],

          'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 90,
            'startColor' => [
              'argb' => '027087',
            ],
            'endColor' => [
              'argb' => '027087',
            ],
          ],
        ];

        $cellRange = 'A1:E1'; // All headers
        $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
        $event->sheet->getDelegate()->getStyle($cellRange)
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
      }
    ];
  }
}
