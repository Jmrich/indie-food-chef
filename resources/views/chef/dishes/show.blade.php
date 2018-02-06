@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-6 col-md-offset-3">
        <div class="panel-heading">
            <p class="panel-title">{{ $dish->name }}&nbsp;
                <a href="{{ route('dishes.edit', [$dish]) }}" title="Edit the dish">
                    <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                </a>
            </p>
            {{--<button type="button" class="btn btn-default">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>--}}
        </div>
        <div class="panel-body">
            <p><strong>Description</strong>: {{ $dish->description }}</p>
            <p><strong>Price</strong>: {{ $dish->price/100 }}</p>
            <p><strong>Additional Cost</strong>: {{ $dish->extra_cost }}</p>
            <p><strong>Archived</strong>: {{ $dish->is_archived ? 'Yes' : 'No' }}</p>
            <p><strong>Image:</strong><img class="img-responsive" src="{{ asset($dish->image_url) }}"></p>
            <p><a href="{{ route('dishes.index') }}" class="btn btn-primary">Back</a> </p>
        </div>
    </div>
@endsection