<?php

namespace App\Http\Requests\Couch;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCouchRequest extends FormRequest
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
      'name.en' => ['sometimes', 'string', 'max:255'],
      'name.ar' => ['sometimes', 'string', 'max:255'],

      'user_id' => ['sometimes', 'integer', 'exists:users,id'],
      'phone' => ['sometimes', 'string', 'max:20'],

      'address' => ['sometimes', 'array'],
      'address.en' => ['sometimes', 'string', 'max:255'],
      'address.ar' => ['sometimes', 'string', 'max:255'],
    ];
  }
}
