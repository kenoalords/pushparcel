@component('mail::message')
# New Parcel Request

## Amount: N{{ number_format($parcel->price) }}
## Payment Type: {{ $parcel->payment_type }}
@if ( $saved )
**Payment was made successfully but record not saved, please check record with ID: {{ $parcel->id }}**
@endif
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

Thanks,<br>
##{{ config('app.name') }}
@endcomponent
