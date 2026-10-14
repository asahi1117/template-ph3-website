<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイズ一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="p-6 text-gray-900">
                    @foreach ($quizzes as $quiz)
                        <li class="py-2 border-b border-gray-100">
                            <a href="{{ route('quizzes.show', ['quiz' => $quiz->id]) }}" class="text-gray-900">{{ $quiz->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
