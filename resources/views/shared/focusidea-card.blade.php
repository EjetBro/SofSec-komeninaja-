<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                @if ($idea->user->profile_picture)
                    <img src="{{ asset('storage/' . $idea->user->profile_picture) }}" alt="{{ $idea->user->name }}'s Avatar" class="rounded-circle me-2" width="50" height="50">
                @else
                    <img src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $idea->user->name }}" alt="{{ $idea->user->name }} Avatar" class="rounded-circle me-2" width="50" height="50">
                @endif

                <div>
                    <h5 class="card-title mb-0">{{ $idea->user->name }}</h5>
                </div>
            </div>
            <div>
                @if(auth()->id() === $idea->user_id)
                <form method="POST" action="{{ route('idea.destroy', $idea->id) }}">
                    @csrf
                    @method('delete')
                    <a href="{{ route('idea.edit', $idea->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <button class="ms-3 btn btn-danger btn-sm">Delete</button>
                </form>
            @elseif(auth()->user()->is_admin)
                <form method="POST" action="{{ route('idea.destroy', $idea->id) }}">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            @endif

            </div>
        </div>
    </div>

    <div class="card-body">
        @if($editing ?? false)
            <form action="{{ route('idea.update', $idea->id) }}" method="post">
                @csrf
                @method("put")
                <div class="mb-3">
                    <textarea name="content" class="form-control" id="content" rows="3">{{ $idea->content }}</textarea>
                    @error('content')
                        <span class="d-block fs-6 text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <button type="submit" class="btn btn-dark mb-2">Share</button>
                </div>
            </form>
        @else
            <p class="fs-6 fw-light text-muted">
                {{ $idea->content }}
            </p>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                @php
                    $userLiked = $idea->likes()->where('user_id', auth()->id())->exists();
                @endphp
                <form action="{{ route('idea.like', $idea->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="fw-light nav-link fs-6 btn btn-link">
                        <span class="fas fa-heart me-1 {{ $userLiked ? 'text-danger' : '' }}"></span>
                        {{ $idea->likes()->count() }}
                    </button>
                </form>
            </div>
            <div>
                <span class="fs-6 fw-light text-muted">
                    <span class="fas fa-clock"></span>{{ $idea->created_at->format('d-m-Y H:i') }}
                </span>
            </div>
        </div>
        @include('shared.comments-box')
    </div>
</div>
