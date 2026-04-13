<?php

namespace App\Http\Requests\TrainingSubscription;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
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
      'training_program_id' => ['sometimes', 'exists:training_programs,id'],
      'user_id' => ['sometimes', 'exists:users,id'],
    ];
  }
}