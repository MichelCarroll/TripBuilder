<?php


class FlightsTest extends TestCase {

    private $srcCode = 'YUL';
    private $trgCode = 'YYZ';
    
    private function bootstrap($findTrip, $findSrc, $findTrg)
    {
        $fakeId = 'a82rf8fj3uvewj93';
        
        $trip = null;
        if($findTrip) {
            $trip = $this->getMock('Trip');
        }
        
        $mockTripRepo = $this->getMock('TripRepositoryInterface');
        $mockTripRepo->expects($this->any())
            ->method('findOne')
            ->with($fakeId)
            ->will($this->returnValue($trip));
        
        $this->app->bind('TripRepositoryInterface', function() use ($mockTripRepo) {
            return $mockTripRepo;
        });
        
        $srcAirport = null;
        if($findSrc) {
            $srcAirport = $this->getMock('Airport');
        }
        
        $trgAirport = null;
        if($findTrg) {
            $trgAirport = $this->getMock('Airport');
        }
        
        $valMap = [
            [$this->srcCode, $srcAirport],
            [$this->trgCode, $trgAirport],
        ];
        
        $mockAirRepo = $this->getMock('AirportRepositoryInterface');
        $mockAirRepo->expects($this->any())
            ->method('findOne')
            ->will($this->returnValueMap($valMap));
        
        $this->app->bind('AirportRepositoryInterface', function() use ($mockAirRepo) {
            return $mockAirRepo;
        });
        
        return $fakeId;
    }
    
    public function testCreateFlightCantFindSrc()
    {
        $id = $this->bootstrap(true, false, true);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Source airport does not exist');
    }
    
    public function testCreateFlightCantFindTrg()
    {
        $id = $this->bootstrap(true, true, false);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Target airport does not exist');
    }
    
    public function testCreateFlightCantFindTrip()
    {
        $id = $this->bootstrap(false, true, true);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Trip does not exist');
    }
    
    
    public function testCreateFlightSameSrcTrg()
    {
        $this->client->request('PUT', "/trips/doesnotmatter/flights/$this->srcCode,$this->srcCode");

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Source and target airports cannot be the same');
    }
    
    public function testDeleteFlightCantFindTrip()
    {
        $id = $this->bootstrap(false, false, false);
        $this->client->request('DELETE', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Trip does not exist');
    }
    
}
