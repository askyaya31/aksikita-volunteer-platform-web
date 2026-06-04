<?php
namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'poster'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location_name'    => 'required|string|max:255',
            'location_address' => 'nullable|string',
            'city'             => 'required|string|max:100',
            'province'         => 'required|string|max:100',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'start_time'       => 'nullable|date_format:H:i',
            'end_time'         => 'nullable|date_format:H:i',
            'quota'            => 'required|integer|min:1|max:10000',
            'category_ids'     => 'required|array|min:1',
            'category_ids.*'   => 'exists:categories,id',
            'requirements'     => 'nullable|string',
            'contact_person'   => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'category_ids.required'     => 'Pilih minimal 1 kategori.',
            'category_ids.*.exists'     => 'Kategori tidak valid.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
            'poster.max'                => 'Ukuran poster maksimal 2MB.',
        ];
    }

    // DITAMBAH: validated() biasa menyertakan 'poster' (objek file) dan 'category_ids'
    // ke Event::create() → error. Method ini mengeluarkan keduanya sebelum masuk ke DB.
    public function validatedEventData(): array
    {
        $data = $this->validated();
        unset($data['poster'], $data['category_ids']);
        return $data;
    }
}