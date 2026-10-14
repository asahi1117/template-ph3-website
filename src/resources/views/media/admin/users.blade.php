<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ユーザー一覧
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ targetId: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('status'))
                        <p class="mb-4 text-gray-900">{{ session('status') }}</p>
                    @endif
                    <a href="{{ route('media.admin.index') }}" class="text-gray-600">管理者一覧</a>
                </div>
                <ul class="px-6 pb-6 text-gray-900">
                    @foreach ($users as $user)
                        <li class="py-2 border-b border-gray-100">
                            @if ($user->trashed())
                                <span class="text-gray-400">{{ $user->name }}</span>
                                <span class="ml-4 text-gray-400">{{ $user->email }}</span>
                                <span class="ml-4 text-gray-400">削除済み</span>
                            @else
                                <span>{{ $user->name }}</span>
                                <span class="ml-4 text-gray-500">{{ $user->email }}</span>
                                @if (Auth::id() !== $user->id)
                                    <button
                                        type="button"
                                        class="ml-4 text-gray-600"
                                        x-on:click="targetId = {{ $user->id }}; $dispatch('open-modal', 'confirm-user-deletion')"
                                    >削除</button>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <x-modal name="confirm-user-deletion" focusable>
            <form method="POST" class="p-6" x-bind:action="'{{ url('/media/admin/users') }}/' + targetId">
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
