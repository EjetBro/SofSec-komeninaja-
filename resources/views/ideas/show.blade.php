@extends('layout.layout')
@section('content')
    <div class="container-fluid py-2">
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="row justify-content-center">
                    @include('shared.success-massage')

                    <div class="col-12 mb-4">
                        @include('shared.focusidea-card')
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
