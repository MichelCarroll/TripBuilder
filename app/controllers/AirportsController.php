<?php

class AirportsController extends BaseController {

    /**
     * @var IAirportRepository 
     */
    private $airportRepository;
    
    /**
     * @param IAirportRepository $airportRepo
     */
    public function __construct(IAirportRepository $airportRepo) {
        $this->airportRepository = $airportRepo;
    }
    
    /**
     * @return Illuminate\Support\Facades\Response
     */
    public function getAll()
    {
        $airports = $this->airportRepository->getAll();
        return JsonResponse::make($airports);
    }

}
