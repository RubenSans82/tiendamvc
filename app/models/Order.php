<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table = "order";
    protected $primaryKey = 'order_id';

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function products() {
        return $this->belongsToMany(
            Product::class, 
            'order_has_product', 
            'order_id', 
            'product_id'
        )->withPivot('quantity', 'price');
    }

    public function getTotalAttribute() {
        $total = 0;
        foreach ($this->products as $product) {
            $price = $product->pivot->price ?? $product->price;
            $quantity = $product->pivot->quantity ?? 1;
            $total += $price * $quantity;
        }
        if ($this->discount > 0) {
            $total -= $total * ($this->discount / 100);
        }
        return number_format($total, 2);
    }
}
?>