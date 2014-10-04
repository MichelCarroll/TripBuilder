<?php

use Jenssegers\Mongodb\Model as Eloquent;

/**
 * Flight
 *
 * @property string $src
 * @property string $trg
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Flight extends Eloquent {

        protected $fillable = array("src", "trg");
        
        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'flights';
}
