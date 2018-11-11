@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    @php
        array_set($options['attr'], 'class', array_get($options['attr'], 'class') . ' ui-select');
        $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null;
    @endphp
    {!! Form::customSelect($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) !!}
    @include('core.base::forms.partials.help_block')
@endif

@include('core.base::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
