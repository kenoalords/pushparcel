@extends('layouts.dashboard')

@section('content')

<div class="section is-medium">
    <div class="container">
        <div class="level is-mobile">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-3 is-size-5-mobile">Bikes</h1>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <add-bike></add-bike>
                </div>
            </div>
        </div>
        <hr>
        @if ( $bikes->count() > 0 )
            <table class="table is-fullwidth">
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Licence</th>
                    <th>Condition</th>
                </tr>
                @foreach($bikes as $bike)
                    <tr>
                        <td><a href="#">{{ strtoupper( $bike->make ) }}</a></td>
                        <td>{{ strtoupper( $bike->model ) }}</td>
                        <td>{{ strtoupper( $bike->licence ) }}</td>
                        <td>{{ strtoupper( $bike->condition ) }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <section>
                <div class="notification is-danger">There are no bikes registered</div>
            </section>
        @endif
    </div>
</div>

@endsection
