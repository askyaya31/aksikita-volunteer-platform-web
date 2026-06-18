<?php
namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'title'            => 'sometimes|string|max:255',
            'description'      => 'sometimes|string',
            'poster'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location_name'    => 'sometimes|string|max:255',
            'location_address' => 'nullable|string',
            'city'             => 'sometimes|string|max:100',
            'province'         => 'sometimes|string|max:100',
            'start_date'       => 'sometimes|date',
            'end_date'         => 'sometimes|date|after_or_equal:start_date',
            'start_time'       => 'nullable|date_format:H:i',
            'end_time'         => 'nullable|date_format:H:i',
            'quota'            => 'sometimes|integer|min:1|max:10000',
            'category_ids'     => 'sometimes|array|min:1',
            'category_ids.*'   => 'exists:categories,id',
            'requirements'     => 'nullable|string',
            'contact_person'   => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'category_ids.*.exists' => 'Kategori tidak valid.',
            'poster.max'            => 'Ukuran poster maksimal 2MB.',
        ];
    }

    public function validatedEventData(): array
    {
        $data = $this->validated();
        unset($data['poster'], $data['category_ids']);
        return $data;
    }
}