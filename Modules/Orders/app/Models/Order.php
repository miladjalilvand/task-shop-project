<?php

namespace Modules\Orders\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Carts\Models\Cart;

// use Modules\Orders\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['cart_id', 'status', 'discount', 'total'];

    /**
     * Get the cart that this order belongs to.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the user that owns the order (through the cart).
     */
    public function user()
    {
        return $this->hasOneThrough(
            \App\Models\User::class, // مدل مقصد
            Cart::class,             // مدل واسط
            'id',                    // فیلد محلی در Cart (ارتباط با Cart)
            'id',                    // فیلد در User (در اینجا کلید اصلی)
            'cart_id',               // فیلد در Order که به Cart اشاره دارد
            'user_id'                // فیلد در Cart که به User اشاره دارد
        );
    }


    // protected static function newFactory(): OrderFactory
    // {
    //     // return OrderFactory::new();
    // }
}
