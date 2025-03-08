<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('category:id,title') 
            ->get(['id', 'title', 'category_id'])
            ->map(function($product) {
                $product->formatted_title = ucwords(strtolower($product->title)); 
                $product->category_name = $product->category->title ?? 'No Category';
                unset($product->category_id);
                unset($product->title);
                return $product;
            });
    }

    /**
     * Set the headings for the Excel file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Product ID',
            'Product Name',
            'Category Name',
            'MRP',
            'Offer Rate',
            'Purchase Rate',
            'Quantity'
        ];
    }

    /**
     * Transform the collection to an array format for export
     *
     * @return array
     */
    public function array(): array
    {
        return $this->collection()->map(function ($product) {
            return [
                $product->id,
                $product->formatted_title,
                $product->category_name,
            ];
        })->toArray();
    }
}
