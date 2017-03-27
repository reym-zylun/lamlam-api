<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BusStop;

class BusCourse extends Model
{
    protected $table = 'bus_courses';

    static function makeRoute($busIds,$from_bus_stop_id, $to_bus_stop_id) {

        $bus_stops_tmp = BusStop::where('valid', 1)->get();
        $bus_stops = [];
        foreach($bus_stops_tmp as $bus_stop){
            $bus_stops[$bus_stop->id] = $bus_stop;
        }

        $bus_courses_tmp = self::select([
            'bus_courses.id',
            'bus_courses.course',
            'bus_courses.from_bus_stop_id',
            'bus_courses.to_bus_stop_id',
            'bus_courses.next_bus_course_id',
            'bus_courses.time',
            'busses.hex_color_code',
            'busses.interval_time'
        ])
        ->join('busses','busses.id','=','bus_courses.bus_id')
        ->where('bus_courses.valid', 1)
        ->whereIn('busses.id', $busIds)
        ->get();
        $bus_courses = [];
        foreach($bus_courses_tmp as $b_c){
            $bus_courses[$b_c->from_bus_stop_id][$b_c->to_bus_stop_id][] = [
                'id' => $b_c->id, 
                'course' => $b_c->course, 
                'from_bus_stop_id' => $b_c->from_bus_stop_id,
                'to_bus_stop_id' => $b_c->to_bus_stop_id,
                'next_bus_course_id' => $b_c->next_bus_course_id, 
                'time' => $b_c->time, 
                'hex_color_code' => $b_c->hex_color_code, 
                'interval_time' => $b_c->interval_time, 
            ];
        }

        $adjacencyMatrix = [];
        $bus_stops_1 = $bus_stops;
        $bus_stops_2 = $bus_stops;
        foreach($bus_stops_1 as $bus_stop_id_1 => $bus_stop_1){
            foreach($bus_stops_2 as $bus_stop_id_2 => $bus_stop_2){
                if(isset($bus_courses[$bus_stop_id_1][$bus_stop_id_2])){
                    $first = current($bus_courses[$bus_stop_id_1][$bus_stop_id_2]);
                    $adjacencyMatrix[$bus_stop_id_1][$bus_stop_id_2] = $first['time'];
                }else{
                    $adjacencyMatrix[$bus_stop_id_1][$bus_stop_id_2] = 0;
                }
            }
        }

        foreach ($bus_stops as $bus_stop_id => $bus_stop) {
            $currentCost[$bus_stop_id] = -1;
            $fix[$bus_stop_id]         = false;
        }

        $currentCost[$from_bus_stop_id]   = 0;
        $currentRoutes[$from_bus_stop_id] = [];

        while (true) {
            $minStation = -1;
            $minTime    = -1;
            $minRoutes  = [];

            foreach ($bus_stops as $bus_stop_id => $bus_stop) {
                if (!$fix[$bus_stop_id] && ($currentCost[$bus_stop_id] != -1)) {
                    if ($minTime == -1 || $minTime > $currentCost[$bus_stop_id]) {
                        $minTime    = $currentCost[$bus_stop_id];
                        $minStation = $bus_stop_id;
                        $minRoutes  = $currentRoutes[$bus_stop_id];
                    }
                }
            }
            if ($minTime == -1) {
                break;
            }

            // Culculate time from minStation to all bus stops
            foreach ($bus_stops as $bus_stop_id => $bus_stop) {
                if (!$fix[$bus_stop_id] && $adjacencyMatrix[$minStation][$bus_stop_id] > 0) {
                    $newRoutes = [];
                    if(count($minRoutes) > 0){
                        $newTime = -1;
                        foreach($minRoutes as $i => $minRoute){
                            $add_bus_course = [];
                            $last_course = end($minRoute);
                            $transfer_time = -1;
                            foreach($bus_courses[$minStation][$bus_stop_id] as $b_c){
                                if($last_course['next_bus_course_id'] == $b_c['id']){
                                    $transfer_time = 0;
                                    $add_bus_course = $b_c;
                                    break;
                                } 
                                if($transfer_time == -1 || $transfer_time > $b_c['interval_time']){
                                    $transfer_time = $b_c['interval_time'];
                                    $add_bus_course = $b_c;
                                }
                            }
                            if($newTime > $minTime + $adjacencyMatrix[$minStation][$bus_stop_id] + $transfer_time){
                                $newRoutes = [];
                            }
                            $newRoutes[$i] = $minRoute;
                            $newRoutes[$i][] = $add_bus_course;
                            $newTime = $minTime + $adjacencyMatrix[$minStation][$bus_stop_id] + $transfer_time; 
                        }
                    }else{
                        $newTime = $minTime + $adjacencyMatrix[$minStation][$bus_stop_id]; 
                        foreach($bus_courses[$minStation][$bus_stop_id] as $i => $add_bus_course){
                            $newRoutes[$i][] = $add_bus_course;
                        }
                    }

                    if ($currentCost[$bus_stop_id] == -1 || $currentCost[$bus_stop_id] > $newTime) {
                        // regist new Time
                        $currentCost[$bus_stop_id] = $newTime;
                        $currentRoutes[$bus_stop_id] = $newRoutes;
                    }
                }
            }
            $fix[$minStation] = true;
        }

        if(isset($currentRoutes[$to_bus_stop_id])){
            return [
                'time' => $currentCost[$to_bus_stop_id],
                'routes' => $currentRoutes[$to_bus_stop_id]
            ];
        }else{
            return [];
        }
    }
}
