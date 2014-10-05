<?php

class TripsTest extends TestCase {

    private function _getFakeTrip($id)
    {
        $trip = new MockTrip();
        $trip->_id = $id;
        $trip->name = 'New Fake Trip';
        return $trip;
    }
    
    private function bootstrap($findTrip)
    {
        $fakeId = 'a82rf8fj3uvewj93';
        
        $returnVal = $findTrip ? $this->_getFakeTrip($fakeId) : null;
        
        $mock = $this->getMock('ITripRepository');
        $mock->expects($this->once())
            ->method('findOne')
            ->with($fakeId)
            ->will($this->returnValue($returnVal));
        
        $this->app->bind('ITripRepository', function() use ($mock) {
            return $mock;
        });
        
        return $fakeId;
    }
    
    public function testGetExistingTrip()
    {
        $id = $this->bootstrap(true);
        $this->client->request('GET', '/trips/'.$id);

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->_id, $id);
        $this->assertEquals($data->name, 'New Fake Trip');
    }
    
    public function testGetUnexistingTrip()
    {
        $id = $this->bootstrap(false);
        $this->client->request('GET', '/trips/'.$id);

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Trip does not exist');
    }
    
    public function testPutUnexistingTrip()
    {
        $id = $this->bootstrap(false);
        $this->client->request('PUT', '/trips/'.$id);

        $this->assertFalse($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->error, 'Trip does not exist');
    }
    
    public function testPutExistingTripWithoutSettingName()
    {
        $id = $this->bootstrap(true);
        $this->client->request('PUT', '/trips/'.$id);

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->_id, $id);
        $this->assertEquals($data->name, 'New Fake Trip');
    }
    
    public function testPutExistingTripWithSettingName()
    {
        $newName = 'New New Name';
        $id = $this->bootstrap(true);
        $this->client->request('PUT', '/trips/'.$id, array('name' => $newName));

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals($data->_id, $id);
        $this->assertEquals($data->name, $newName);
    }
    
    public function testCreateTripWithoutName()
    {
        $this->client->request('POST', '/trips');

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertTrue(strlen($data->_id) > 0);
        $this->assertEquals($data->name, 'New Trip');
    }
    
    public function testCreateTripWithName()
    {
        $newName = 'New New Name';
        $this->client->request('POST', '/trips', array('name' => $newName));

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertTrue(strlen($data->_id) > 0);
        $this->assertEquals($data->name, $newName);
    }
}
