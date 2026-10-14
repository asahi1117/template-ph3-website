<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminQuestionController extends Controller
{
    /**
     * 管理画面の設問一覧を20件ずつ表示する。
     */
    public function index(): View
    {
        $questions = Question::withTrashed()
            ->with(['quiz' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('id')
            ->paginate(20);

        return view('admin.questions.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * 設問の新規作成フォームを表示する。
     */
    public function create(): View
    {
        $quizzes = Quiz::query()->orderBy('id')->get();

        return view('admin.questions.create', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * 設問と選択肢を登録し、設問一覧へ戻す。
     */
    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $quiz = Quiz::findOrFail($validated['quiz_id']);
        $correct = (int) $validated['correct'];

        $question = $quiz->questions()->create([
            'image' => '',
            'text' => $validated['text'],
        ]);

        $question->choices()->createMany([
            ['text' => $validated['choices'][0], 'is_correct' => $correct === 1],
            ['text' => $validated['choices'][1], 'is_correct' => $correct === 2],
            ['text' => $validated['choices'][2], 'is_correct' => $correct === 3],
        ]);

        return redirect()
            ->route('admin.questions.index')
            ->with('status', '新しい設問を作成しました！');
    }

    /**
     * 設問と選択肢の編集フォームを表示する。
     */
    public function edit(int $question): View
    {
        $questionModel = Question::with(['choices' => function ($query) {
            $query->orderBy('id');
        }])->findOrFail($question);
        $correctIndex = $questionModel->choices->values()->search(fn ($choice) => $choice->is_correct);

        return view('admin.questions.edit', [
            'question' => $questionModel,
            'choices' => $questionModel->choices->values(),
            'correct' => $correctIndex === false ? 1 : $correctIndex + 1,
            'quizzes' => Quiz::query()->orderBy('id')->get(),
        ]);
    }

    /**
     * 設問と選択肢を更新し、設問一覧へ戻す。
     */
    public function update(StoreQuestionRequest $request, int $question): RedirectResponse
    {
        $questionModel = Question::with(['choices' => function ($query) {
            $query->orderBy('id');
        }])->findOrFail($question);
        $validated = $request->validated();
        $quiz = Quiz::findOrFail($validated['quiz_id']);
        $correct = (int) $validated['correct'];

        $questionModel->text = $validated['text'];
        $quiz->questions()->save($questionModel);

        foreach ($questionModel->choices->values() as $index => $choice) {
            $choice->update([
                'text' => $validated['choices'][$index],
                'is_correct' => $correct === $index + 1,
            ]);
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('status', '更新されました！');
    }

    /**
     * 設問を論理削除し、設問一覧へ戻す。
     */
    public function destroy(int $question): RedirectResponse
    {
        $questionModel = Question::findOrFail($question);
        $questionModel->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('status', '削除しました！');
    }
}
