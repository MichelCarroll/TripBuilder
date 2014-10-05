<?php


interface ITripRepository {

    /**
     * @param string $id
     * @return Trip
     */
    public function findOne($id);
    
    /**
     * @return Trip
     */
    public function create();
}
