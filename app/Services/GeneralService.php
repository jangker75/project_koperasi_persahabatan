<?php 
  
namespace App\Services;

class GeneralService{
  
  public function convertCentimeterToPixel($centimeter){
    $pixel = (96 * $centimeter) / 2.54;
    return $pixel;
  }
}