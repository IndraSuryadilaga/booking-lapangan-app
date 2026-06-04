<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFieldRequest extends FormRequest
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

        return [
            'venue_id' => ['required', $venueRule],
            'sports_category_id' => ['required', 'exists:sports_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'operating_hours' => ['required', 'array', 'size:7'],
            'operating_hours.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'operating_hours.*.open_time' => ['required_if:operating_hours.*.is_open,1', 'nullable', 'date_format:H:i'],
            'operating_hours.*.close_time' => ['required_if:operating_hours.*.is_open,1', 'nullable', 'date_format:H:i', 'after:operating_hours.*.open_time'],
            'operating_hours.*.is_open' => ['required', 'boolean'],
            'pricings' => ['required', 'array', 'size:3'],
            'pricings.*.tier' => ['required', 'string', Rule::in(['regular', 'weekend', 'holiday'])],
            'pricings.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
