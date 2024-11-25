<div>
    <form action="{{ route('idea.comments.store', $idea->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="fs-6 form-control" rows="1"></textarea>
            @error('content')
                <span class="d-block fs-6 text-danger"> {{$message}} </span>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
        </div>
        <hr>

        @foreach ($idea->comments as $comment)
        <div class="d-flex align-items-start mb-2">
            @if ($comment->user->profile_picture)
                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}"
                 alt="{{ $comment->user->name }}'s Avatar"
                 class="rounded-circle me-2" width="50" height="50">
            @else
                <img src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $comment->user->name }}"
                 alt="{{ $comment->user->name }} Avatar"
                 class="rounded-circle me-2" width="50" height="50">
            @endif


            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <h6 class="">{{ $comment->user->name }}</h6>
                    <small class="fs-6 fw-light text-muted"> {{ $comment->created_at }}</small>
                </div>
                <p class="fs-6 mt-3 fw-light">
                    {{ $comment->content }}
                </p>
            </div>
        </div>
        @endforeach
    </form>
</div>
