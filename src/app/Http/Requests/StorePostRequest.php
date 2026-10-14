<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'detail' => ['required', 'string', 'max:2000'],
            'image' => [
                Rule::requiredIf(fn () => blank(session('media.post_draft.image'))),
                'nullable',
                'image',
                'max:2048',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須項目です。',
            'title.string' => 'タイトルは文字列で入力してください。',
            'title.max' => 'タイトルは100文字以内で入力してください。',
            'detail.required' => '詳細は必須項目です。',
            'detail.string' => '詳細は文字列で入力してください。',
            'detail.max' => '詳細は2000文字以内で入力してください。',
            'image.required' => '画像は必須項目です。',
            'image.image' => '画像は画像ファイルを指定してください。',
            'image.max' => '画像は2MB以内のファイルを指定してください。',
        ];
    }
}
