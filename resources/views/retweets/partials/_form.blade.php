@if($errors->any())
    @component('layouts.components.alert',['type'=>'danger'])
        {{$errors->first()}}
    @endcomponent
@endif
{{ Form::open(array('route' => 'retweets.store')) }}
<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
    {!! Form::text('url', null,  ['placeholder' => __('twitter.url_placeholder') , 'class' => 'form-control'])!!}
</div>
{!! Form::submit(__('twitter.submit'),['class' => 'btn btn-default'])!!}
{!! Form::close() !!}