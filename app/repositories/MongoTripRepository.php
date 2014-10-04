<?php


class MongoTripRepository implements TripRepositoryInterface  {

    /**
     * 
     * @param string $id
     * @return Trip
     */
    public function getOne($id)
    {
        return Trip::find($id);
    }
    
    /**
     * @return Trip
     */
    public function create()
    {
        return Trip::create(array('name' => 'New Trip'));
    }
}
