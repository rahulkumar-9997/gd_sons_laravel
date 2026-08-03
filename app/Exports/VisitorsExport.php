<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class VisitorsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithChunkReading
{
    protected $query;
    protected $srNo = 0;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return ['#', 'IP Address', 'Device Name', 'Page Title', 'Page URL', 'Customer Name', 'Visited At'];
    }

    public function map($visitor): array
    {
        $this->srNo++;

        $pageTitle = $visitor->page_title == 'Best Kitchen Retail Store in Varanasi now goes Online'
            ? 'Home Page'
            : $visitor->page_title;

        return [
            $this->srNo,
            $visitor->ip_address,
            $visitor->device_category,
            $pageTitle,
            $visitor->page_name,
            $visitor->customer_name,
            $visitor->visited_at ? Carbon::parse($visitor->visited_at)->format('d M Y h:i:s A') : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
