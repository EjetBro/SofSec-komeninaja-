@extends('layout.layout')

@section('content')
    <div class="row">
        <div class="col-6">
            <h4>Welcome, {{ Auth::user()->name }}!</h4>

            @if (Auth::user()->profile_picture)
                <?php $imagePath = asset('storage/' . Auth::user()->profile_picture); ?>
                <img src="{{ $imagePath }}" alt="Profile Picture" width="150" height="150" class="rounded-circle">
            @else
                <p>You have not uploaded a profile picture yet.</p>
            @endif

            <ul>
                <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                <li><strong>Joined on:</strong> {{ Auth::user()->created_at->format('d-m-Y') }}</li>
            </ul>

            <hr>

            <form action="{{ route('user.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
@endsection
