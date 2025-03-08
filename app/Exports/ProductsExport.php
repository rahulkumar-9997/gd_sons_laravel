<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
class ProductsExport implements FromArray
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }
}
