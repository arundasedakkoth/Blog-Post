<div class="card mb-2 py-2" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title fw-bolder">{{ $title }}</h5>
        <h6 class="card-text fw-bold mb-2">{{ $sub }}</h6>
    </div>
    @if (is_a($items, 'Illuminate\Support\Collection'))
        @foreach ($items as $item)
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    {{ $item }}
                </li>
            </ul>
        @endforeach
    @else
        {{ $items }}
    @endif
</div>
