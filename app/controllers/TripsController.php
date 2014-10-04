<?php

class TripsController extends BaseController {

    /**
     * @var TripRepositoryInterface 
     */
    private $tripRepository;
    
    public function __construct(TripRepositoryInterface $tripRepository) {
        $this->tripRepository = $tripRepository;
    }
    
    public function get($id)
    {
        $trip = $this->tripRepository->getOne($id);

        if(!$trip->exists) {
            $response = Response::make(json_encode(['error' => 'Trip not found']), 404);
            $response->header('Content-Type', 'application/json');
            return $response;
        }
        
        $response = Response::make(json_encode($trip), 200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
    
    public function create()
    {
        $trip = $this->tripRepository->create();
        
        $response = Response::make(json_encode($trip), 200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
    
    
    public function update($id)
    {
        $trip = $this->tripRepository->getOne($id);
        
        if(!$trip) {
            $response = Response::make(json_encode(['error' => 'Trip does not exist']), 409);
            $response->header('Content-Type', 'application/json');
            return $response;
        }
        
        $trip->save();
        
        $response = Response::make(json_encode($trip), 200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }

}
