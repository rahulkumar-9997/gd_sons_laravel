<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Category;
use App\Models\Blog;
use App\Models\BlogCategory;

class SharedDataComposer
{
    protected static $cachedBlogCategories = null;
    protected static $cachedCategories = null;
    public function compose(View $view)
    {
        if (is_null(self::$cachedCategories)) {
            self::$cachedCategories = Category::orderBy('id', 'desc')->get();
        }
        
        if (is_null(self::$cachedBlogCategories)) {
            self::$cachedBlogCategories = BlogCategory::withCount('blogs')
                ->where('status', 1)
                ->orderBy('title')
                ->get()
                ->filter(fn ($category) => $category->blogs_count > 0);
        }
        $view->with([
            'category_for_footer' => self::$cachedCategories,
            'blogCategories' => self::$cachedBlogCategories,
            'blog_for_footer' => self::$cachedBlogCategories,
        ]);
    }
}