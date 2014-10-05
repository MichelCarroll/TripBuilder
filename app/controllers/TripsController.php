<?php

class TripsController extends BaseController {

    /**
     * @var ITripRepository 
     */
    private $tripRepository;
    
    /**
     * @param ITripRepository $tripRepository
     */
    public function __construct(ITripRepository $tripRepository) {
        $this->tripRepository = $tripRepository;
    }
    
    /**
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
    public function get($id)
    {
        $trip = $this->tripRepository->findOne($id);

        if(!$trip) {
            return JsonResponse::make(['error' => 'Trip does not exist'], 404);
        }
        
        return JsonResponse::make($trip);
    }
    
    /**
     * @return Illuminate\Support\Facades\Response
     */
    public function create()
    {
        $trip = $this->tripRepository->create();
        
        $name = Input::get('name');
        if(!strlen($name)) {
            $name = 'New Trip';
        }
        
        $trip->name = $name;
        $trip->save();
        
        return JsonResponse::make($trip);
    }
    
    
    /**
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
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
