<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $quiz->name }}
        </h2>
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }
        .quiz-choice[disabled] { cursor: default; }
        .quiz-choice.is-selected { outline: 2px solid #111827; }
        .quiz-result.is-correct { color: #047857; }
        .quiz-result.is-incorrect { color: #b91c1c; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <a href="{{ route('quizzes.index') }}" class="text-gray-600">クイズ一覧へ戻る</a>

            @foreach ($quiz->questions as $question)
                @php
                    $correctText = $question->choices->firstWhere('is_correct', true)->text;
                @endphp
                <section
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    data-answer="{{ $correctText }}"
                    x-data="{ answered: false, isCorrect: false, answerText: '', selectedId: null }"
                >
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-semibold">
                            Q{{ $loop->iteration }}. {{ $question->text }}
                        </h3>

                        <ul class="mt-4">
                            @foreach ($question->choices as $choice)
                                <li class="py-2">
                                    <button
                                        type="button"
                                        class="quiz-choice text-left text-gray-900"
                                        :disabled="answered"
                                        :class="{ 'is-selected': selectedId === {{ $choice->id }} }"
                                        @click="answered = true; selectedId = {{ $choice->id }}; isCorrect = {{ $choice->is_correct ? 'true' : 'false' }}; answerText = $el.closest('section').dataset.answer"
                                    >
                                        {{ $choice->text }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div
                            class="quiz-result mt-4"
                            x-show="answered"
                            x-cloak
                            :class="isCorrect ? 'is-correct' : 'is-incorrect'"
                        >
                            <p class="font-semibold" x-text="isCorrect ? '正解！' : '不正解...'"></p>
                            <p class="mt-2">A <span x-text="answerText"></span></p>
                        </div>

                        @if ($question->supplement)
                            <p class="mt-4 text-gray-600">{{ $question->supplement }}</p>
                        @endif
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</x-app-layout>
