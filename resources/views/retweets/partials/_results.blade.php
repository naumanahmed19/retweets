@if(!empty($data['cached']))
    @component('layouts.components.alert')
        {{ __('twitter.cached') }}
    @endcomponent
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