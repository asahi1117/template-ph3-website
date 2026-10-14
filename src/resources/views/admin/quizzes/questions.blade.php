<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            設問メンテナンス
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">
                        <a href="{{ route('admin.quizzes.index') }}" class="text-gray-600">クイズ一覧へ戻る</a>
                    </p>
                    <h3 class="text-lg font-medium">{{ $quiz->name }}</h3>
                    @forelse ($quiz->questions as $question)
                        <x-question-item :question="$question" :number="$loop->iteration" />
                    @empty
                        <p class="mt-4">設問はまだありません。</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
