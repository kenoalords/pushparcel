@component('mail::message')
# Thank you! Your payment have been confirmed.
Hi {{ ucwords(strtolower($parcel->sender_name)) }},

Your parcel delivery request is complete and payment confirmed, please find your details below.

## Transaction Reference: {{ strtoupper($parcel->payment->transaction_ref) }}
## Amount: N{{ number_format($parcel->payment->amount) }}
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

If you have any questions regarding your request, please call us now on {{ config('app.contact_number') }} or send us a mail {{ config('app.contact_email') }}

Thanks,<br>
## {{ config('app.name') }}
@endcomponent
