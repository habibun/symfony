<?php

namespace App\Service\Geocoding;

use App\Entity\LatLng;

interface IGeocoding
{
  public function getLatLng(string $location): ?LatLng;
}
