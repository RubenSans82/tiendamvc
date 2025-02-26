<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table="order";
    protected $primaryKey = 'order_id';

    public function products() {
        return $this->belongsToMany(Product::class, 'order_has_product', 'order_id', 'product_id');
    }
}
?>