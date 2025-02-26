<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $table="product";
    protected $primaryKey = 'product_id';

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_has_product', 'product_id', 'order_id');
    }
}
?>