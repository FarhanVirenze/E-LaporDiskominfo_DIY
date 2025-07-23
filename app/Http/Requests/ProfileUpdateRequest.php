<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $this->user()->id_user . ',id_user',
            ],
            'nik' => [
                'nullable',
                'string',
                'max:20',
                // Corrected unique rule: Ignore current user's NIK based on 'id_user'
                'unique:users,nik,' . $this->user()->id_user . ',id_user',
            ],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
        ];
    }
}
