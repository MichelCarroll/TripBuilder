<?php


interface TripRepositoryInterface {

    /**
     * @param string $id
     * @return Trip
     */
    public function getOne($id);
    
    /**
     * @return Trip
     */
    public function create();
}
