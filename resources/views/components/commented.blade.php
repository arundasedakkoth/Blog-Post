<span class="text-primary" style="white-space: nowrap;">
    {{ $slot }}
    {{ \Carbon\Carbon::parse($date)->diffForHumans() }} | 
    @if (isset($name))
    {{ $name }}
    @endif
</span>