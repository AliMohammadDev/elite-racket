<?php

namespace App\MediaLibrary;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TrainingProgramPathGenerator implements PathGenerator
{
  public function getPath(Media $media): string
  {
    return 'training_programs/' . $media->id . '/';
  }

  public function getPathForConversions(Media $media): string
  {
    return 'training_programs/' . $media->id . '/conversions/';
  }

  public function getPathForResponsiveImages(Media $media): string
  {
    return 'training_programs/' . $media->id . '/responsive/';
  }
}