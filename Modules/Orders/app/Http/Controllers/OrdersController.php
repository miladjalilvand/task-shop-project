<?php

namespace Modules\Orders\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Orders\Models\Order;

class OrdersController extends Controller
{
    /**
     * Display a listing of all orders with cart items count.
     */
    public function index()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        // با استفاده از authorization بهتر خواهد بود؛ اینجا ساده نگه داشته‌ام
        if ($user->role !== 'user') {
            $orders = Order::with(['cart.cartItems', 'user'])->get();
        } else {
            $orders = Order::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['cart.cartItems', 'user'])->get();
        }

        // از کالکشن لودشده استفاده کن تا کوئری اضافی نزنه
        $orders->each(function ($order) {
            $order->items_count = $order->cart ? $order->cart->cartItems->count() : 0;
        });

        return view('orders::index', compact('orders'));
    }

    /**
     * Create a new order from the user's cart.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->back()->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        DB::beginTransaction();
        try {
            $cart = $user->cart;
            if (! $cart || $cart->cartItems()->count() === 0) {
                return redirect()->back()->withErrors(['cart' => 'سبد خرید شما خالی است.']);
            }

            // Calculate total, discount, and items count from cart items
            $total = $cart->cartItems()->sum('total');
            $discount = $cart->cartItems()->sum('discount_amount');
            $itemsCount = $cart->cartItems()->count();

            // Create new order
            $order = Order::create([
                'cart_id' => $cart->id,
                'status' => 'pending', // Default status
                'discount' => $discount,
                'total' => $total,
                'items_count' => $itemsCount, // Store items count
            ]);

            // Optionally, clear cart items after order creation
            $cart->cartItems()->delete();

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'سفارش با موفقیت ایجاد شد.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'خطایی رخ داد. دوباره تلاش کنید.']);
        }
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, $orderId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->back()->withErrors(['auth' => 'ابتدا وارد سیستم شوید.']);
        }

        // Validate request
        $data = $request->validate([
            'status' => ['required', 'in:pending,processing,delivered,cancelled'],
        ]);

        DB::beginTransaction();
        try {
            $order = Order::findOrFail($orderId);

            // Restrict status updates to admins or order owner
            if ($user->role == 'user' && $order->cart->user_id !== $user->id) {
                return redirect()->back()->withErrors(['auth' => 'شما مجاز به تغییر وضعیت این سفارش نیستید.']);
            }

            $order->status = $data['status'];
            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'وضعیت سفارش با موفقیت به‌روزرسانی شد.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'خطایی رخ داد. دوباره تلاش کنید.']);
        }
    }
}
