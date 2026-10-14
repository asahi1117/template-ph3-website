<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイズ一覧
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ targetId: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('status'))
                    <p class="px-6 pt-6 text-gray-900">{{ session('status') }}</p>
                @endif
                <div class="px-6 pt-6">
                    <a href="{{ route('admin.quizzes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">新規作成</a>
                </div>
                <ul class="p-6 text-gray-900">
                    @foreach ($quizzes as $quiz)
                        <li class="py-2 border-b border-gray-100">
                            @if ($quiz->trashed())
                                <span class="text-gray-400">{{ $quiz->name }}</span>
                                <span class="ml-4 text-gray-400">削除済み</span>
                            @else
                                <a href="{{ route('admin.quizzes.questions', ['quiz' => $quiz->id]) }}" class="text-gray-900">{{ $quiz->name }}</a>
                                <a href="{{ route('admin.quizzes.edit', ['quiz' => $quiz->id]) }}" class="ml-4 text-gray-600">編集</a>
                                <button
                                    type="button"
                                    class="ml-4 text-gray-600"
                                    x-on:click="targetId = {{ $quiz->id }}; $dispatch('open-modal', 'confirm-quiz-deletion')"
                                >削除</button>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div class="px-6 pb-6">
                    {{ $quizzes->links() }}
                </div>
            </div>
        </div>

        <x-modal name="confirm-quiz-deletion" focusable>
            <form method="POST" class="p-6" x-bind:action="'{{ url('/admin/quizzes') }}/' + targetId">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">本当に削除しますか？</h2>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="targetId = null; $dispatch('close')">
                        いいえ
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        はい
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
