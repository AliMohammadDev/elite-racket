<?php

namespace App\Services;

use App\Models\Color;

class ColorService
{

  public function findAll()
  {
    return Color::all();
  }

  public function createColor(array $data)
  {
    return Color::create($data);
  }

  public function findOne(Color $color)
  {
    return $color;
  }

  public function updateColor(Color $color, array $data)
  {
    $color->update($data);
    return $color;
  }

  public function deleteColor(Color $color)
  {
    return $color->delete();
  }
}