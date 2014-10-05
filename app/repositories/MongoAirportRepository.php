<?php


class MongoAirportRepository implements IAirportRepository  {

    
    /**
     * @return Airport[]
     */
    public function getAll()
    {
        return Airport::orderBy('city', 'asc')->get();
    }
    
    /**
     * @param string $code
     * @return Airport|null
     */
    public function findOne($code)
    {
        return Airport::query()->where('code', '=', $code)->first();
    }
    
}
