<?php

namespace app\extentions\maps;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\LatLngBounds;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bounce
 *
 * @author Claude
 */
class Bounds extends LatLngBounds
{
    public function add(LatLng $coord){
         $ne = $this->getNorthEast();
        $sw = $this->getSouthWest();
        
        
        if($ne->lat == null && $ne->lng == null &&$sw->lat == null && $sw->lng == null ){
            $this->setNorthEast($coord);
            $this->setSouthWest($coord);
            return;
        }
        $new_sw_lat = $sw->lat;
        $new_sw_lng = $sw->lng;
        $new_ne_lat = $ne->lat;
        $new_ne_lng = $ne->lat;
        if($coord->lat<$sw->lat){
            $new_sw_lat = $coord->lat;
        }
        if($coord->lat>$ne->lat){
            $new_ne_lat = $coord->lat;
        }
        if($coord->lng<$sw->lng){
            $new_sw_lng = $coord->lng;
        }
        if($coord->lng>$ne->lng){
            $new_ne_lng = $coord->lng;
        }
        $this->setNorthEast(new LatLng(['lat'=>$new_ne_lat,'lng'=>$new_ne_lng]));
        $this->setSouthWest(new LatLng(['lat'=>$new_sw_lat,'lng'=>$new_sw_lng]));
        
       
    }
}
