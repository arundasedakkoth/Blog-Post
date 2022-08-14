@if (!isset($show) || $show)
<div class="alert alert-{{ $type ?? 'info' }}">
    {{ $slot }}
</div>
@endif