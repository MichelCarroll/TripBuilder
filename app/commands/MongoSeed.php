<?php

use Illuminate\Console\Command;

class MongoSeed extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mongo:seed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Feeds initial data into mongo database';
        
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $this->info("Starting to seed the mongo database");
            
            $this->createAirport('ATL', 'Atlanta', 'Hartsfield-Jackson Atlanta International');
            $this->createAirport('PEK', 'Beijing', 'Beijing Capital International Airport ');
            $this->createAirport('LHR', 'London', 'London Heathrow');
            $this->createAirport('BKK', 'Bangkok', 'Bangkok International Suvarnabhumi Airport');
            $this->createAirport('DMK', 'Bangkok', 'Bangkok Don Mueang International Airport');
            $this->createAirport('TYO', 'Tokyo', 'Tokyo Narita');
            $this->createAirport('HND', 'Tokyo', 'Tokyo Haneda');
            $this->createAirport('YUL', 'Montreal', 'Pierre Elliot Trudeau Airport');
            $this->createAirport('YYZ', 'Toronto', 'Toronto Pearson International Airport');
            
            $this->info("Finished seeding the mongo database");
	}
        
        private function createAirport($code, $city, $desc)
        {
            try { 
                Airport::create(array(
                    'code' => $code,
                    'city' => $city,
                    'description' => $desc
                ));
            } catch (Exception $ex) {
                $this->error("$code already existed");
            }
        }
}
