@props(['text' => '' , 'link' => '#'])
<li><a href="{{ url($link) }}" class="slide-item{{ (request()->segment(3) == explode('/', $link)[2]) ? ' active' : '' }}">{{ $text }}</a></li>