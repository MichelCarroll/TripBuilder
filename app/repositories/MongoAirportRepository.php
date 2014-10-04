<?php


class MongoAirportRepository implements AirportRepositoryInterface  {

    
    public function retrieveAllAirports()
    {
        return Airport::orderBy('code', 'asc')->get();
    }
    
    
}
