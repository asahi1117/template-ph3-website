<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">管理者ログイン</h1>

    <form method="POST" action="{{ route('media.admin.store') }}" class="mt-4">
        @csrf

        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="パスワード" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                ログイン
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
