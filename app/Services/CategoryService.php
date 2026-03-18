<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
  public function findAll()
  {
    return Category::all();
  }

  public function findOne($id)
  {
    return Category::find($id);
  }

  public function createCategory($data)
  {
    return Category::create($data);
  }

  public function updateCategory($id, $data)
  {
    $category = Category::find($id);
    $category->update($data);
    return $category;
  }

  public function deleteCategory($id)
  {
    $category = Category::find($id);
    $category->delete();
    return $category;
  }
}