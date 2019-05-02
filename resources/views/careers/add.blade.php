@extends('layouts.app')

@section('title', 'Add Career')
@section('description', 'Looking for career opportunities in our company?')

@section('content')

<div class="section is-medium">
    <div class="container is-740">
        <h1 class="title is-2 is-size-5-mobile">Add Career</h1>
        <hr>
        @if ( session('status') )
            <div class="notification is-success">
                {{ session('status') }}. <a href="{{ route('view_career', [ 'career' => session('career') ]) }}">Click here to view</a>
            </div>
        @endif
        <form class="career-form" action="{{ route('add_career') }}" method="post">
            @csrf
            <div class="field">
                <label for="title">Job Title</label>
                <input type="text" name="title" id="title" class="input" autofocus>
            </div>
            <div class="field">
                <label for="description">Description</label>
                <textarea name="description" rows="8" class="textarea" id="description"></textarea>
            </div>
            <div class="field">
                <label for="metadescription">Short Meta Description (SEO)</label>
                <textarea name="metadescription" rows="2" maxlength="120" class="textarea"></textarea>
            </div>
            <div class="field">
                <label for="expiry">Expiry Date</label>
                <input type="date" name="expiry" id="expiry" class="input">
            </div>

            <div class="field">
                <button type="submit" name="status" class="button is-highlight" value="publish">Publish</button>
                <button type="submit" name="status" class="button is-white" value="draft">Save Draft</button>
            </div>
        </form>
    </div>
</div>

@endsection
