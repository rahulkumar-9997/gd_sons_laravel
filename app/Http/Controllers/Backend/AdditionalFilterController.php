<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\AdditionalFilter;
use App\Models\AdditionalFilterAttribute;
use App\Models\AdditionalFilterAttributeValue;

class AdditionalFilterController extends Controller
{
    public function additionalFilterIndex($id)
    {
        $categories = Category::findOrFail($id);
        $additionalFilters = AdditionalFilter::with([
            'category',
            'filterAttributes.attribute',
            'filterAttributes.attributeValues.attributeValue'
        ])
        ->where('category_id', $id)
        ->latest()
        ->get();
        return view('backend.additional-filter.index', compact('additionalFilters', 'categories'));
    }

    public function additionalFilterCreate($id)
    {
        $categories = Category::where('id', $id)
            ->with([
                'attributes' => function ($query) use ($id) {
                    $query->whereHas('mappedValuesForCategory', function ($mappedQuery) use ($id) {
                        $mappedQuery->where('category_id', $id);
                    })->with([
                        'AttributesValues' => function ($valueQuery) use ($id) {
                            $valueQuery->whereHas(
                                'map_attributes_value_to_categories',
                                function ($mapQuery) use ($id) {
                                    $mapQuery->where('category_id', $id);
                                }
                            );
                        }
                    ]);
                }
            ])->first();

        $usedAttributeValueIds = AdditionalFilterAttributeValue::whereHas(
            'filterAttribute.additionalFilter',
            function ($query) use ($id) {
                $query->where('category_id', $id);
            }
        )
        ->pluck('attribute_value_id')
        ->toArray();
        return view('backend.additional-filter.create',compact('categories', 'usedAttributeValueIds')
        );
    }

    public function additionalFilterStore(Request $request)
    {
        $request->validate([
            'category_id'         => 'required',
            'filter_button_name'  => 'required|string|max:255',
        ]);
        //return response()->json($request->all());
        DB::beginTransaction();
        try {
            $additionalFilter = AdditionalFilter::create([
                'category_id'        => $request->category_id,
                'filter_button_name' => $request->filter_button_name,
                'slug'               => Str::slug($request->filter_button_name),
                'sort_order'         => 1,
                'status'             => 'active',
            ]);
            //dd($request->input('attributes'));
            if (!empty($request->input('attributes')) && is_array($request->input('attributes'))) {
                foreach ($request->input('attributes') as $attributeId) {
                    $filterAttribute = AdditionalFilterAttribute::create([
                        'additional_filter_id' => $additionalFilter->id,
                        'attribute_id'         => $attributeId,
                    ]);
                    if (
                        isset($request->attribute_values[$attributeId]) &&
                        is_array($request->attribute_values[$attributeId])
                    ) {
                        foreach ($request->attribute_values[$attributeId] as $valueId) {
                            AdditionalFilterAttributeValue::create([
                                'additional_filter_attribute_id' => $filterAttribute->id,
                                'attribute_value_id'             => $valueId,
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('additional-filter.index', $request->category_id)->with('success', 'Additional Filter Created Successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function additionalFilterEdit($id)
    {
        $additionalFilter = AdditionalFilter::with([
            'filterAttributes.attribute',
            'filterAttributes.attributeValues'
        ])->findOrFail($id);
        $categoryId = $additionalFilter->category_id;
        $categories = Category::where('id', $categoryId)
            ->with([
                'attributes' => function ($query) use ($categoryId) {
                    $query->whereHas('mappedValuesForCategory', function ($mappedQuery) use ($categoryId) {
                        $mappedQuery->where('category_id', $categoryId);
                    })->with([
                        'AttributesValues' => function ($valueQuery) use ($categoryId) {
                            $valueQuery->whereHas('map_attributes_value_to_categories', function ($mapQuery) use ($categoryId) {
                                $mapQuery->where('category_id', $categoryId);
                            });
                        }
                    ]);
                }
            ])->first();
        $selectedAttributes = $additionalFilter
            ->filterAttributes
            ->pluck('attribute_id')
            ->toArray();

        $selectedAttributeValues = [];
        foreach ($additionalFilter->filterAttributes as $filterAttribute) {
            $selectedAttributeValues[$filterAttribute->attribute_id] =
            $filterAttribute->attributeValues
            ->pluck('attribute_value_id')
            ->toArray();
        }
        return view(
            'backend.additional-filter.edit',
            compact(
                'categories',
                'additionalFilter',
                'selectedAttributes',
                'selectedAttributeValues'
            )
        );
    }

    public function additionalFilterUpdate(Request $request, $id)
    {
        $request->validate([
            'category_id'        => 'required',
            'filter_button_name' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $additionalFilter = AdditionalFilter::findOrFail($id);
            $additionalFilter->update([
                'filter_button_name' => $request->filter_button_name,
            ]);

            $oldAttributes = AdditionalFilterAttribute::where(
                'additional_filter_id',
                $additionalFilter->id
            )->get();
            foreach ($oldAttributes as $oldAttribute) {
                AdditionalFilterAttributeValue::where(
                    'additional_filter_attribute_id',
                    $oldAttribute->id
                )->delete();
            }
            AdditionalFilterAttribute::where(
                'additional_filter_id',
                $additionalFilter->id
            )->delete();
            /*Insert New Data*/
            if (!empty($request->input('attributes'))) {
                foreach ($request->input('attributes') as $attributeId) {
                    $filterAttribute = AdditionalFilterAttribute::create([
                        'additional_filter_id' => $additionalFilter->id,
                        'attribute_id'         => $attributeId,
                    ]);
                    if (
                        isset($request->attribute_values[$attributeId]) &&
                        is_array($request->attribute_values[$attributeId])
                    ) {
                        foreach ($request->attribute_values[$attributeId] as $valueId) {
                            AdditionalFilterAttributeValue::create([
                                'additional_filter_attribute_id' => $filterAttribute->id,
                                'attribute_value_id'             => $valueId,
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('additional-filter.index', $request->category_id)->with('success', 'Additional Filter Updated Successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function additionalFilterDelete($id)
    {
        DB::beginTransaction();
        try {
            $additionalFilter = AdditionalFilter::findOrFail($id);
            $filterAttributes = AdditionalFilterAttribute::where(
                'additional_filter_id',
                $id
            )->get();
            foreach ($filterAttributes as $filterAttribute) {
                AdditionalFilterAttributeValue::where(
                    'additional_filter_attribute_id',
                    $filterAttribute->id
                )->delete();
            }
            AdditionalFilterAttribute::where(
                'additional_filter_id',
                $id
            )->delete();
            $additionalFilter->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Additional Filter Deleted Successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
