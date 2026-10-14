<?php

namespace App\Http\Requests\Auth;

class AdminLoginRequest extends LoginRequest
{
    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'password.required' => 'パスワードは必須項目です。',
        ];
    }
}
