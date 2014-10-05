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
        $trip = $this->tripRepository->findOne($id);

        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        return JsonResponse::make($trip);
    }
    
    public function create()
    {
        $trip = $this->tripRepository->create();
        
        $name = Input::get('name', 'New Trip');
        $trip->name = $name;
        $trip->save();
        
        return JsonResponse::make($trip);
    }
    
    
    public function update($id)
    {
        $trip = $this->tripRepository->findOne($id);
        
        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        $newName = Input::get('name', null);
        if($newName) {
            $trip->name = $newName;
            $trip->save();
        }
        
        return JsonResponse::make($trip);
    }

}
