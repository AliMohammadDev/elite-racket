<?php

namespace App\Http\Requests\TrainingProgram;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingProgramRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['sometimes', 'array'],
      'name.ar' => ['sometimes', 'string', 'max:255'],
      'name.en' => ['sometimes', 'string', 'max:255'],

      'price' => ['sometimes', 'numeric', 'min:0'],
      'discounts' => ['nullable', 'numeric', 'min:0', 'max:100'],
      'couch_id' => ['sometimes', 'exists:couches,id'],
      'train_level' => ['sometimes', 'in:beginner,intermediate,advanced'],

      'users_count' => ['sometimes', 'integer', 'min:1'],
      'start_date' => ['sometimes', 'date'],
      'end_date' => ['sometimes', 'date', 'after:start_date'],
    ];
  }
}
