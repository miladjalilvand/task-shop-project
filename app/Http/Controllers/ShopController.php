<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $categorySlug = $request->query('category');
        
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->with('children')->first();
            if (!$category) {
                abort(404, 'دسته‌بندی یافت نشد');
            }
            $categoryIds = $this->getCategoryIds($category);
            $products = Product::whereIn('category_id', $categoryIds)->paginate(12);
        } else {
            $products = Product::paginate(12);
        }

        return view('shop.index', compact('categories', 'products', 'categorySlug'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.details', compact('product', 'relatedProducts'));
    }

    private function getCategoryIds($category)
    {
        $ids = [$category->id];
        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getCategoryIds($child));
        }
        return $ids;
    }
}