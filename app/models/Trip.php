<?php

use Jenssegers\Mongodb\Model as Eloquent;

/**
 * Trip
 *
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Flight[] $flights
 */
class Trip extends Eloquent {

        protected $fillable = array("name");
        
        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trips';
        

        public function flights()
        {
            return $this->embedsMany('Flight');
        }
}
