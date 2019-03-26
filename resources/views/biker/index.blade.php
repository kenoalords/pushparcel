@extends('layouts.dashboard')

@section('content')

<div class="section is-medium">
    <div class="container">
        <div class="level is-mobile">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-3 is-size-5-mobile">Riders</h1>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <add-biker></add-biker>
                </div>
            </div>
        </div>
        <hr>
        @if ( $bikers->count() > 0 )
        <table class="table is-fullwidth">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Bike</th>
            </tr>
            @foreach($bikers as $biker)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $biker->fullname }}</td>
                    <td>{{ $biker->address }}</td>
                    <td>{{ $biker->phone }}</td>
                    <td>{{ $biker->bike }}</td>
                </tr>
            @endforeach
        </table>
        @else
            <section>
                <div class="notification is-danger">There are no riders registered</div>
            </section>
        @endif
    </div>
</div>

@endsection
