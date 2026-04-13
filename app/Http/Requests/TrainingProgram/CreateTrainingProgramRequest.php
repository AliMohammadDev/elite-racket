<?php

namespace App\Http\Requests\TrainingProgram;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTrainingProgramRequest extends FormRequest
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
      'name' => ['required', 'array'],
      'name.ar' => ['required', 'string', 'max:255'],
      'name.en' => ['required', 'string', 'max:255'],
      
      'price' => ['required', 'numeric', 'min:0'],
      'discounts' => ['nullable', 'numeric', 'min:0', 'max:100'],
      'couch_id' => ['required', 'exists:couches,id'],
      'train_level' => ['required', 'in:beginner,intermediate,advanced'],
    ];
  }
}
