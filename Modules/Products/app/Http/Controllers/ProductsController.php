<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products::index', compact('products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products::create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newProduct = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'discount' => ['nullable', 'integer', 'min:0', 'max:100'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB
        ]);

        //HANDLE SAFE SLUG

        if (empty($newProduct['slug'])) {
            $newProduct['slug'] = $this->makeUniqueSlug($newProduct['name']);
        }

        //HANDLE UPLOAD IMAGE
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('products', 'public');
            $newProduct['image'] = $path;
        }


        // تضمین atomic بودن ایجاد محصول
        DB::beginTransaction();
        try {
            $product = Product::create([
                'category_id' => $newProduct['category_id'] ?? null,
                'name' => $newProduct['name'],
                'slug' => $newProduct['slug'],
                'description' => $newProduct['description'] ?? null,
                'price' => $newProduct['price'],
                'stock' => $newProduct['stock'] ?? 0,
                'image' => $newProduct['image'] ?? null,
                'discount' => $newProduct['discount'] ?? 0,
            ]);

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', $product['name'] . ' با موفقیت ایجاد شد.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // در صورت آپلود تصویر و وقوع خطا، فایل را پاک کن
            if (!empty($newProduct['image']) && Storage::disk('public')->exists($newProduct['image'])) {
                Storage::disk('public')->delete($newProduct['image']);
            }

            // لاگ خطا (در صورت نیاز)
            // \Log::error($e);

            return back()->withInput()->withErrors(['error' => 'خطا در ایجاد محصول:' . $e]);
        }
    }

    protected function makeUniqueSlug(string $name, $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
       

        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
         $categories = Category::all();
        return view('products::edit',compact('product' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', \Illuminate\Validation\Rule::unique('products', 'slug')->ignore($product->id)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'discount' => ['nullable', 'integer', 'min:0', 'max:100'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB
        ]);

        // اگر slug ارائه نشده یا خالیه، از name بساز
        if (empty($data['slug'])) {
            $data['slug'] = $this->makeUniqueSlug($data['name'], $product->id);
        }

        DB::beginTransaction();
        try {
            // اگر تصویر جدید آپلود شده، اول آن را ذخیره کن و سپس تصویر قدیمی را حذف کن
            if ($request->hasFile('image')) {
                $newPath = $request->file('image')->store('products', 'public');

                // حذف تصویر قدیمی اگر وجود داشت
                if (!empty($product->image) && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $data['image'] = $newPath;
            }

            $product->update([
                'category_id' => $data['category_id'] ?? null,
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'],
                'stock' => $data['stock'] ?? 0,
                'image' => $data['image'] ?? $product->image,
                'discount' => $data['discount'] ?? 0,
            ]);

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "{$product->name} با موفقیت به‌روزرسانی شد.");
        } catch (\Throwable $e) {
            DB::rollBack();

            // اگر تصویر جدید آپلود شده و خطا رخ داده، فایل جدید را پاک کن
            if (!empty($data['image']) && Storage::disk('public')->exists($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            // \Log::error($e);

            return back()->withInput()->withErrors(['error' => 'خطا در به‌روزرسانی محصول.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            // حذف تصویر از دیسک در صورت وجود
            if (!empty($product->image) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "{$product->name} حذف شد.");
        } catch (\Throwable $e) {
            DB::rollBack();

            // \Log::error($e);

            return back()->withErrors(['error' => 'خطا در حذف محصول.']);
        }
    }
}
