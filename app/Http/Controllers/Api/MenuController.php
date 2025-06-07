<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
class MenuController extends Controller
{
    public function getCategoriesWithAttributes()
    {
        $startTime = microtime(true);
        
        $categories = Category::with([
            'attributes.mappedCategoryToAttributesForFront',
            'attributes.AttributesValues.map_attributes_value_to_categories'
        ])->orderBy('title')->get();

        $formattedCategories = $categories->map(function ($category) {
            $attributesWithValues = [];
            $mappedAttributes = $category->attributes->filter(function ($attribute) use ($category) {
                return $attribute->mappedCategoryToAttributesForFront->contains('category_id', $category->id);
            })->sortBy('title');

            foreach ($mappedAttributes as $attribute) {
                $filteredValues = $attribute->AttributesValues->filter(function ($value) use ($category) {
                    return $value->map_attributes_value_to_categories->contains('id', $category->id);
                });

                if ($filteredValues->isNotEmpty()) {
                    $attributesWithValues[] = [
                        'title' => $attribute->title,
                        'slug' => $attribute->slug,
                        'values' => $filteredValues->map(function ($value) {
                            return [
                                'name' => $value->name,
                                'slug' => $value->slug
                            ];
                        })->values()
                    ];
                }
            }

            if (!empty($attributesWithValues)) {
                return [
                    'title' => $category->title,
                    'category-slug' => $category->slug,
                    'category-image' => $category->image,
                    'attributes' => $attributesWithValues
                ];
            }
        })->filter()->values();

        $endTime = microtime(true);
        $loadingTime = $endTime - $startTime;
        Log::info('API Menu Loading Time (seconds): ' . $loadingTime);

        return response()->json([
            'success' => true,
            'data' => $formattedCategories,
        ]);
    }
}
