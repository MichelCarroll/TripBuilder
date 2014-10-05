<?php


interface IAirportRepository {

    /**
     * @return Airport[]
     */
    public function getAll();
    
    /**
     * @param string $code
     * @return Airport|null
     */
    public function findOne($code);
    
}
