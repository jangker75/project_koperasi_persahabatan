@props(['text' => '' , 'link' => '#'])
<li><a href="{{ $link }}" class="slide-item{{ Str::contains(request()->url(), [$link]) ? ' active' : '' }}">{{ $text }}</a></li>