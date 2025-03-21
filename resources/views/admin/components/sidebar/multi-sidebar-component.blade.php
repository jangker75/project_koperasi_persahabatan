@props(['text' => 'test', 'icon' => '', 'link' => '#'])
<li class="slide">
    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
        <i class="side-menu__icon {{ $icon }}"></i>
        <span class="side-menu__label">{{ $text }}</span>
        <i class="angle fe fe-chevron-right"></i>
    </a>
    <ul class="slide-menu" style="display: {{ (request()->segment(2) == explode('/', $link)[1]) ? 'block' : 'none' }}">
        <li class="side-menu-label1"><a href="javascript:void(0)">{{ $text }}</a></li>
        {{ $slot }}
    </ul>
</li>
