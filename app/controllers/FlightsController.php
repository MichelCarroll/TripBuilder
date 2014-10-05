<?php

class FlightsController extends BaseController {

    /**
     * @var TripRepositoryInterface 
     */
    private $tripRepository;
    /**
     * @var AirportRepositoryInterface 
     */
    private $airportRepository;
    
    public function __construct(TripRepositoryInterface $tripRepository, AirportRepositoryInterface $airportRepository) 
    {
        $this->tripRepository = $tripRepository;
        $this->airportRepository = $airportRepository;
    }
    
    
    public function create($id, $src, $trg)
    {
        if($src === $trg) {
            return JsonResponse::make(['error' => 'Source and target airports cannot be the same'], 400);
        }
        
        $srcAirport = $this->airportRepository->findOne($src);
        $trgAirport = $this->airportRepository->findOne($trg);
        
        if(!$srcAirport) {
            return JsonResponse::make(['error' => 'Source airport does not exist'], 400);
        }
        
        if(!$trgAirport) {
            return JsonResponse::make(['error' => 'Target airport does not exist'], 400);
        }
        
        $trip = $this->tripRepository->findOne($id);
        
        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        $existingFlights = $trip->getFlights();
        $alreadyExists = false;
        
        /* @var $flight Flight */
        foreach($existingFlights as $flight) {
            if($flight->getSourceCode() === $src && $flight->getTargetCode() === $trg) {
                $alreadyExists = true;
                break;
            }
        }
        
        if($alreadyExists) {
            return JsonResponse::make($trip);
        }

        $flight = new Flight();
        $flight->setSource($srcAirport);
        $flight->setTarget($trgAirport);
        $trip->addFlight($flight);
        $trip->save();
                
        return JsonResponse::make($trip);
    }
    
    
    public function delete($id, $src, $trg)
    {
        $trip = $this->tripRepository->findOne($id);
        
        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        $existingFlights = $trip->getFlights();
        
        /* @var $flight Flight */
        foreach($existingFlights as $flight) {
            if($flight->getSourceCode() === $src && $flight->getTargetCode() === $trg) {
                $trip->removeFlight($flight);
                break;
            }
        }
        
        $trip->save();
        
        return JsonResponse::make($trip);
    }

}
