<?php

namespace Modules\Carts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Carts\Models\CartItem;
use Modules\Products\Models\Product;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('carts::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('carts::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('carts::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('carts::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function showCart()
    {
        $user = Auth::user();
        $cart = $user->cart;
        $cartItems = $cart->cartItems;

        return view('cart::showCart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        // اعتبارسنجی اولیه
        $data = $request->validate([
            'cart_id'    => ['nullable', 'exists:carts,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $user = Auth::user();
        if (! $user) {
            return redirect()->back()->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        // مقدار پیش‌فرض برای quantity
        $quantity = $data['quantity'] ?? 1;

        // پیدا کردن محصول
        $product = Product::find($data['product_id']);
        if (! $product) {
            return redirect()->back()->withErrors(['product' => 'محصول پیدا نشد.']);
        }

        DB::beginTransaction();
        try {
            $cart = $user->cart;
            // قیمت واحد در زمان اضافه شدن (snapshot)
            $unitPrice = $product->price;
            $discountPercent = $product->discount ?? 0;

            // محاسبات
            $subtotal = $unitPrice * $quantity;
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $totalAfterDiscount = $subtotal - $discountAmount;

            // بررسی وجود محصول در سبد خرید
            $existingItem = $cart->cartItems()->where('product_id', $product->id)->first();

            if (!$existingItem) {
                // ایجاد آیتم جدید
                CartItem::create([
                    'cart_id'         => $cart->id,
                    'product_id'      => $product->id,
                    'quantity'        => $quantity,
                    'price'           => $unitPrice,
                    'total'           => $totalAfterDiscount,
                    'discount_amount' => $discountAmount,
                ]);
            } else {
                return redirect()->back()->withErrors(['error' => 'قبلا به سبد خرید اضافه شده !!']);
            }

            DB::commit();
            return redirect()->back()->with('success', 'محصول با موفقیت به سبد اضافه شد.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'خطایی رخ داد. دوباره تلاش کنید.']);
        }
    }

    /**
     * Increase the quantity of a cart item
     */
    public function addQuantity(Request $request, $cartItemId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->back()->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        DB::beginTransaction();
        try {
            $cartItem = CartItem::where('cart_id', $user->cart->id)
                ->where('id', $cartItemId)
                ->first();

            if (! $cartItem) {
                return redirect()->back()->withErrors(['error' => 'آیتم سبد خرید یافت نشد.']);
            }

            $product = Product::find($cartItem->product_id);
            if (! $product) {
                return redirect()->back()->withErrors(['product' => 'محصول یافت نشد.']);
            }

            // افزایش تعداد
            $cartItem->quantity += 1;
            
            // به‌روزرسانی قیمت‌ها
            $subtotal = $cartItem->price * $cartItem->quantity;
            $discountPercent = $product->discount ?? 0;
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $cartItem->total = $subtotal - $discountAmount;
            $cartItem->discount_amount = $discountAmount;

            $cartItem->save();

            DB::commit();
            return redirect()->back()->with('success', 'تعداد محصول با موفقیت افزایش یافت.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'خطایی رخ داد. دوباره تلاش کنید.']);
        }
    }

    /**
     * Decrease the quantity of a cart item
     */
    public function loseQuantity(Request $request, $cartItemId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->back()->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        DB::beginTransaction();
        try {
            $cartItem = CartItem::where('cart_id', $user->cart->id)
                ->where('id', $cartItemId)
                ->first();

            if (! $cartItem) {
                return redirect()->back()->withErrors(['error' => 'آیتم سبد خرید یافت نشد.']);
            }

            $product = Product::find($cartItem->product_id);
            if (! $product) {
                return redirect()->back()->withErrors(['product' => 'محصول یافت نشد.']);
            }

            // کاهش تعداد
            if ($cartItem->quantity <= 1) {
                $cartItem->delete();
                DB::commit();
                return redirect()->back()->with('success', 'آیتم از سبد خرید حذف شد.');
            }

            $cartItem->quantity -= 1;
            
            // به‌روزرسانی قیمت‌ها
            $subtotal = $cartItem->price * $cartItem->quantity;
            $discountPercent = $product->discount ?? 0;
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $cartItem->total = $subtotal - $discountAmount;
            $cartItem->discount_amount = $discountAmount;

            $cartItem->save();

            DB::commit();
            return redirect()->back()->with('success', 'تعداد محصول با موفقیت کاهش یافت.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'خطایی رخ داد. دوباره تلاش کنید.']);
        }
    }

    /**
     * Clear all cart items for the user
     */
    public function clearCart(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->back()->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        DB::beginTransaction();
        try {
            $cart = $user->cart;
            $cart->cartItems()->delete();

            DB::commit();
            return redirect()->back()->with('success', 'سبد خرید با موفقیت خالی شد.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'خطایی رخ داد. دوباره تلاش کنید.']);
        }
    }
}