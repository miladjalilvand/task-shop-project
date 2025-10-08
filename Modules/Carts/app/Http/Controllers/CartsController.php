<?php

namespace Modules\Carts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cartItems =  $cart->cartItems;

        return view('cart::showCart',compact('cartItems'));
    }
}
