@extends('layouts.app')
@section('content')
    <div class="jumbotron">
        <h1>{{ __('twitter.title') }}</h1>
        @include('retweets.partials._form')
    </div>
    @include('retweets.partials._results')
@endsection
