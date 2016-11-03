@extends('layouts.app')

@section('content')
    <div class="panel panel-default col-md-8 col-md-offset-2">
        <div class="panel-heading">
            <h3 class="panel-title">Create New Menu</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" action="{{ route('menus.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" placeholder="Menu name">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label">Description</label>

                    <div class="col-md-6">
                        <textarea class="form-control" name="description" placeholder="Menu description"></textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                {{--<div class="form-group">
                    <label class="col-md-3 control-label">Active?</label>
                    <div class="col-md-6">
                        <label class="radio-inline">
                            <input type="radio" value="0" name="active" checked />No
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="1" name="active" />Yes
                        </label>
                    </div>
                </div>--}}
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-3">
                        <a href="{{ route('menus.index') }}" class="btn btn-danger">Cancel</a>
                        <button class="btn btn-success" type="submit">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection