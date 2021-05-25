<?php

namespace App\Exports;

use App\ModelStore\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProductExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{

  use Exportable;

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Product::all();
  }


  /**
   * @var Product $product
   */
  public function map($product): array
  {

    //id, code, description, category_id, presentation_id, stock, created_user_id, updated_user_id, created_user_ip, updated_user_ip, isActive, created_at, updated_at, state_id, critical_stock
    return [
      $product->code,
      $product->description,
      $product->category == null ? '' : $product->category->description,
      $product->ubication == null ? '' : $product->ubication->description,
      $product->presentation == null ? '' :   $product->presentation->description,
      $product->stock,
      $product->critical_stock,
      $product->price,
      $product->createdUser->name,
    ];
  }

  public function headings(): array
  {

    return [
      [
        'CODIGO',
        'NOMBRE',
        'CATEGORIA',
        'UBICACION',
        'PRESENTACIÓN',
        'STOCK ACTUAL',
        'STOCK CRITICO',
        'PRECIO',
        'CREADO POR'
      ],
    ];
  }

  /**
   * @return array
   */
  public function registerEvents(): array
  {
    return [
      BeforeExport::class  => function (BeforeExport $event) {
        $event->writer->getDelegate()->getSecurity()->setLockWindows(true);
        $event->writer->getDelegate()->getSecurity()->setLockStructure(true);
        $event->writer->getDelegate()->getSecurity()->setWorkbookPassword("Minsal2020");
      },
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

        $cellRange = 'A1:I1'; // All headers
        $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
        $event->sheet->getDelegate()->getStyle($cellRange)
          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
      }
    ];
  }
}
