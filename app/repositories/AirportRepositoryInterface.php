<?php


interface AirportRepositoryInterface {

    
    public function getAll();
    
    public function findOne($code);
    
}
