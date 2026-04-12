<?php

namespace App\Services;

use App\Models\Couch;

class CouchService
{
  public function findAll()
  {
    return Couch::with('user')->latest()->get();
  }

  public function createCouch(array $data)
  {
    return Couch::create($data);
  }

  public function updateCouch(Couch $couch, array $data)
  {
    $filteredData = collect($data)
      ->only(['name', 'phone', 'address', 'user_id'])
      ->filter(fn($value) => $value !== null && $value !== '')
      ->toArray();

    $couch->update($filteredData);
    return $couch;
  }

  public function deleteCouch(Couch $couch)
  {
    return $couch->delete();
  }
}