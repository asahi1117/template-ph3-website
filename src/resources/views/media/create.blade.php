<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事を書く
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data" class="p-6">
                    @csrf

                    @if (session('status'))
                        <p class="mb-4 text-gray-900">{{ session('status') }}</p>
                    @endif

                    <div>
                        <x-input-label for="title" value="タイトル" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title', $draft['title'] ?? '')" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="detail" value="詳細" />
                        <textarea id="detail" name="detail" rows="8" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('detail', $draft['detail'] ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('detail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" value="画像" />
                        @if (! empty($draft['image']))
                            <img src="{{ asset('storage/' . $draft['image']) }}" alt="" class="mt-2 max-w-md rounded-md">
                            <p class="mt-2 text-sm text-gray-500">下書きの画像があります。差し替えるときだけ新しい画像を選んでください。</p>
                        @endif
                        <input id="image" name="image" type="file" accept="image/*" class="block mt-2 text-sm text-gray-900">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex gap-4">
                        <x-secondary-button type="submit" formaction="{{ route('media.draft') }}">
                            下書き保存
                        </x-secondary-button>
                        <x-primary-button>
                            投稿する
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
