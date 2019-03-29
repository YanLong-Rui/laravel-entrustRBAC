@component('mail::message')
# 这里是龙哥的专题

The body of your message.

@component('mail::button', ['url' => ''])
验证用户
@endcomponent

应该用汉语!<br>
{{ config('app.name') }}
@endcomponent
