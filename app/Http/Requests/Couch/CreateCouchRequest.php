<?php

namespace App\Http\Requests\Couch;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCouchRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255'],
      'user_id' => ['required', 'integer', 'exists:users,id'],
      'phone' => ['required', 'string', 'max:20'],
      'address' => ['nullable', 'string', 'max:500'],
    ];
  }
}
