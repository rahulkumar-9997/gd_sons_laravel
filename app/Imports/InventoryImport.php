<?php

namespace App\Imports;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventoryImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
     * Handle the imported data row.
     */
    public function model(array $row)
    {
        /*Check if inventory exists*/
        $existingInventory = Inventory::where('product_id', Product::where('id', $row['product_id'])->value('id'))
            ->where('mrp', $row['mrp'])
            ->where('purchase_rate', $row['purchase_rate'])
            ->first();

        if ($existingInventory) {
            $existingInventory->stock_quantity += $row['quantity'];
            $existingInventory->save();
        } else {
            /*Create new inventory if it does not exist*/
            return new Inventory([
                'product_id'     => Product::where('id', $row['product_id'])->value('id'),
                'mrp'            => $row['mrp'],
                'purchase_rate'  => $row['purchase_rate'],
                'offer_rate'     => $row['offer_rate'],
                'stock_quantity' => $row['quantity'],
            ]);
        }
    }

    /**
     * Validation rules for each row.
     */
    public function rules(): array
    {
        return [
            'product_name'  => ['required', 'exists:products,title'],
            'mrp'           => ['required', 'numeric'],
            'purchase_rate' => ['required', 'numeric'],
            'offer_rate'    => ['required', 'numeric'],
            'quantity'      => ['required', 'integer', 'min:1'],
        ];
    }
}
