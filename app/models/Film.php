<?php
namespace Formacom\Models;
use Illuminate\Database\Eloquent\Model;
class Film extends Model{
    protected $table="film";
    protected $primaryKey = 'film_id';
    public function actors() {
        return $this->belongsToMany(Actor::class, 'film_actor', 'film_id', 'actor_id');
    }
}

?>