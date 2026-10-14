<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            設問編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.questions.update', ['question' => $question->id]) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="quiz_id" value="クイズ" />
                        <select id="quiz_id" name="quiz_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">選択してください</option>
                            @foreach ($quizzes as $quiz)
                                <option value="{{ $quiz->id }}" @selected(old('quiz_id', $question->quiz_id) == $quiz->id)>{{ $quiz->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('quiz_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="text" value="設問" />
                        <x-text-input id="text" name="text" type="text" class="block mt-1 w-full" :value="old('text', $question->text)" autofocus />
                        <x-input-error :messages="$errors->get('text')" class="mt-2" />
                    </div>

                    @foreach ([1, 2, 3] as $number)
                        <div class="mt-4">
                            <x-input-label for="choice-{{ $number }}" value="選択肢{{ $number }}" />
                            <x-text-input id="choice-{{ $number }}" name="choices[]" type="text" class="block mt-1 w-full" :value="old('choices.' . ($number - 1), $choices[$number - 1]->text)" />
                            <x-input-error :messages="$errors->get('choices.' . ($number - 1))" class="mt-2" />
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <x-input-label value="正解" />
                        <div class="mt-2 flex gap-6">
                            @foreach ([1, 2, 3] as $number)
                                <label for="correct-{{ $number }}" class="inline-flex items-center text-gray-900">
                                    <input id="correct-{{ $number }}" name="correct" type="radio" value="{{ $number }}" class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('correct', $correct) == $number)>
                                    <span class="ms-2">選択肢{{ $number }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('correct')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>更新</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
