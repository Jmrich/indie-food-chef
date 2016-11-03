@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-6 col-md-offset-3">
        <div class="panel-heading">
            <ul class="list-inline panel-title">
                <li>Dishes</li>
                <li>|</li>
                <li><a href="{{ route('dishes.create') }}" class="btn btn-primary btn-sm">New Dish</a> </li>
            </ul>
        </div>
        <table class="table">
            @foreach($dishes as $dish)
                <tr>
                    <td>{{ $dish->name }}</td>
                    <td><a href="{{ route('dishes.show', [$dish]) }}">Details</a> </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection