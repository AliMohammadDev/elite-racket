<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
  public function __construct(
    private CategoryService $categoryService
  ) {
  }


  public function index(): AnonymousResourceCollection
  {
    $categories = $this->categoryService->findAll();

    return CategoryResource::collection($categories);
  }


  public function store(CreateCategoryRequest $request): JsonResponse
  {
    $category = $this->categoryService->createCategory($request->validated());

    return response()->json([
      'message' => 'Created successfully',
      'data' => new CategoryResource($category)
    ], 201);
  }


  public function show(Category $category): CategoryResource
  {
    return new CategoryResource($category);
  }


  public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
  {
    $updatedCategory = $this->categoryService->updateCategory($category, $request->validated());

    return response()->json([
      'message' => 'Updated successfully',
      'data' => new CategoryResource($updatedCategory)
    ]);
  }


  public function destroy(Category $category): JsonResponse
  {
    $this->categoryService->deleteCategory($category);

    return response()->json([
      'message' => 'Deleted successfully'
    ], 200);
  }
}
