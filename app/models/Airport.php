<?php

use Jenssegers\Mongodb\Model as Eloquent;

/**
 * Airport
 *
 * @property string $code
 * @property string $city
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Airport extends Eloquent {

        protected $fillable = array("code", "city", "description");
        
        protected $guarded = array("id");


        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'airports';
}
