@props(['text' => 'test', 'icon' => '', 'link' => 'admin/'])
<li class="slide">
    <a class="side-menu__item has-link{{ (request()->segment(2) == explode('/', $link)[1]) ? ' active' : '' }}" data-bs-toggle="slide" href="{{ url($link) }}">
        <i class="side-menu__icon {{ $icon }}"></i>
        <span class="side-menu__label">{{ str($text)->title() }}</span>
    </a>
</li>
