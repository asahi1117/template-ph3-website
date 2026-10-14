<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            記事編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('media.update', ['post' => $post->id]) }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title" value="タイトル" />
                        <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title', $post->title)" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="detail" value="詳細" />
                        <textarea id="detail" name="detail" rows="8" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('detail', $post->detail) }}</textarea>
                        <x-input-error :messages="$errors->get('detail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" value="画像" />
                        <img src="{{ asset('storage/' . $post->image) }}" alt="" class="mt-2 max-w-md rounded-md">
                        <p class="mt-2 text-sm text-gray-500">差し替えるときだけ新しい画像を選んでください。</p>
                        <input id="image" name="image" type="file" accept="image/*" class="block mt-2 text-sm text-gray-900">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-primary-button>
                            更新
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
