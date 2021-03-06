<?php


class MongoTripRepository implements ITripRepository  {

    /**
     * 
     * @param string $id
     * @return Trip
     */
    public function findOne($id)
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
