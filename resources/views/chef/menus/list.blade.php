@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-6 col-md-offset-3">
        <div class="panel-heading">
            <ul class="list-inline">
                <li>Menu</li>
                {{--<li>|</li>
                <li><a href="{{ route('menus.create') }}">New Menu</a></li>--}}
            </ul>
        </div>
        <table class="table">
            @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td><a href="{{ route('menus.show', [$menu]) }}">Details</a> </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection