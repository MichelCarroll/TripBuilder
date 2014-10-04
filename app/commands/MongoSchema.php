<?php

use Illuminate\Console\Command;

class MongoSchema extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mongo:schema';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initiates the project mongo schema';
        
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $this->info("Starting to build the mongo schema");
            
            Schema::create('airports', function($collection)
            {
                $collection->unique('code');
            });
            
            Schema::create('trips');
            
            $this->info("Finished building the mongo schema");
	}
}
