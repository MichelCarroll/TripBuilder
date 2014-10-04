<?php

class AirportsTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        
        require_once __DIR__.'/MockAirportRepository.php';
        $this->app->bind('AirportRepositoryInterface', 'MockAirportRepository');
    }
    
    /**
     * @return void
     */
    public function testGetAirports()
    {
        $this->client->request('GET', '/airports');

        $this->assertTrue($this->client->getResponse()->isOk());
        
        $body = $this->client->getResponse()->getContent();
        $data = json_decode($body);
        
        $this->assertEquals(count($data), 4);
    }

}
