<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itQuiz = Quiz::create([
            'name' => 'ITクイズ',
        ]);

        $this->createQuestion($itQuiz, [
            'image' => '/image/it-quiz-01.jpg',
            'text' => '日本のIT人材が2030年には最大どれくらい不足すると言われているでしょうか？',
            'supplement' => '経済産業省「IT人材需給に関する調査」を参考にしています。',
            'choices' => [
                ['text' => '約79万人', 'is_correct' => true],
                ['text' => '約28万人', 'is_correct' => false],
                ['text' => '約183万人', 'is_correct' => false],
            ],
        ]);

        $this->createQuestion($itQuiz, [
            'image' => '/image/it-quiz-02.jpg',
            'text' => '既存業界のビジネスと、先進的なテクノロジーを結びつけて生まれた、新しいビジネスのことをなんと言うでしょう？',
            'supplement' => null,
            'choices' => [
                ['text' => 'INTECH', 'is_correct' => false],
                ['text' => 'BIZZTECH', 'is_correct' => false],
                ['text' => 'X-TECH', 'is_correct' => true],
            ],
        ]);

        $this->createQuestion($itQuiz, [
            'image' => '/image/it-quiz-03.jpg',
            'text' => 'IoTとは何の略でしょう？',
            'supplement' => null,
            'choices' => [
                ['text' => 'Internet of Things', 'is_correct' => true],
                ['text' => 'Information on Tool', 'is_correct' => false],
                ['text' => 'Integrate into Technology', 'is_correct' => false],
            ],
        ]);

        $introductionQuiz = Quiz::create([
            'name' => '紹介クイズ',
        ]);

        $this->createQuestion($introductionQuiz, [
            'image' => '/image/introduction-quiz-01.jpg',
            'text' => '出身地はどこでしょう？',
            'supplement' => null,
            'choices' => [
                ['text' => '東京', 'is_correct' => true],
                ['text' => 'ハワイ', 'is_correct' => false],
                ['text' => 'ロンドン', 'is_correct' => false],
            ],
        ]);

        $this->createQuestion($introductionQuiz, [
            'image' => '/image/introduction-quiz-02.jpg',
            'text' => '在籍中の大学はどこでしょう？',
            'supplement' => null,
            'choices' => [
                ['text' => '慶應義塾大学', 'is_correct' => true],
                ['text' => 'ハーバード大学', 'is_correct' => false],
                ['text' => 'トロント大学', 'is_correct' => false],
            ],
        ]);

        $this->createQuestion($introductionQuiz, [
            'image' => '/image/introduction-quiz-03.jpg',
            'text' => '動物に例えるとなんと言われることが多いでしょう？',
            'supplement' => null,
            'choices' => [
                ['text' => '猫', 'is_correct' => false],
                ['text' => '犬', 'is_correct' => false],
                ['text' => 'コアラ', 'is_correct' => true],
            ],
        ]);
    }

    /**
     * @param  array{image: string, text: string, supplement: string|null, choices: array<int, array{text: string, is_correct: bool}>}  $data
     */
    private function createQuestion(Quiz $quiz, array $data): void
    {
        $question = Question::create([
            'image' => $data['image'],
            'text' => $data['text'],
            'supplement' => $data['supplement'],
            'quiz_id' => $quiz->id,
        ]);

        foreach ($data['choices'] as $choice) {
            Choice::create([
                'question_id' => $question->id,
                'text' => $choice['text'],
                'is_correct' => $choice['is_correct'],
            ]);
        }
    }
}
