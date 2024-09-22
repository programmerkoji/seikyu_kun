@component('mail::message')
# こんにちは！

{{ config('app.name') }}のパスワードリセットの申請を受付いたしました。

パスワードの再設定をご希望の場合は、以下のボタンをクリックし新しいパスワードをご登録ください。

@component('mail::button', ['url' => $resetUrl])
パスワードをリセットする
@endcomponent

このリンクは{{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }}分間有効です。

もしこのリクエストに心当たりがない場合は、このメールを無視してください。

よろしくお願いします。

{{ config('app.name') }}
@endcomponent
