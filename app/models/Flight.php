<?php

use Jenssegers\Mongodb\Model as Eloquent;

/**
 * Flight
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Airport $source
 * @property-read Airport $target
 */
class Flight extends Eloquent {

        protected  $fillable = array('source', 'target');


        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'flights';
        
        
        public function source()
        {
            return $this->embedsOne('Airport');
        }
        
        public function target()
        {
            return $this->embedsOne('Airport');
        }
        
        /**
         * @param Airport $source
         */
        public function setSource(Airport $source)
        {
            $this->source()->associate($source);
        }
        
        /**
         * @param Airport $target
         */
        public function setTarget(Airport $target)
        {
            $this->target()->associate($target);
        }
        
        /**
         * @return string
         */
        public function getSourceCode()
        {
            return $this->source->code;
        }
        
        /**
         * @return string
         */
        public function getTargetCode()
        {
            return $this->target->code;
        }
}
