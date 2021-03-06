@component('mail::message')
# Your parcel request is complete
Hi {{ $parcel->sender_name }},
Find your parcel request details below.

## Amount: N{{ number_format($parcel->price) }}
@component('mail::table')
| Sender details     | Receiver Details |
| :----------------- | :---------------- |
| {{ $parcel->sender_name }} | {{ $parcel->receiver_name }} |
| {{ $parcel->sender_address }} | {{ $parcel->receiver_address }} |
| {{ $parcel->sender_phone }} | {{ $parcel->receiver_phone }} |
@endcomponent
@component('mail::table')
    @if ( $parcel->items->all() )
        | Item   | Weight   | Qty |
        | :----- | :------- | :-- |
        @foreach ( $parcel->items->all() as $item )
            | {{ $item->description }} | {{ $item->weight }} | {{ $item->quantity }} |
        @endforeach
    @endif
@endcomponent

For your convenience, you can make payment online via our secured online partner by clicking on the **Pay online now** button below.

@component('mail::button', ['url' => route('parcel_checkout', ['parcel'=>$parcel])])
Pay online now
@endcomponent

If you have any questions regarding your request, please call us now on {{ config('app.contact_number') }} or send us a mail {{ config('app.contact_email') }}

Thanks,<br>
##{{ config('app.name') }}
@endcomponent
