@extends('layouts.app')

@section('content')

    <div class="row">
        {{--<div class="col-md-2">
            <!--sidebar-->
            <div class="">
                <ul class="nav nav-list">
                    <li><a href="#">Filters</a></li>
                    <li><a href="#">Responsive</a></li>
                    <li><a href="#">Layouts</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Bootstrap</a></li>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Modal</a></li>
                    <li><a href="#">Carousel</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Typeahead</a></li>
                    <li><a href="#">Themes</a></li>
                    <li><a href="#">Template</a></li>
                    <li><a href="#">Affix</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Bootstrap 3</a></li>
                    <li><a href="#">Sidebar</a></li>
                    <li><a href="#">Grid</a></li>
                    <li><a href="#">Column</a></li>
                </ul>
            </div>
        </div>--}}

        <div class="col-md-10 col-md-offset-1 main" style="background-color: white">
            <h1 class="page-header">Kitchens Found</h1>
            <kitchen-list :kitchens="{{ $kitchens }}" inline-template>
                <div id="kitchen-list">
                    <template v-for="kitchen in kitchens">
                        <a :href="getHref(kitchen)">
                            <div class="row">
                                <div class="pull-left" style="padding-right: 20px">
                                    <!-- Kitchen image -->
                                    {{--<img src="http://lorempixel.com/200/200/food" class="img-responsive" width="100" height="100">--}}
                                </div>
                                <div class="col-md-3" style="padding-bottom: 10px">
                                    @{{ kitchen.name }}
                                    <div class="row" style="margin: 0">
                                        Kitchen categories
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </a>
                    </template>
                </div>
            </kitchen-list>
        </div>
    </div>

@endsection