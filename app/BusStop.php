<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BusCourses;

class BusStop extends Model
{
    protected $table = 'bus_stops';

    static function getAll()
    {
        $bus_stops = self::select([
            'id',
            'name_'.\App::getLocale().' as name',
            'latitude',
            'longitude',
            'direction'
        ])->where('valid', 1)->get();

        return $bus_stops;
    }


    static function getNearestBusStops($busIds,$long,$lat)
    {
        $busCourses = BusCourse::where('valid',1)->whereIn('bus_id',$busIds)->get(); 
        $busStopIds = [];
        foreach($busCourses as $busCourse){
            $busStopIds[$busCourse->from_bus_stop_id] = $busCourse->from_bus_stop_id;
        }
        $busStops = self::where('valid', 1)->whereIn('id',$busStopIds)->get();

        $available = [];
        foreach($busStops as $busStop) {
            $theta = $long - $busStop->longitude;
            $dist = sin(deg2rad($lat)) * sin(deg2rad($busStop->latitude)) +  cos(deg2rad($lat)) * cos(deg2rad($busStop->latitude)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            $available[$busStop->id] = $miles;
        }

        return self::getMins($available,3);
    }

    static function getMins($array, $count)
    {
        asort($array);
        $mins = [];
        foreach($array as $id => $miles){
            // get id less than 0.1miles
            if($miles < 0.1){
                $mins[] = $id;
                if(count($mins) >= $count){
                    break;
                }
            }
        }
        if(count($mins) == 0){
            reset($array);
            $mins[] = key($array);
        }
        return $mins;
    }
}
