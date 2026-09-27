<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Nama lengkap wajib diisi.',
            'name.max'        => 'Nama lengkap maksimal :max karakter.',
            'email.required'  => 'Alamat email wajib diisi.',
            'email.email'     => 'Format alamat email tidak valid.',
            'email.lowercase' => 'Alamat email harus huruf kecil semua.',
            'email.max'       => 'Alamat email maksimal :max karakter.',
            'email.unique'    => 'Alamat email sudah dipakai akun lain.',
        ];
    }
}
