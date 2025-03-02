<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $table = "address";
    protected $primaryKey = 'address_id';

    public function customer() {
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function provider() {
        return $this->belongsTo(Provider::class, "provider_id");
    }
}
?>