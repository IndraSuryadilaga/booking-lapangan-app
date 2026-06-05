<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVenueRequest extends FormRequest
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
        $venue = $this->route('venue');
        $venueId = null;

        if ($venue) {
            $venueId = is_object($venue) ? $venue->id : $venue;
        } elseif (auth()->check() && auth()->user()->isAdmin()) {
            $venueId = auth()->user()->venue?->id;
        }

        if ($venueId) {
            $nameRule = ['required', 'string', 'max:255', Rule::unique('venues', 'name')->ignore($venueId)];
        } else {
            $nameRule = ['required', 'string', 'max:255', Rule::unique('venues', 'name')];
        }

        return [
            'name' => $nameRule,
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',

            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            'refund_policy' => 'nullable|string',
            'reschedule_policy' => 'nullable|string',

            'logo' => 'nullable|image|max:5120',

            'facility_ids' => 'nullable|array',
            'facility_ids.*' => 'exists:facilities,id',

            'sports_category_ids' => 'nullable|array',
            'sports_category_ids.*' => 'exists:sports_categories,id',
        ];
    }
}
