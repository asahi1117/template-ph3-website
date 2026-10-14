<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイズ新規作成
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.quizzes.store') }}" class="p-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="タイトル" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name')" autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>登録</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
