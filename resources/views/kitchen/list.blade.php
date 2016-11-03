@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1 main" style="background-color: white">
            <h2 class="page-header">Kitchens</h2>
            <div id="kitchen-list">
                @foreach($kitchens as $kitchen)
                    <a href="{{url('kitchens/' . $kitchen->slug)}}">
                        <div class="row">
                            <div class="pull-left" style="padding-right: 20px">
                                <!-- Kitchen image -->
                                {{--<img src="http://lorempixel.com/200/200/food" class="img-responsive" width="100" height="100">--}}
                            </div>
                            <div class="col-md-3" style="padding-bottom: 10px">
                                {{ $kitchen->name }}
                                <div class="row" style="margin: 0">
                                    Kitchen categories
                                </div>
                            </div>
                        </div>
                        <hr>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

@endsection