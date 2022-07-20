<li class="slide">
    <a class="side-menu__item has-link{{ Str::contains(request()->url(), [$link]) ? ' active' : '' }}" data-bs-toggle="slide" href="{{ $link }}">
        {{ $icon }}
        <span class="side-menu__label">{{ str($text)->title() }}</span>
    </a>
</li>
