<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $categorySlug = $request->query('category');
        $priceSort = $request->query('price_sort');

        $query = Product::query();

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->with('children')->first();
            if (!$category) {
                abort(404, 'دسته‌بندی یافت نشد');
            }
            $categoryIds = $this->getCategoryIds($category);
            $query->whereIn('category_id', $categoryIds);
        }

        if ($priceSort === 'highest') {
            $query->orderBy('price', 'desc');
        } elseif ($priceSort === 'lowest') {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(12);

        return view('shop.index', compact('categories', 'products', 'categorySlug', 'priceSort'));
    }

    public function show($slug)
    {
        $cartCount = Auth::check() ? Auth::user()->cart?->cartItems()->count() ?? 0 : 0;

        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.details', compact('product', 'relatedProducts','cartCount'));
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