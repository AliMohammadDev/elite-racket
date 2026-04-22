<?php

namespace App\Services;

use App\Models\SportType;

class SportTypeService
{
  public function findAll()
  {
    return SportType::get();
  }
  public function createSportType(array $data)
  {
    return SportType::create($data);
  }

  public function findOne(SportType $sportType)
  {
    return $sportType;
  }

  public function updateSportType(SportType $sportType, array $data)
  {
    $sportType->update($data);
    return $sportType;
  }

  public function deleteSportType(SportType $sportType)
  {
    return $sportType->delete();
  }
}