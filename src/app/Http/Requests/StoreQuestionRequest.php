<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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
            'quiz_id' => [
                'required',
                Rule::exists('quizzes', 'id')->whereNull('deleted_at'),
            ],
            'text' => ['required', 'string', 'max:200'],
            'choices' => ['required', 'array', 'size:3'],
            'choices.0' => ['required', 'string', 'max:100'],
            'choices.1' => ['required', 'string', 'max:100'],
            'choices.2' => ['required', 'string', 'max:100'],
            'correct' => ['required', 'integer', 'between:1,3'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'quiz_id.required' => 'クイズは必須項目です。',
            'quiz_id.exists' => '存在するクイズを選択してください。',
            'text.required' => '設問は必須項目です。',
            'text.string' => '設問は文字列で入力してください。',
            'text.max' => '設問は200文字以内で入力してください。',
            'choices.0.required' => '選択肢1は必須項目です。',
            'choices.0.string' => '選択肢1は文字列で入力してください。',
            'choices.0.max' => '選択肢1は100文字以内で入力してください。',
            'choices.1.required' => '選択肢2は必須項目です。',
            'choices.1.string' => '選択肢2は文字列で入力してください。',
            'choices.1.max' => '選択肢2は100文字以内で入力してください。',
            'choices.2.required' => '選択肢3は必須項目です。',
            'choices.2.string' => '選択肢3は文字列で入力してください。',
            'choices.2.max' => '選択肢3は100文字以内で入力してください。',
            'correct.required' => '正解の選択肢は必須項目です。',
            'correct.integer' => '正解の選択肢は1から3の数字で入力してください。',
            'correct.between' => '正解の選択肢は1から3の数字で入力してください。',
        ];
    }
}
