@extends('layout.layout')
@section('content')
    <div class="container-fluid py-2">
        <div class="row justify-content-center">

            <div class="col-50">
                <div class="row justify-content-center">
                    @include('shared.success-massage')
                    @foreach ($ideas as $idea)
                    <div class="col-md-6 col-lg-4 mb-4">
                        @include('shared.idea-card', ['user' => $idea->user])
                    </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $ideas->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection

