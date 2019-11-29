<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Room extends Model
{
     use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms';

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
    protected $fillable = ['number'];

    public function id()
    {
        return $this->belongsToMany('App\Reservation');
    }
}
