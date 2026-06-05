<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = auth()->user();
        $venueRule = Rule::exists('venues', 'id');
        if ($user && $user->isAdmin()) {
            $venueRule->where('admin_id', $user->id);
        }

        $rules = [
            'venue_id' => ['required', $venueRule],
            'sports_category_id' => ['required', 'exists:sports_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:10000'],
            'operating_hours' => ['required', 'array', 'size:7'],
            'pricings' => ['required', 'array', 'size:3'],
            'pricings.*.tier' => ['required', 'string', Rule::in(['regular', 'weekend', 'holiday'])],
            'pricings.*.price' => ['required', 'numeric', 'min:0'],
        ];

        $operatingHours = $this->input('operating_hours', []);
        if (is_array($operatingHours)) {
            foreach ($operatingHours as $index => $hour) {
                $rules["operating_hours.{$index}.day_of_week"] = ['required', 'integer', 'between:0,6'];
                $rules["operating_hours.{$index}.is_open"] = ['required', 'boolean'];

                $isOpen = isset($hour['is_open']) && filter_var($hour['is_open'], FILTER_VALIDATE_BOOLEAN);
                if ($isOpen) {
                    $rules["operating_hours.{$index}.open_time"] = ['required', 'date_format:H:i'];
                    $rules["operating_hours.{$index}.close_time"] = ['required', 'date_format:H:i', "after:operating_hours.{$index}.open_time"];
                } else {
                    $rules["operating_hours.{$index}.open_time"] = ['nullable', 'date_format:H:i'];
                    $rules["operating_hours.{$index}.close_time"] = ['nullable', 'date_format:H:i'];
                }
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'operating_hours.*.close_time.after' => 'Jam tutup harus lebih besar dari jam buka.',
        ];
    }
}
