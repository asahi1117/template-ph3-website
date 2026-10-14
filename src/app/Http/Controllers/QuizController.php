<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\View\View;

class QuizController extends Controller
{
    /**
     * クイズの一覧を表示する。
     */
    public function index(): View
    {
        $quizzes = Quiz::all();

        return view('quizzes.index', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * URLの番号で指定されたクイズを、設問と選択肢までまとめて表示する。
     */
    public function show(int $quiz): View
    {
        $quizModel = Quiz::with([
            'questions' => function ($query) {
                $query->orderBy('id');
            },
            'questions.choices' => function ($query) {
                $query->orderBy('id');
            },
        ])->findOrFail($quiz);

        return view('quizzes.show', [
            'quiz' => $quizModel,
        ]);
    }
}
