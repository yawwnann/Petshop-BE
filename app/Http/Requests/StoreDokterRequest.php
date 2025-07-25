<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $dokterId = $this->route('dokter') instanceof \App\Models\Dokter
            ? $this->route('dokter')->id
            : $this->route('dokter');
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:dokters,email,' . $dokterId,
            'spesialisasi' => 'required|string|max:255',
            'no_str' => 'required|numeric',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ];
    }
}
