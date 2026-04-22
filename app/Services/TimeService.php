<?php

namespace App\Services;

use App\Models\Time;

class TimeService
{
  public function findAll()
  {
    return Time::get();
  }
  public function createTime(array $data)
  {
    return Time::create($data);
  }

  public function findOne(Time $time)
  {
    return $time;
  }

  public function updateTime(Time $time, array $data)
  {
    $time->update($data);
    return $time;
  }

  public function deleteTime(Time $time)
  {
    return $time->delete();
  }
}