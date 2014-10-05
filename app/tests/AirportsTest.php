<?php

class AirportsTest extends TestCase {
    
    
    private function _getFakeAirport()
    {
        $airport = new Airport();
        $airport->code = "YUL";
        $airport->city = "Montreal";
        $airport->description = "This is an airport";
        return $airport;
    }
    
    /**
     * @return void
     */
    public function testGetAirports()
    {
        $data = array(
            $this->_getFakeAirport(),
            $this->_getFakeAirport(),
            $this->_getFakeAirport(),
            $this->_getFakeAirport()
        );
        
        $mock = $this->getMock('AirportRepositoryInterface');
        $mock->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue($data));
        
        $this->app->bind('AirportRepositoryInterface', function() use ($mock) {
            return $mock;
        });
        
        $this->client->request('GET', '/airports');

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals(count($data), 4);
        $this->assertEquals($data[0]->code, 'YUL');
        $this->assertEquals($data[0]->city, 'Montreal');
        $this->assertEquals($data[0]->description, 'This is an airport');
    }
    
}
