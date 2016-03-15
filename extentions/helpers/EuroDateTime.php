<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\extentions\helpers;

use DateTime;

/**
 * Description of EuroDateTime
 *
 * @author Claude
 */
class EuroDateTime extends DateTime {
  // Override "modify()"
  public function modify($string) {
  
      // Change the modifier string if needed
      if ( $this->format('N') == 7 ) { // It's Sunday and we're calculating a day using relative weeks
          $matches = array();
          $pattern = '/this week|next week|previous week|last week/i';
          if ( preg_match( $pattern, $string, $matches )) {
              $string = str_replace($matches[0], '-7 days '.$matches[0], $string);
          }
      }
      return parent::modify($string);
  
  }
}