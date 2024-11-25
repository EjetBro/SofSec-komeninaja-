<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                @if ($idea->user->profile_picture)
                    <img src="{{ asset('storage/' . $idea->user->profile_picture) }}"
                         alt="{{ $idea->user->name }}'s Avatar"
                         class="rounded-circle me-2" width="50" height="50">
                @else
                    <img src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $idea->user->name }}"
                         alt="{{ $idea->user->name }} Avatar"
                         class="rounded-circle me-2" width="50" height="50">
                @endif
                <div>
                    <h5 class="card-title mb-0">{{ $idea->user->name }}</h5>
                </div>
            </div>
            <div>
                <a href="{{ route('idea.show', $idea->id )}}">View</a>
                @can('delete', $idea)
                    <form method="POST" action="{{ route('idea.destroy', $idea->id) }}" class="d-inline">
                        @csrf
                        @method('delete')
                        <button class="ms-3 btn btn-danger btn-sm"> Delete </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="fs-6 fw-light text-muted">
            {{$idea->content}}
        </p>
        <div class="d-flex justify-content-between align-items-end">
            @php
                $userLiked = $idea->likes()->where('user_id', auth()->id())->exists();
            @endphp
            <form action="{{ route('idea.like', $idea->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="fw-light nav-link fs-6 btn btn-link">
                    <span class="fas fa-heart me-1 {{ $userLiked ? 'text-danger' : '' }}"></span>
                    {{ $idea->likes_count }}
                </button>
            </form>
            <span class="fs-6 fw-light text-muted text-end">
                <span class="fas fa-clock"></span> {{ $idea->created_at->format('d-m-Y H:i') }}
            </span>
        </div>

    </div>
</div>
