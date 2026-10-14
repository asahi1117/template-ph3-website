<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('media.admin.users') }}" class="text-gray-600">ユーザー一覧</a>
                </div>
                @forelse ($posts as $post)
                    <article class="px-6 py-6 text-gray-900 border-b border-gray-100">
                        @if ($post->trashed())
                            <h3 class="text-xl font-semibold text-gray-400">{{ $post->title }}</h3>
                            <p class="mt-2 text-sm text-gray-400">{{ $post->user->name }}</p>
                            <p class="mt-4 leading-relaxed whitespace-pre-wrap text-gray-400">{{ $post->detail }}</p>
                            <p class="mt-4 text-gray-400">削除済み</p>
                        @else
                            <h3 class="text-xl font-semibold">
                                <a href="{{ route('media.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $post->user->name }}</p>
                            <p class="mt-4 leading-relaxed whitespace-pre-wrap">{{ $post->detail }}</p>
                        @endif
                    </article>
                @empty
                    <p class="p-6 text-gray-900">まだ記事はありません。</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
