<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\Attribute_values;
use App\Models\ProductAttributes;
use App\Models\ProductAttributesValues;
use App\Models\MapCategoryAttributes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProductsImport implements ToCollection, WithHeadingRow
{
    private $category_id;

    public function __construct($category_id)
    {
        $this->category_id = $category_id;
    }

    public function collection(Collection $rows)
    {
        /*Retrieve mapped attributes for the category*/
        $mappedAttributes = MapCategoryAttributes::where('category_id', $this->category_id)->pluck('attribute_id')->toArray();

        foreach ($rows as $row) {
            /*Skip rows if any required field is missing*/
            if (empty($row['product_name']) || empty($row['category']) ||
                empty($row['mrp']) || empty($row['sale_price']) || empty($row['brand'])) {
                continue;
            }

            /*Extract data from row*/
            $product_name = $row['product_name'];
            $category_name = $row['category'];
            $mrp = $row['mrp'];
            $sale_price = $row['sale_price'];
            $brand_name = $row['brand'];

            /*Check if product already exists*/
            $existingProduct = Product::where('title', $product_name)->first();
            if ($existingProduct) {
                continue;
            }

            /*Create or find the brand*/
            $brand = Brand::firstOrCreate(['title' => $brand_name]);

            /*Create the product*/
            $product = Product::create([
                'title' => $product_name,
                'category_id' => $this->category_id,
                'product_price' => $mrp,
                'product_sale_price' => $sale_price,
                'brand_id' => $brand->id,
            ]);

            /*Map attributes to product*/
            foreach ($mappedAttributes as $attribute_id) {
                $attribute = Attribute::find($attribute_id);
                if ($attribute) {
                    $attributeHeader = $row[$attribute->title] ?? null;
                    if ($attributeHeader) {
                        $attributeValue = Attribute_values::firstOrCreate(
                            ['name' => trim($attributeHeader), 'attributes_id' => $attribute->id],
                            ['slug' => Str::slug(trim($attributeHeader))]
                        );

                        $productAttributes = ProductAttributes::firstOrCreate([
                            'product_id' => $product->id,
                            'attributes_id' => $attribute->id,
                            'sort_order' => 0,
                        ]);

                        ProductAttributesValues::firstOrCreate([
                            'product_id' => $product->id,
                            'product_attribute_id' => $productAttributes->id,
                            'attributes_value_id' => $attributeValue->id,
                            'sort_order' => 0,
                        ]);
                    }
                }
            }
        }
    }
}
