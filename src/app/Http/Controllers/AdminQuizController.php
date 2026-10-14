<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminQuizController extends Controller
{
    /**
     * 管理画面のクイズ一覧を20件ずつ表示する。
     */
    public function index(): View
    {
        $quizzes = Quiz::withTrashed()->orderBy('id')->paginate(20);

        return view('admin.quizzes.index', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * 設問のメンテナンス画面を表示する。
     */
    public function questions(int $quiz): View
    {
        $quizModel = Quiz::with([
            'questions' => function ($query) {
                $query->orderBy('id');
            },
            'questions.choices' => function ($query) {
                $query->orderBy('id');
            },
        ])->findOrFail($quiz);

        return view('admin.quizzes.questions', [
            'quiz' => $quizModel,
        ]);
    }

    /**
     * タイトル編集フォームを、今のタイトルを入れた状態で表示する。
     */
    public function edit(int $quiz): View
    {
        $quizModel = Quiz::findOrFail($quiz);

        return view('admin.quizzes.edit', [
            'quiz' => $quizModel,
        ]);
    }

    /**
     * タイトルだけを更新し、管理画面の一覧へ戻す。
     */
    public function update(Request $request, int $quiz): RedirectResponse
    {
        $quizModel = Quiz::findOrFail($quiz);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $quizModel->update($validated);

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', '更新されました！');
    }

    /**
     * 新規作成フォームを表示する。
     */
    public function create(): View
    {
        return view('admin.quizzes.create');
    }

    /**
     * タイトルだけを登録し、管理画面の一覧へ戻す。
     */
    public function store(StoreQuizRequest $request): RedirectResponse
    {
        Quiz::create($request->validated());

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', '新しいクイズのタイトルを作成しました！');
    }

    /**
     * クイズを論理削除し、管理画面の一覧へ戻す。
     */
    public function destroy(int $quiz): RedirectResponse
    {
        $quizModel = Quiz::findOrFail($quiz);
        $quizModel->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('status', '削除しました！');
    }
}
