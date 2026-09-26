<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TrackVisitorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RecentTrainController extends Controller
{
    private const PER_PAGE = 20;

    public function feed(Request $request)
    {
        try {
            $ids = TrackVisitorProduct::latestIds();
            $version = crc32(implode(',', $ids));
            $page = max(1, (int) $request->query('page', 1));
            if ($page === 1 && (int) $request->query('v') === $version) {
                return response()->json(['changed' => false, 'version' => $version]);
            }
            return response()->json(['changed' => true, 'version' => $version] + $this->page($ids, $version, $page));
        } catch (\Throwable $e) {
            Log::error('Recent train: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    private function page(array $ids, int $version, int $page): array
    {
        $pageIds = array_slice($ids, ($page - 1) * self::PER_PAGE, self::PER_PAGE);

        $items = Cache::remember("recent_train_items_{$version}_{$page}", 600, function () use ($pageIds) {
            return $this->buildItems($pageIds);
        });

        return [
            'items'     => $items,
            'next_page' => count($ids) > $page * self::PER_PAGE ? $page + 1 : 0,
        ];
    }

    private function buildItems(array $ids): array
    {
        if (!$ids) {
            return [];
        }

        $products = Product::with([
            'category:id,title',
            'firstSortedImage:id,product_id,image_path',
            'productAttributesValues:id,product_id,product_attribute_id,attributes_value_id',
            'productAttributesValues.attributeValue:id,slug',
        ])
            ->where('product_status', 1)
            ->whereIn('id', $ids)
            ->get(['id', 'title', 'slug', 'category_id'])
            ->keyBy('id');

        $items = [];

        foreach ($ids as $id) {
            $p = $products->get($id);
            if (!$p) {
                continue;
            }

            $imagePath = optional($p->firstSortedImage)->image_path;
            $image = $imagePath && file_exists(public_path('images/product/small/' . $imagePath))
                ? asset('images/product/small/' . $imagePath)
                : 'https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png';

            $attrSlug = optional(optional($p->productAttributesValues->first())->attributeValue)->slug;

            $product = [
                'id'             => $p->id,
                'title'          => $p->title,
                'category_title' => optional($p->category)->title,
                'image'          => $image,
                'url'            => url('products/' . $p->slug . ($attrSlug ? '/' . $attrSlug : '')),
            ];

            $items[] = [
                'id'   => $p->id,
                'html' => view('frontend.pages.partials.recent-train-card', compact('product'))->render(),
            ];
        }

        return $items;
    }
}
