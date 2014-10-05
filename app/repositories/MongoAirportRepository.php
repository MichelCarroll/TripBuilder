<?php


class MongoAirportRepository implements AirportRepositoryInterface  {

    
    public function getAll()
    {
        return Airport::orderBy('city', 'asc')->get();
    }
    
    
    public function findOne($code)
    {
        return Airport::query()->where('code', '=', $code)->first();
    }
    
}
