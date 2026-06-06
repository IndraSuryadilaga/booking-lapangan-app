<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can attempt to create a booking, further logic is in the service/controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'field_id' => [
                'required',
                'exists:fields,id',
                function ($attribute, $value, $fail) {
                    $field = \App\Models\Field::find($value);
                    if ($field && !$field->is_active) {
                        $fail('Lapangan tidak ditemukan atau sedang ditutup sementara (Maintenance Mode).');
                    }
                },
            ],
            'booking_date' => 'required|date|after_or_equal:today|before_or_equal:+60 days',
            'slots' => 'required|array|min:1',
            'slots.*.start_time' => 'required|date_format:H:i:s',
            'slots.*.price' => 'required|numeric',
            'total_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'field_id.exists' => 'Lapangan tidak ditemukan atau sedang ditutup sementara (Maintenance Mode).',
            'booking_date.after_or_equal' => 'Tanggal pemesanan tidak boleh di masa lampau.',
            'slots.required' => 'Anda harus memilih setidaknya satu slot waktu.',
            'slots.min' => 'Anda harus memilih setidaknya satu slot waktu.',
        ];
    }
}
