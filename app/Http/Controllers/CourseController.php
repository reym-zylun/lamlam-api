<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Bus;

class CourseController extends Controller
{
    public function getIndex() {
        $busses = \App\Bus::select([
            'id',
            'name_'.\App::getLocale().' as name'
        ])
        ->where('valid', 1)
        ->get();

        $bus_stops = \App\BusStop::select([
            'id',
            'name_'.\App::getLocale().' as name',
            'latitude',
            'longitude',
            'longitude',
            'direction',
        ])
        ->where('valid', 1)
        ->get();

        $bus_courses = \App\BusCourse::select([
            'bus_courses.id',
            'busses.id as bus_id',
            'busses.hex_color_code',
            'bus_courses.course',
            'bus_courses.from_bus_stop_id',
            'bus_courses.to_bus_stop_id'
        ])
        ->join('busses','busses.id','=','bus_courses.bus_id')
        ->where('bus_courses.valid', 1)
        ->get();

        $destinations = \App\Destination::all([
            'id',
            'name_'.\App::getLocale().' as name',
            'latitude',
            'longitude'
        ]);

        return response()->json([
            'busses' => $busses,
            'bus_stops' => $bus_stops,
            'courses' => $bus_courses,
            'destinations' => $destinations
        ]);
    }

    public function getToDestination(Request $request, $destinationId)
    {
        $validator = \Validator::make($request->all(), [
            'longitude' => 'required|numeric',
            'latitude'  => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => trans('custom.errors.validation'),
                'errors'  => $validator->errors()
            ], 422);
        }

        $busses_tmp = Bus::where('valid', 1)->orderBy('saerch_priority', 'asc')->get();
        $busses = [];
        foreach($busses_tmp as $bus){
            $busses[$bus->saerch_priority][] = $bus->id;
        }

        $routes = [];
        foreach($busses as $busIds){

            $fromBusStopIds = \App\BusStop::getNearestBusStops(
                $busIds,
                $request->input('longitude'),
                $request->input('latitude')
            );
    
            $destination = \App\Destination::find($destinationId);
    
            $toBusStopIds = explode(",", $destination->nearest_bus_stop_ids);
    
            /*
            foreach($nearest_bus_stop_ids as $nearest_bus_stop_id){
                if($bus_stop_ids[0] == $nearest_bus_stop_id){
                    return response()->json([
                        'bus_stops' => [],
                        'routes' => []
                    ]); 
                }
            }
            */
    
            $time = -1;
            foreach($toBusStopIds as $toBusStopId){
                foreach($fromBusStopIds as $fromBusStopId){
                    $tmp_routes = \App\BusCourse::makeRoute($busIds, $fromBusStopId, $toBusStopId);
                    if(count($tmp_routes) == 0){
                        continue;
                    }
                    if($time == -1 || $time > $tmp_routes['time']){
                        $routes = $tmp_routes['routes'];
                    }
                }
            }
            if(count($routes) > 0){
                break;
            }
        }
  
        // make bus stop list
        $bus_stops_tmp = \App\BusStop::getAll();
        $bus_stops = [];
        foreach($bus_stops_tmp as $bus_stop){
            $bus_stops[$bus_stop->id] = $bus_stop;
        }

        $pass_bus_stops = [];
        $courses = [];
        foreach($routes as $route){
            foreach($route as $course){
                $courses[] = $course;
                $pass_bus_stops[$course["from_bus_stop_id"]] = 
                $bus_stops[$course["from_bus_stop_id"]];
                if ($course === end($route)) {
                    $pass_bus_stops[$course["to_bus_stop_id"]] = 
                        $bus_stops[$course["to_bus_stop_id"]];
                }
            }
        }
        $bus_stops = [];
        foreach($pass_bus_stops as $bus_stop){
            $bus_stops[] = $bus_stop;
        }

        return response()->json([
            'bus_stops' => $bus_stops,
            'courses' => $courses
        ]);
    }

}
