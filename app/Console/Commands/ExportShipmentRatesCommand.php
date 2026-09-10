<?php

namespace App\Console\Commands;

use App\Jobs\CalculateProductShipmentRates;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Export saved inventory shipment rates to an Excel file.
 * 
 * 
 * 
 * Export only — reads data, writes NOTHING to the database.
 *
 * Exports the shipment_rate and offer_shipment_rate already SAVED in the
 * inventories table (by the CalculateProductShipmentRates queue job),
 * for every product that has inventory.
 *
 *   php artisan shipping:export-rates
 *
 * Output: storage/app/exports/shipment-rates-YYYY-MM-DD_HHMMSS.xlsx
 *
 * Requires: phpoffice/phpspreadsheet (already present if maatwebsite/excel is installed)
 */
class ExportShipmentRatesCommand extends Command
{
    protected $signature = 'shipping:export-rates';

    protected $description = 'Export saved inventory shipment rates to an Excel file';

    private const HEADERS = [
        'Product ID', 'Title', 'Length (cm)', 'Breadth (cm)', 'Height (cm)', 'Vol. kg',
        'MRP', 'purchase_rate', 'offer_rate', 'shipment_rate', 'offer_shipment_rate', 'Status',
    ];

    /** Columns written as plain text: SKU, Title, Status */
    private const TEXT_COLUMNS = [1, 2, 11];

    public function handle(): int
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Shipment Rates');
        $sheet->fromArray(self::HEADERS, null, 'A1');

        $query = Product::query()
            ->whereHas('inventories')
            ->select(['id', 'title', 'length', 'breadth', 'height'])
            ->with(['inventories:id,product_id,sku,mrp,purchase_rate,offer_rate,shipment_rate,offer_shipment_rate']);

        $bar   = $this->output->createProgressBar((clone $query)->count());
        $rowNo = 2;

        $query->chunkById(500, function ($products) use ($sheet, &$rowNo, $bar) {
            foreach ($products as $product) {
                foreach ($this->rowsFor($product) as $row) {
                    $this->writeRow($sheet, $rowNo++, $row);
                }
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $lastRow = max($rowNo - 1, 1);
        $this->formatSheet($spreadsheet, $sheet, $lastRow);

        $dir = storage_path('app/exports');
        File::ensureDirectoryExists($dir);
        $path = $dir . '/shipment-rates-' . now()->format('Y-m-d_His') . '.xlsx';

        (new Xlsx($spreadsheet))->save($path);
        $spreadsheet->disconnectWorksheets();

        $this->info('Exported ' . ($lastRow - 1) . " rows to:\n{$path}");

        return self::SUCCESS;
    }

    /** One row per inventory record, in HEADERS order. */
    private function rowsFor(Product $product): array
    {
        // Read-only helper from the job — used only to show Vol. kg in the sheet
        $vol  = CalculateProductShipmentRates::volumetricWeight($product);
        $rows = [];

        foreach ($product->inventories as $inv) {
            $rows[] = [
                $product->id,
                (string) $product->title,
                $this->num($product->length),
                $this->num($product->breadth),
                $this->num($product->height),
                $vol,
                $this->num($inv->mrp),
                $this->num($inv->purchase_rate),
                $this->num($inv->offer_rate),
                $this->num($inv->shipment_rate),
                $this->num($inv->offer_shipment_rate),
                $this->status($inv, $vol),
            ];
        }

        return $rows;
    }

    private function status($inv, ?float $vol): string
    {
        if ($inv->shipment_rate !== null) {
            return $inv->offer_shipment_rate !== null ? 'OK' : 'No offer_rate';
        }

        return $vol === null ? 'Missing dimensions' : 'Not calculated yet - run job';
    }

    private function num($value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * SKU, Title and Status are written as explicit text so SKUs like "00123"
     * keep leading zeros and a title can never be read as a formula.
     */
    private function writeRow($sheet, int $rowNo, array $row): void
    {
        foreach ($row as $i => $value) {
            if ($value === null) {
                continue;
            }

            $cell = chr(ord('A') + $i) . $rowNo;

            in_array($i, self::TEXT_COLUMNS, true)
                ? $sheet->setCellValueExplicit($cell, (string) $value, DataType::TYPE_STRING)
                : $sheet->setCellValue($cell, $value);
        }
    }

    private function formatSheet(Spreadsheet $spreadsheet, $sheet, int $lastRow): void
    {
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        // Header: bold white on GD Sons navy
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '062B45']],
        ]);

        $sheet->freezePane('A2');
        $sheet->setAutoFilter("A1:L{$lastRow}");

        $sheet->getStyle("D2:F{$lastRow}")->getNumberFormat()->setFormatCode('0.00');
        $sheet->getStyle("G2:G{$lastRow}")->getNumberFormat()->setFormatCode('0.000');
        $sheet->getStyle("H2:K{$lastRow}")->getNumberFormat()->setFormatCode('#,##0.00');

        $widths = [
            'A' => 11, 'B' => 16, 'C' => 60, 'D' => 12, 'E' => 12, 'F' => 12,
            'G' => 10, 'H' => 12, 'I' => 12, 'J' => 14, 'K' => 18, 'L' => 28,
        ];
        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }
    }
}