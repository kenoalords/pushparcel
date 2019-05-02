@component('mail::message')
# Your parcel request is complete
Hi {{ $parcel->sender_name }},


The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
