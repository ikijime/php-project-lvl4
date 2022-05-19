<div class="lang-buttons">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale === $current_locale)
            <span class="">{{ $available_locale }}</span>
        @else
            <a href="/language/{{ $available_locale }}">
                <span>{{ $available_locale }}</span>
            </a>
        @endif
    @endforeach
</div>