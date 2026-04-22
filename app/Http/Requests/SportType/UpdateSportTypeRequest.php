<?php

namespace App\Http\Requests\SportType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSportTypeRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return false;
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

      'body' => ['sometimes', 'array'],
      'body.en' => ['sometimes', 'string', 'max:1000'],
      'body.ar' => ['sometimes', 'string', 'max:1000'],
    ];
  }
}