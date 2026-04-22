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

  public function findOne(SportType $product)
  {
    return $product;
  }

  public function updateSportType(SportType $product, array $data)
  {
    $product->update($data);
    return $product;
  }

  public function deleteSportType(SportType $product)
  {
    return $product->delete();
  }
}
