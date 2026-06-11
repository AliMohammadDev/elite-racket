<?php

namespace App\Http\Requests\BookingCourt;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingCourtRequest extends FormRequest
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
      'court_id' => 'sometimes|exists:courts,id',
      'booking_date' => 'sometimes|date|after_or_equal:today',
      'time_ids' => 'sometimes|array|min:1',
      'time_ids.*' => 'exists:times,id',
      'couch_id' => 'nullable|exists:couches,id',
    ];
  }
}
