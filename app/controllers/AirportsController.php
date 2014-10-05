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
        $airports = $this->airportRepository->getAll();
        return JsonResponse::make($airports);
    }

}
