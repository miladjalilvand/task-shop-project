<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Carts\Models\CartItem;
use Modules\Categories\Models\Category;

// use Modules\Products\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'discount'];

    /**
     * Get the category that this product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items associated with this product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }



    // /**
    //  * Set the discount attribute and validate its range (0–100).
    //  *
    //  * @param int $value
    //  * @throws \InvalidArgumentException
    //  */
    // public function setDiscountAttribute($value)
    // {
    //     if ($value < 0 || $value > 100) {
    //         throw new \InvalidArgumentException('Discount must be between 0 and 100.');
    //     }
    //     $this->attributes['discount'] = $value;
    // }

    // protected static function newFactory(): ProductFactory
    // {
    //     // return ProductFactory::new();
    // }
}
