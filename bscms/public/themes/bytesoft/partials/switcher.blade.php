@if ($supported_locales)
    @php
        $language_display = setting('language_display', 'all');
        $show_related = setting('language_show_default_item_if_current_version_not_existed', true);
    @endphp
    @if (setting('language_switcher_display', 'dropdown') == 'dropdown')
        {!! array_get($options, 'before') !!}
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">
                @if (array_get($options, 'lang_flag', true) && ($language_display == 'all' || $language_display == 'flag'))
                    {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                @endif
                @if (array_get($options, 'lang_name', true) && ($language_display == 'all' || $language_display == 'name'))
                    {{ Language::getCurrentLocaleName() }}
                @endif
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu language_bar_chooser {{ array_get($options, 'class') }}">
                @foreach ($supported_locales as $localeCode => $properties)
                    <li @if ($localeCode == Language::getCurrentLocale()) class="active" @endif>
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                           href="{{ $show_related ? Language::getLocalizedURL($localeCode) : url($localeCode) }}">
                            @if (array_get($options, 'lang_name', true) && ($language_display == 'all' || $language_display == 'name'))
                                <span>{{ $properties['lang_name'] }}</span>@endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        {!! array_get($options, 'after') !!}
    @else
        <p class="title" data-aos="fade-right" data-aos-delay="0"><img
                    src="{{ Language::getCurrentLocaleFlag() }}" alt="{{ Language::getCurrentLocaleName() }}
                    ">{{ Language::getCurrentLocaleName()}}
            <i class="fas fa-chevron-down"></i></p>
        <ul class="social-list">
            @foreach ($supported_locales as $localeCode => $properties)
                <li class="social-list__item">
                    <a rel="alternate" hreflang="{{ $localeCode }}"
                       href="{{ $show_related ? Language::getLocalizedURL($localeCode) : url($localeCode) }}"
                       class="social-item__link">
                        @if (array_get($options, 'lang_name', true) && ($language_display == 'all' || $language_display == 'name'))
                            <span>{{ $properties['lang_name'] }}</span>@endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endif