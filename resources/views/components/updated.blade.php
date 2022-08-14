<h6 class="text-muted mb-4">
    {{ $slot }}
    @if (isset($name))
        @if (isset($userId))
            <a href="{{ route('users.show', ['user' => $userId]) }}">{{ $name }}</a> |
        @else
            {{ $name }} |
        @endif
    @endif
    {{ \Carbon\Carbon::parse($date)->diffForHumans() }}
</h6>
