@include('shared._error')

<div class="reply-box">
<form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
    <div class="form-group">
        <textarea name="content" rows="4" class="form-control" placeholder="分享你的见解～"> </textarea>
    </div>
    <button class="btn btn-primary btn-sm" type="submit">
        <i class="fa fa-share mr-1"> 回复</i>
    </button>
</form>
</div>
<hr>