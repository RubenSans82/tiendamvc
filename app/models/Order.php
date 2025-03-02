<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table="order";
    protected $primaryKey = 'order_id';

    /**
     * Get the customer that owns the order.
     */
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * The products that belong to the order.
     */
    public function products() {
        return $this->belongsToMany(
            Product::class, 
            'order_has_product', 
            'order_id', 
            'product_id'
        )->withPivot('quantity', 'price');
    }

    /**
     * Calculate the order total based on products
     */
    public function getTotalAttribute() {
        $total = 0;
        foreach ($this->products as $product) {
            $price = $product->pivot->price ?? $product->price;
            $quantity = $product->pivot->quantity ?? 1;
            $total += $price * $quantity;
        }
        // Apply discount if present
        if ($this->discount > 0) {
            $total -= $total * ($this->discount / 100);
        }
        return number_format($total, 2);
    }
}
?>