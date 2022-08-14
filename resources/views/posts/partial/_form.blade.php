<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" type="text" name="title" id="title"
        value="{{ old('title', optional($post ?? null)->title) }}">
</div>
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>
<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" name="content" id="content" rows="5">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>
@error('content')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

<div class="form-group">
    <label for="file">Thumbnail</label><br>
    <input class="form-control-file mb-2" type="file" name="thumbnail" id="thumbnail">
</div>
@error('thumbnail')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
