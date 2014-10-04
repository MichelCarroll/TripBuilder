<?php


class JsonResponse 
{
    
    /**
     * 
     * @param mixed $data
     * @param integer $status
     * @return Illuminate\Support\Facades\Response
     */
    public static function make($data, $status = 200)
    {
        $response = Response::make(json_encode($data), $status);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
    
}
