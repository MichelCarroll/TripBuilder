<?php


class FlightsTest extends TestCase {

    private $srcCode = 'YUL';
    private $trgCode = 'YYZ';
    
    public function testCreateFlightCantFindSrc()
    {
        $id = $this->bootstrap(true, false, true);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Source airport does not exist');
    }
    
    public function testCreateFlight()
    {
        $id = $this->bootstrap(true, true, true, [], true);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertTrue($this->client->getResponse()->isOk());
    }
    
    public function testCreateFlightAlreadyExists()
    {
        $flight = $this->getMock('Flight');
        $flight->expects($this->any())->method('getSourceCode')->will($this->returnValue('YUL'));
        $flight->expects($this->any())->method('getTargetCode')->will($this->returnValue('YYZ'));
        
        $id = $this->bootstrap(true, true, true, [$flight], false);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertTrue($this->client->getResponse()->isOk());
    }
    
    public function testCreateFlightAnotherAlreadyExists()
    {
        $flight = $this->getMock('Flight');
        $flight->expects($this->any())->method('getSourceCode')->will($this->returnValue('QWE'));
        $flight->expects($this->any())->method('getTargetCode')->will($this->returnValue('ZXC'));
        
        $id = $this->bootstrap(true, true, true, [$flight], true);
        $this->client->request('PUT', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertTrue($this->client->getResponse()->isOk());
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
    
    
    public function testDeleteFlightCantFindFlight()
    {
        $flight = $this->getMock('Flight');
        $flight->expects($this->any())->method('getSourceCode')->will($this->returnValue('QWE'));
        $flight->expects($this->any())->method('getTargetCode')->will($this->returnValue('ZXC'));
        
        $id = $this->bootstrap(true, false, false, [$flight], false, false);
        $this->client->request('DELETE', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertTrue($this->client->getResponse()->isOk());
    }
    
    
    public function testDeleteFlight()
    {
        $flight = $this->getMock('Flight');
        $flight->expects($this->any())->method('getSourceCode')->will($this->returnValue('YUL'));
        $flight->expects($this->any())->method('getTargetCode')->will($this->returnValue('YYZ'));
        
        $id = $this->bootstrap(true, false, false, [$flight], false, true);
        $this->client->request('DELETE', "/trips/$id/flights/$this->srcCode,$this->trgCode");

        $this->assertTrue($this->client->getResponse()->isOk());
    }
    
    
    private function bootstrap($findTrip, $findSrc, $findTrg, array $existingFlights = [], $expectAddFlight = false, $expectRemoveFlight = false)
    {
        $fakeId = 'a82rf8fj3uvewj93';
        
        $trip = null;
        if($findTrip) {
            $trip = $this->getMock('Trip');
            $trip->expects($this->any())
                ->method('getFlights')
                ->will($this->returnValue($existingFlights));
            
            if($expectAddFlight) {
                $trip->expects($this->once())->method('addFlight');
            }
            else {
                $trip->expects($this->never())->method('addFlight');
            }
            
            if($expectRemoveFlight) {
                $trip->expects($this->once())->method('removeFlight');
            }
            else {
                $trip->expects($this->never())->method('removeFlight');
            }
        }
        
        $mockTripRepo = $this->getMock('ITripRepository');
        $mockTripRepo->expects($this->any())
            ->method('findOne')
            ->with($fakeId)
            ->will($this->returnValue($trip));
        
        $this->app->bind('ITripRepository', function() use ($mockTripRepo) {
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
        
        $mockAirRepo = $this->getMock('IAirportRepository');
        $mockAirRepo->expects($this->any())
            ->method('findOne')
            ->will($this->returnValueMap($valMap));
        
        $this->app->bind('IAirportRepository', function() use ($mockAirRepo) {
            return $mockAirRepo;
        });
        
        return $fakeId;
    }
}
