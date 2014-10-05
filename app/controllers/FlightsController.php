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
    
    public function __construct(TripRepositoryInterface $tripRepository, AirportRepositoryInterface $airportRepository) {
        $this->tripRepository = $tripRepository;
        $this->airportRepository = $airportRepository;
    }
    
    
    public function create($id, $src, $trg)
    {
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
        
        $existingFlights = $trip->flights()->get();
        $alreadyExists = false;
        
        /* @var $flight Flight */
        foreach($existingFlights as $flight) {
            if($flight->source->code === $src && $flight->target->code === $trg) {
                $alreadyExists = true;
                break;
            }
        }
        
        if($alreadyExists) {
            return JsonResponse::make($trip);
        }

        $flight = new Flight();
        $flight->source()->associate($srcAirport);
        $flight->target()->associate($trgAirport);
        $trip->flights()->associate($flight);
        $trip->save();
                
        return JsonResponse::make($trip);
    }
    
    
    public function delete($id, $src, $trg)
    {
        $trip = $this->tripRepository->findOne($id);
        
        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        $existingFlights = $trip->flights()->get();
        
        /* @var $flight Flight */
        foreach($existingFlights as $flight) {
            if($flight->source->code === $src && $flight->target->code === $trg) {
                $trip->flights()->destroy($flight->_id);
                break;
            }
        }
        
        return JsonResponse::make($trip);
    }

}
