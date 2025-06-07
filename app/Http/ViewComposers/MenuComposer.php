<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class MenuComposer
{
    public function compose(View $view)
    {
        /*$startTime = microtime(true);
        $categories = Category::with([
            'attributes.AttributesValues' => function ($query) {
                $query->whereHas('map_attributes_value_to_categories');
            }
        ])->get();
        
        $formattedCategories = $categories->map(function ($category) {
            $attributesWithValues = [];
        
            foreach ($category->attributes as $attribute) {
                $filteredValues = $attribute->AttributesValues->filter(function ($value) use ($category) {
                    return $value->map_attributes_value_to_categories->contains('id', $category->id);
                });
        
                if ($filteredValues->isNotEmpty()) {
                    $attributesWithValues[$attribute->title] = $filteredValues->map(function ($value) {
                        return [
                            'name' => $value->name,
                            'slug' => $value->slug
                        ];
                    })->values();
                }
            }
        
            if (!empty($attributesWithValues)) {
                return [
                    'title' => $category->title,
                    'slug' => $category->slug,
                    'attributes' => $attributesWithValues
                ];
            }
        })->filter()->values();
        $endTime = microtime(true);
        $loadingTime = $endTime - $startTime;
        Log::info('Menu, mega menu Total Loading Time (seconds): ' . $loadingTime);
        $view->with('categoriesWithMappedAttributesAndValues', $formattedCategories);
        */
        /*$startTime = microtime(true);
        $categories = Category::with([
            'attributes' => function ($query) {
                $query->whereHas('mappedCategoryToAttributesForFront');
            },
            'attributes.AttributesValues' => function ($query) {
                $query->whereHas('map_attributes_value_to_categories');
            }
        ])->orderBy('title')->get();

        $formattedCategories = $categories->map(function ($category) {
            $attributesWithValues = [];
            $mappedAttributes = $category->attributes->filter(function ($attribute) use ($category) {
                return $attribute->mappedCategoryToAttributesForFront->where('category_id', $category->id)->isNotEmpty();
            });

            $mappedAttributes = $mappedAttributes->sortBy('title');
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
        Log::info('Menu, mega menu Total Loading Time menuComposer (seconds): ' . $loadingTime);
        $view->with('categoriesWithMappedAttributesAndValues', $formattedCategories);
        */
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
        Log::info('Menu, mega menu Total Loading Time menuComposer (seconds): ' . $loadingTime);

        $view->with('categoriesWithMappedAttributesAndValues', $formattedCategories);
    }
    
}

