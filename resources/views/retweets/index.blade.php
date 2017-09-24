@extends('layouts.app')

@section('content')

    <div class="jumbotron">
        <h1>{{ __('twitter.title') }}</h1>
        @if($errors->any())
            <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>
        @endif
        {{ Form::open(array('route' => 'retweets.store')) }}
        <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
            {!! Form::text('url', null,  ['placeholder' => __('twitter.url_placeholder') , 'class' => 'form-control'])!!}
        </div>
        {!! Form::submit(__('twitter.submit'),['class' => 'btn btn-default'])!!}
        {!! Form::close() !!}
    </div>

    @if(!empty($data['cached']))
        <div class="alert alert-info">
            {{ __('twitter.cached') }}
        </div>
    @endif

    <ul class="list-group">
        @if(!empty($data['followers_retweeters']))
            <li class="list-group-item">
                <span class="badge">{{$data['followers_retweeters']}}</span>
                {{ __('twitter.followers_retweeters') }}
            </li>
        @endif

        @if(!empty($data['total_retweeters']))
            <li class="list-group-item">
                <span class="badge">{{$data['total_retweeters']}}</span>
                {{ __('twitter.total_retweeters') }}
            </li>
        @endif
    </ul>
@endsection
