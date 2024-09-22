<x-guest-layout>
    <div class="mb-4 text-sm text-center text-gray-600">
        <p class="text-base font-bold mb-2">パスワードをお忘れですか？</p>
        <p>
            登録済みのメールアドレスを入力してください。<br>
            パスワードリセット用のリンクを<br class="md:hidden">メールで送信します。
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}" class="text-xs text-gray-600 hover:text-gray-900">← ログインへ戻る</a>
            <x-primary-button>
                {{ __('リセットメールを送信') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
