<?php

namespace App\Services;

use App\Models\Court;

class CourtService
{
  public function findAll()
  {
    return Court::latest()->get();
  }

  public function create(array $data)
  {
    return Court::create($data);
  }

  public function update(Court $court, array $data)
  {
    $filteredData = collect($data)
      ->only(['name', 'price', 'discounts'])
      ->filter(fn($value) => $value !== null && $value !== '')
      ->toArray();

    $court->update($filteredData);
    return $court;
  }

  public function delete(Court $court)
  {
    return $court->delete();
  }
}