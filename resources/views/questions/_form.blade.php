<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title"
           class="form-control @error('title') is-invalid @enderror"
           placeholder="Question Title"
           value="{{old('title', $question->title)}}">
    @error('title')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

<div class="form-group">
    <label for="body">Question Details</label>
    <textarea class="form-control @error('body') is-invalid @enderror" name="body"
              id="body" rows="10">{{old('body', $question->body)}}</textarea>
    @error('body')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

<button type="submit" class="btn btn-outline-primary">{{$btnText}}</button>
