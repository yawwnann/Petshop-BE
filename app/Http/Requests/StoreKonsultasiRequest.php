<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKonsultasiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'status' => 'required|in:Menunggu,Diterima,Ditolak,Selesai',
            'catatan' => 'nullable|string',
            'hasil_konsultasi' => 'nullable|string',
        ];
    }
}
