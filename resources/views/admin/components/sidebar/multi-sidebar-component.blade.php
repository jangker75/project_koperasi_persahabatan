<li class="slide">
    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
        {{ $icon }}
        <span class="side-menu__label">{{ $title }}</span>
        <i class="angle fe fe-chevron-right"></i>
    </a>
    <ul class="slide-menu">
        <li class="side-menu-label1"><a href="javascript:void(0)">{{ $title }}</a></li>
        {{ $slot }}
    </ul>
</li>
{{-- 
<li class="slide">
    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
        <i class="side-menu__icon fe fe-map-pin"></i>
        <span class="side-menu__label">Maps</span>
        <i class="angle fe fe-chevron-right"></i>
    </a>
    <ul class="slide-menu">
        <li class="side-menu-label1"><a href="javascript:void(0)">Maps</a></li>
        <li><a href="maps1.html" class="slide-item">Leaflet Maps</a></li>
        <li><a href="maps2.html" class="slide-item">Mapel Maps</a></li>
        <li><a href="maps.html" class="slide-item">Vector Maps</a></li>
    </ul>
</li> --}}
