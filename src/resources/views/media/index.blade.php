<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            POSSE MEDIA
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ targetId: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('status'))
                        <p class="mb-4 text-gray-900">{{ session('status') }}</p>
                    @endif
                    <a href="{{ route('media.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">記事を書く</a>
                    @if (Auth::user()?->is_admin)
                        <a href="{{ route('media.admin.index') }}" class="ml-4 text-gray-600">管理者一覧</a>
                    @endif
                </div>
                @forelse ($posts as $post)
                    <article class="px-6 pb-6 text-gray-900 border-t border-gray-100">
                        <h3 class="pt-6 text-xl font-semibold">
                            <a href="{{ route('media.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">{{ $post->user->name }}</p>
                        <p class="mt-4 leading-relaxed whitespace-pre-wrap">{{ $post->detail }}</p>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="" class="mt-4 max-w-md rounded-md">
                        <div class="mt-4">
                            @can('update', $post)
                                <a href="{{ route('media.edit', ['post' => $post->id]) }}" class="text-gray-600">編集</a>
                            @endcan
                            @can('delete', $post)
                                <button
                                    type="button"
                                    class="ml-4 text-gray-600"
                                    x-on:click="targetId = {{ $post->id }}; $dispatch('open-modal', 'confirm-post-deletion')"
                                >削除</button>
                            @endcan
                        </div>
                    </article>
                @empty
                    <p class="px-6 pb-6 text-gray-900">まだ記事はありません。</p>
                @endforelse
            </div>
        </div>

        <x-modal name="confirm-post-deletion" focusable>
            <form method="POST" class="p-6" x-bind:action="'{{ url('/media') }}/' + targetId">
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
