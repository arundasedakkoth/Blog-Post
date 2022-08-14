<div class="container">
    <div class="row">

        <x-card title="{{ __('Most Commented') }}" sub="{{ __('What people are currently talking about') }}">
            @slot('items')
                @foreach ($mostCommented as $post)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}"
                                class="text-dark text-decoration-none">{{ $post->title }}
                            </a>
                        </li>
                    </ul>
                @endforeach
            @endslot
        </x-card>

        <x-card title="{{ __('Most Active') }}" sub="{{ __('Writers with most posts written') }}" :items="collect($mostActive)->pluck('name')">
        </x-card>

        <x-card title="{{ __('Most Active Last Month') }}" sub="{{ __('Users with most posts written in the month') }}" :items="collect($mostActiveLastMonth)->pluck('name')">
        </x-card>

    </div>
</div>
