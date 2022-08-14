<div class="mb-2 mt-2">
    @auth
        <form action="{{ $route }}" method="POST">
            @csrf
    
            <div class="form-group">
                <textarea class="form-control" name="content" id="content" rows="2"></textarea>
            </div>
            
            <div><input type="submit" value="Add" class="btn btn-secondary w-100"></div>
            
            <x-errors></x-errors>
        </form>
        @else
        <a href="{{ route('login') }}" class="text-decoration-none text-primary">Sign in to comment</a>
    @endauth
</div>