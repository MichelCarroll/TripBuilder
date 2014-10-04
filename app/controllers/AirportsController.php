<?php

class AirportsController extends BaseController {

    /**
     * @var AirportRepositoryInterface 
     */
    private $airportRepository;
    
    public function __construct(AirportRepositoryInterface $airportRepo) {
        $this->airportRepository = $airportRepo;
    }
    

    public function getAll()
    {
        $airports = $this->airportRepository->retrieveAllAirports();

        $response = Response::make(json_encode($airports), 200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }

}
