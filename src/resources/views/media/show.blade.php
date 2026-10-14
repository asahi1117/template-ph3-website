<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事詳細
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ targetId: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <article class="p-6 text-gray-900">
                    @if (session('status'))
                        <p class="mb-4 text-gray-900">{{ session('status') }}</p>
                    @endif
                    <p class="mb-4">
                        <a href="{{ route('media.index') }}" class="text-gray-600">一覧へ戻る</a>
                    </p>
                    <h3 class="text-xl font-semibold">{{ $post->title }}</h3>
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
                                x-on:click="$dispatch('open-modal', 'confirm-post-deletion')"
                            >削除</button>
                        @endcan
                    </div>
                </article>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold">コメント</h3>
                    @forelse ($post->comments as $comment)
                        <div class="mt-4 border-t border-gray-100 pt-4">
                            <p class="text-sm text-gray-500">{{ $comment->user->name }}</p>
                            <p class="mt-2 leading-relaxed whitespace-pre-wrap">{{ $comment->body }}</p>
                            <div class="mt-2">
                                @can('update', $comment)
                                    <a href="{{ route('media.comments.edit', ['comment' => $comment->id]) }}" class="text-gray-600">編集</a>
                                @endcan
                                @can('delete', $comment)
                                    <button
                                        type="button"
                                        class="ml-4 text-gray-600"
                                        x-on:click="targetId = {{ $comment->id }}; $dispatch('open-modal', 'confirm-comment-deletion')"
                                    >削除</button>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p class="mt-4">まだコメントはありません。</p>
                    @endforelse

                    @auth
                        <form method="POST" action="{{ route('media.comments.store', ['post' => $post->id]) }}" class="mt-6">
                            @csrf
                            <x-input-label for="body" value="コメント" />
                            <textarea id="body" name="body" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('body') }}</textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                            <div class="mt-4">
                                <x-primary-button>コメントする</x-primary-button>
                            </div>
                        </form>
                    @else
                        <p class="mt-6">
                            <a href="{{ route('login') }}" class="text-gray-600">ログインしてコメントする</a>
                        </p>
                    @endauth
                </div>
            </div>
        </div>

        <x-modal name="confirm-post-deletion" focusable>
            <form method="POST" action="{{ route('media.destroy', ['post' => $post->id]) }}" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">本当に削除しますか？</h2>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        いいえ
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        はい
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

        <x-modal name="confirm-comment-deletion" focusable>
            <form method="POST" class="p-6" x-bind:action="'{{ url('/media/comments') }}/' + targetId">
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
