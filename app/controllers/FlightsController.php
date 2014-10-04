<?php

class FlightsController extends BaseController {

    /**
     * @var TripRepositoryInterface 
     */
    private $tripRepository;
    
    public function __construct(TripRepositoryInterface $tripRepository) {
        $this->tripRepository = $tripRepository;
    }
    
    
    public function create($id, $src, $trg)
    {
        $trip = $this->tripRepository->findOne($id);
        
        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        $existingFlights = $trip->flights()->get();
        $alreadyExists = false;
        
        /* @var $flight Flight */
        foreach($existingFlights as $flight) {
            if($flight->src === $src && $flight->trg === $trg) {
                $alreadyExists = true;
                break;
            }
        }
        
        if(!$alreadyExists) {
            $trip->flights()->create(['src' => $src, 'trg' => $trg])->save();
        }
                
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
            if($flight->src === $src && $flight->trg === $trg) {
                $trip->flights()->destroy($flight->_id);
                break;
            }
        }
        
        return JsonResponse::make($trip);
    }

}
