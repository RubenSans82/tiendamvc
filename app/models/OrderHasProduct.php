<?php

namespace Formacom\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHasProduct extends Model
{
    protected $table = "order_has_product";
    protected $primaryKey = ['order_id', 'product_id'];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
?>
