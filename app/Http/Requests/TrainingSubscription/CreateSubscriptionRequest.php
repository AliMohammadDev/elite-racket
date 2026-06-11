<?php

namespace App\Http\Requests\TrainingSubscription;

use App\Models\TrainingSubscription;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
      'training_program_id' => [
        'required',
        'exists:training_programs,id',
        function ($attribute, $value, $fail) {
          $existingSubscription = TrainingSubscription::where('user_id', $this->user_id)
            ->where('training_program_id', $value)
            ->join('training_programs', 'training_subscriptions.training_program_id', '=', 'training_programs.id')
            ->where('training_programs.end_date', '>=', now())
            ->exists();

          if ($existingSubscription) {
            $fail('لديك اشتراك فعال حالياً في هذه الدورة التدريبية ولم تنتهِ بعد.');
          }
        },
      ],
      'user_id' => ['required', 'exists:users,id'],
    ];
  }
}
