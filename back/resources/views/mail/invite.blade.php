@component('mail::message')

<h2 style="text-align: center">@lang('mail.welcome')</h2> <br>

@component('mail::button', ['url' => $url])
    @lang('mail.accept_invite')
@endcomponent

@endcomponent
