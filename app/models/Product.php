<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $table="product";
    protected $primaryKey = 'product_id';

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_has_product', 'product_id', 'order_id');
    }
    
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function provider() {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
?>