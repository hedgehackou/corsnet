@component('mail::message')

<h2 style="text-align: center">{{__("mail.welcome", ['network' => $networkName])}}</h2> <br>

@component('mail::button', ['url' => $url])
    @lang('mail.verify_email')
@endcomponent

@endcomponent
