@extends('layouts.app')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success col-md-6 col-md-offset-3">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="panel panel-default col-md-6 col-md-offset-3">
        <div class="panel-heading">
            <p class="panel-title">{{ $menu->name }}&nbsp;
                <a href="{{ route('menus.edit', [$menu]) }}" title="Edit the menu">
                    <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                </a>
            </p>
        </div>
        <div class="panel-body">
            @if($menu->dishes->isEmpty())
                <div>
                    This menu does not have any dishes attached to it.
                </div>
            @else
                <h4>Dishes</h4>
                <hr>
                @foreach($menu->dishes as $dish)
                    <dl class="dl-horizontal">
                        <dt>{{ $dish->name }}</dt>
                        <dd>{{ $dish->description }}</dd>
                    </dl>
                @endforeach
            @endif
            <p><a href="{{ route('menus.index') }}" class="btn btn-primary">Back</a> </p>
        </div>
    </div>
@endsection