@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            すべての質問
                        </a>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">質問する</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include ('layouts._messages')

                    @forelse ($questions as $question)
                        @include('questions._excerpt')
                    <!-- 質問がないとき -->
                    @empty
                        <div class="alert alert-warning">
                            まだ質問がありません
                        </div>
                    @endforelse

                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection