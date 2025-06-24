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
        $startTime = microtime(true);
        /*** */
        /*** */
        /*** */
        /*** */
        /*** */
        /*** */
        /*** */
        /** Note => Without caching use query */


        /*$categories = Category::with([
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
        */
        /*** */
        /*** */
        /*** */
        /*** */
        /*** */
        /*** */
        /*** */
        /** Note => Added Caching: The menu data is now cached for 24 hours, significantly reducing database queries. */
        $categories = Cache::remember('mega_menu_data', now()->addHours(24), function () {
            return Category::query()
                ->with([
                    'attributes' => function ($query) {
                        $query->whereHas('mappedCategoryToAttributesForFront')
                            ->orderBy('title');
                    },
                    'attributes.AttributesValues' => function ($query) {
                        $query->whereHas('map_attributes_value_to_categories');
                    },
                    'attributes.mappedCategoryToAttributesForFront',
                    'attributes.AttributesValues.map_attributes_value_to_categories'
                ])
                ->orderBy('title')
                ->get()
                ->map(function ($category) {
                    $attributesWithValues = $category->attributes
                        ->filter(function ($attribute) use ($category) {
                            return $attribute->mappedCategoryToAttributesForFront
                                ->contains('category_id', $category->id);
                        })
                        ->map(function ($attribute) use ($category) {
                            $values = $attribute->AttributesValues
                                ->filter(function ($value) use ($category) {
                                    return $value->map_attributes_value_to_categories
                                        ->contains('id', $category->id);
                                })
                                ->map(function ($value) {
                                    return [
                                        'name' => $value->name,
                                        'slug' => $value->slug
                                    ];
                                })
                                ->values();

                            return $values->isNotEmpty() ? [
                                'title' => $attribute->title,
                                'slug' => $attribute->slug,
                                'values' => $values
                            ] : null;
                        })
                        ->filter()
                        ->values();

                    return $attributesWithValues->isNotEmpty() ? [
                        'title' => $category->title,
                        'category-slug' => $category->slug,
                        'category-image' => $category->image,
                        'attributes' => $attributesWithValues
                    ] : null;
                })
                ->filter()
                ->values();
        });

        $view->with('categoriesWithMappedAttributesAndValues', $categories);
        
    }
    
}

