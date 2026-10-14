<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('admin.quizzes.index') }}" class="text-gray-900">クイズ一覧</a>
                    <a href="{{ route('admin.questions.index') }}" class="ml-4 text-gray-900">設問一覧</a>
                    <a href="{{ route('media.admin.index') }}" class="ml-4 text-gray-900">管理者一覧</a>
                    <a href="{{ route('media.admin.users') }}" class="ml-4 text-gray-900">ユーザー一覧</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
