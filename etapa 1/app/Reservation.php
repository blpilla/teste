<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservations';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'room_id', 'date'];

    public function user_id()
    {
        return $this->belongsToMany('App\User');
    }
    public function room_id()
    {
        return $this->belongsToMany('App\Room');
    }

}
