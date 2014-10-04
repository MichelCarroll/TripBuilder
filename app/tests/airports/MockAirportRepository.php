<?php



class MockAirportRepository implements AirportRepositoryInterface  {

    private function _getFakeAirport()
    {
        $airport = new Airport();
        $airport->code = "YUL";
        $airport->city = "Montreal";
        $airport->description = "This is an airport";
        return $airport;
    }
    
    public function retrieveAllAirports()
    {
        
        return array(
            $this->_getFakeAirport(),
            $this->_getFakeAirport(),
            $this->_getFakeAirport(),
            $this->_getFakeAirport()
        );
    }
}